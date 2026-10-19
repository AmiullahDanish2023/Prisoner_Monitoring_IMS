<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\BillImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;




class BillController extends Controller
{

    /**
     * شمسي نېټه میلادي ته اړول
     */
    public function toGregorian($date)
    {
        try {
            $date = trim(str_replace('/', '-', $date));

            return Jalalian::fromFormat('Y-m-d', $date)
                ->toCarbon()
                ->toDateString();
        } catch (\Throwable $e) {
            \Log::error('د شمسي نېټې تبدیلۍ تېروتنه', [
                'input_date' => $date,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }


    // د میلادي نیټه شمسی ته بدلول - یوازې تاریخ
    public function toJalali($date)
    {
        try {
            // که چیرې $date د Carbon شی وي
            if ($date instanceof \Carbon\Carbon) {
                return Jalalian::fromCarbon($date)->format('Y/m/d');
            }
            // که چیرې $date د string وي
            if (is_string($date)) {
                $carbon = \Carbon\Carbon::parse($date);
                return Jalalian::fromCarbon($carbon)->format('Y/m/d');
            }
            return $date;
        } catch (\Exception $e) {
            return $date;
        }
    }

    /**
     * د بیلونو لیست
     */
    public function index(Request $request)
    {
        $query = Bill::with(['items', 'images', 'user']);

        // د تاریخ فلتر
        if ($request->filled('start_date')) {
            $startDate = $this->toGregorian($request->start_date);
            $query->whereDate('bill_date', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = $this->toGregorian($request->end_date);
            $query->whereDate('bill_date', '<=', $endDate);
        }

        // د دوکان فلتر
        if ($request->filled('shop_name')) {
            $query->where('shop_name', 'like', '%' . $request->shop_name . '%');
        }

        // د جنس فلتر
        if ($request->filled('item_name')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->item_name . '%');
            });
        }

        // د میاشتې فلتر
        if ($request->filled('year') && $request->filled('month')) {
            $query->whereYear('bill_date', $request->year)->whereMonth('bill_date', $request->month);
        }

        $bills = $query->latest()->paginate(20);

        // د بیل نیټې شمسی کول
        foreach ($bills as $bill) {
            $bill->bill_date_jalali = $this->toJalali($bill->bill_date);
        }

        // د مجموعي احصایې محاسبه
        $statistics = [
            'total_bills' => $query->count(),
            'total_amount' => $query->sum('total_amount') ?? 0,
            'average_amount' => $query->avg('total_amount') ?? 0,
            'total_shops' => $query->distinct('shop_name')->count('shop_name'),
        ];

        // د شمسي کلونو لیست
        $years = [];

        $allDates = Bill::select('bill_date')
            ->whereNotNull('bill_date')
            ->orderBy('bill_date', 'desc')
            ->pluck('bill_date');

        foreach ($allDates as $date) {

            $jalaliYear = Jalalian::fromCarbon(
                \Carbon\Carbon::parse($date)
            )->getYear();

            $years[$jalaliYear] = $jalaliYear;
        }

        // له لوی کال څخه کوچني ته
        krsort($years);

        // یوازې values
        $years = array_values($years);

        // د شمسی میاشتو لیست
        $jalaliMonths = [
            1 => 'حمل',
            2 => 'ثور',
            3 => 'جوزا',
            4 => 'سرطان',
            5 => 'اسد',
            6 => 'سنبله',
            7 => 'میزان',
            8 => 'عقرب',
            9 => 'قوس',
            10 => 'جدی',
            11 => 'دلو',
            12 => 'حوت'
        ];

        return view('goods_invoices.index', compact('bills', 'statistics', 'years', 'jalaliMonths'));
    }

    /**
     * د بیل ذخیره کول
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_number' => 'required|string|max:255|unique:bills,bill_number',
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'nullable|string|max:500',
            'shop_phone' => 'nullable|string|max:20',
            'bill_date' => 'required|string',
            'payment_method' => 'required|in:cash,credit,card',
            'responsible_person' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // بیل جوړول
            $bill = Bill::create([
                'bill_number' => $request->bill_number,
                'shop_name' => $request->shop_name,
                'shop_address' => $request->shop_address,
                'shop_phone' => $request->shop_phone,
                'bill_date' => $this->toGregorian($request->bill_date),
                'payment_method' => $request->payment_method,
                'responsible_person' => $request->responsible_person,
                'note' => $request->note,
                'status' => 'active',
                'user_id' => Auth::id(),
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            // اجناس ثبتول
            foreach ($request->items as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['unit_price'];

                BillItem::create([
                    'bill_id' => $bill->id,
                    'item_name' => $itemData['item_name'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemTotal,
                    'description' => $itemData['description'] ?? null,
                    'category' => $itemData['category'] ?? null,
                ]);

                $totalAmount += $itemTotal;
            }

            // د بیل مجموعي قیمت تازه کول
            $bill->update(['total_amount' => $totalAmount]);

            // عکسونه ذخیره کول
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('bills/' . $bill->id, 'public');

                    BillImage::create([
                        'bill_id' => $bill->id,
                        'image_path' => $path,
                        'image_name' => $image->getClientOriginalName(),
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'بیل په بریالیتوب سره ثبت شو',
                'bill' => $bill->load(['items', 'images'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'تېروتنه رامنځته شوه: ' . $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $bill = Bill::with(['items', 'images', 'user'])->findOrFail($id);

        // د تاریخ یوازې د تاریخ برخه واخلئ
        $bill->bill_date_jalali = $this->toJalali($bill->bill_date);

        return response()->json($bill);
    }

    /**
     * د بیل لیست - د DataTables لپاره (AJAX)
     */
    /**
     * د بیل لیست - د DataTables لپاره (AJAX)
     */
    public function list(Request $request)
    {
        $query = Bill::with(['items', 'images', 'user']);

        // ==========================================
        // د فلټرونو تطبیق
        // ==========================================

        // د تاریخ فلټر (له نېټې)
        if ($request->filled('start_date')) {
            $startDate = $this->toGregorian($request->start_date);
            if ($startDate) {
                $query->whereDate('bill_date', '>=', $startDate);
            }
        }

        // د تاریخ فلټر (تر نېټې)
        if ($request->filled('end_date')) {
            $endDate = $this->toGregorian($request->end_date);
            if ($endDate) {
                $query->whereDate('bill_date', '<=', $endDate);
            }
        }

        // د دوکان فلټر
        if ($request->filled('shop_name')) {
            $query->where('shop_name', 'like', '%' . $request->shop_name . '%');
        }

        // د کال فلټر
        if ($request->filled('year')) {
            $query->whereYear('bill_date', $request->year);
        }

        // د میاشت فلټر
        if ($request->filled('month')) {
            $query->whereMonth('bill_date', $request->month);
        }

        // ==========================================
        // د DataTables لپاره ډاټا
        // ==========================================
        return DataTables::of($query)
            ->addIndexColumn()

            // ==========================================
            // د بیل نیټې شمسی کول
            // ==========================================
            ->addColumn('bill_date_jalali', function ($row) {
                return $this->toJalali($row->bill_date);
            })

            // ==========================================
            // ⭐ د اجناسو شمېر - د اعشاري سمون سره
            // ==========================================
            ->addColumn('items_count', function ($row) {
                $totalQuantity = $row->items->sum('quantity');

                if (floor($totalQuantity) == $totalQuantity) {
                    return (int) $totalQuantity;
                }

                return rtrim(rtrim(number_format($totalQuantity, 3, '.', ''), '0'), '.');
            })

            // ==========================================
            // د تادیې طریقه
            // ==========================================
            ->addColumn('payment_method_badge', function ($row) {
                if ($row->payment_method == 'cash') {
                    return '<span class="badge bg-success">نقد</span>';
                } elseif ($row->payment_method == 'credit') {
                    return '<span class="badge bg-warning text-dark">پور</span>';
                } elseif ($row->payment_method == 'card') {
                    return '<span class="badge bg-info">کارت</span>';
                }
                return '';
            })

            // ==========================================
            // د حالت بیج
            // ==========================================
            ->addColumn('status_badge', function ($row) {
                if ($row->status == 'active') {
                    return '<span class="badge bg-success">فعال</span>';
                } else {
                    return '<span class="badge bg-danger">لغو شوی</span>';
                }
            })

            // ==========================================
            // د بیل نمبر
            // ==========================================
            ->editColumn('bill_number', function ($row) {
                return '<strong>' . $row->bill_number . '</strong>';
            })

            // ==========================================
            // د دوکان نوم
            // ==========================================
            ->editColumn('shop_name', function ($row) {
                $html = $row->shop_name;
                if ($row->shop_phone) {
                    $html .= '<br><small class="text-muted">' . $row->shop_phone . '</small>';
                }
                return $html;
            })

            // ==========================================
            // ⭐ د مجموعي قیمت - د اعشاري سمون سره
            // ==========================================
            ->editColumn('total_amount', function ($row) {
                $amount = $row->total_amount;

                if (floor($amount) != $amount) {
                    return '<strong>' . number_format($amount, 2) . '</strong>';
                }

                return '<strong>' . number_format((int) $amount) . '</strong>';
            })

            // ==========================================
            // د عمل بټنونه - د اجازو سره
            // ==========================================
            ->addColumn('action', function ($row) {
                $btn = '<div class="action-buttons">';

                // ==========================================
                // 1. View Button - د کتلو اجازه
                // ==========================================
                if (auth()->user()->can('View Goods Invoice Details')) {
                    $btn .= '<a href="javascript:void(0)" 
                            class="view-btn btn btn-outline-primary btn-sm" 
                            data-title="کتل"
                            onclick="viewBill(' . $row->id . ')"
                            style="cursor: pointer; display:inline-flex; align-items:center; gap:6px;">
                            <i class="bi bi-eye"></i>
                        </a>';
                }

                // ==========================================
                // 2. Edit Button - د سمولو اجازه
                // ==========================================
                if (auth()->user()->can('Edit Goods Invoice')) {
                    $btn .= '<a href="javascript:void(0)" 
                            class="edit-btn btn btn-outline-info btn-sm" 
                            data-title="سمول"
                            onclick="editBill(' . $row->id . ')"
                            style="cursor: pointer; display:inline-flex; align-items:center; gap:6px;">
                            <i class="bi bi-pencil"></i>
                        </a>';
                }

                // ==========================================
                // 3. Status Toggle Button - د حالت بدلولو اجازه
                // ==========================================
                if (auth()->user()->can('Change Goods Invoice Status')) {
                    if ($row->status == 'active') {
                        $btn .= '<a href="javascript:void(0)" 
                                class="status-btn btn btn-outline-warning btn-sm" 
                                data-title="لغو کول"
                                onclick="changeStatus(' . $row->id . ', \'cancelled\')"
                                style="cursor: pointer; display:inline-flex; align-items:center; gap:6px;">
                                <i class="bi bi-x-circle"></i>
                            </a>';
                    } else {
                        $btn .= '<a href="javascript:void(0)" 
                                class="status-btn active-status btn btn-outline-success btn-sm" 
                                data-title="فعال کول"
                                onclick="changeStatus(' . $row->id . ', \'active\')"
                                style="cursor: pointer; display:inline-flex; align-items:center; gap:6px;">
                                <i class="bi bi-check-circle"></i>
                            </a>';
                    }
                }

                // ==========================================
                // 4. Delete Button - د حذف اجازه
                // ==========================================
                if (auth()->user()->can('Delete Goods Invoice')) {
                    $btn .= '<a href="javascript:void(0)" 
                            class="destroy_btn btn btn-outline-danger btn-sm" 
                            data-title="حذف"
                            onclick="deleteBill(' . $row->id . ')">
                            <i class="bi bi-trash"></i>
                        </a>';
                }

                $btn .= '</div>';

                return $btn;
            })

            ->rawColumns(['action', 'payment_method_badge', 'status_badge', 'total_amount', 'bill_number', 'shop_name'])
            ->make(true);
    }

    /**
     * د بیل سمول (Edit form)
     */
    public function edit($id)
    {
        $bill = Bill::with(['items', 'images'])->findOrFail($id);
        $bill->bill_date_jalali = $this->toJalali($bill->bill_date);
        return response()->json($bill);
    }

    /**
     * د بیل تازه کول
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bill_number' => 'required|string|max:255|unique:bills,bill_number,' . $id,
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'nullable|string|max:500',
            'shop_phone' => 'nullable|string|max:20',
            'bill_date' => 'required|string',
            'payment_method' => 'required|in:cash,credit,card',
            'responsible_person' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $bill = Bill::findOrFail($id);

            $bill->update([
                'bill_number' => $request->bill_number,
                'shop_name' => $request->shop_name,
                'shop_address' => $request->shop_address,
                'shop_phone' => $request->shop_phone,
                'bill_date' => $this->toGregorian($request->bill_date),
                'payment_method' => $request->payment_method,
                'responsible_person' => $request->responsible_person,
                'note' => $request->note,
            ]);

            // زاړه اجناس حذف کول
            $bill->items()->delete();

            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['unit_price'];

                BillItem::create([
                    'bill_id' => $bill->id,
                    'item_name' => $itemData['item_name'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemTotal,
                    'description' => $itemData['description'] ?? null,
                    'category' => $itemData['category'] ?? null,
                ]);

                $totalAmount += $itemTotal;
            }

            $bill->update(['total_amount' => $totalAmount]);

            // نوي عکسونه اضافه کول
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('bills/' . $bill->id, 'public');

                    BillImage::create([
                        'bill_id' => $bill->id,
                        'image_path' => $path,
                        'image_name' => $image->getClientOriginalName(),
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'بیل په بریالیتوب سره تازه شو',
                'bill' => $bill->load(['items', 'images'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'تېروتنه رامنځته شوه: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * د بیل حذف کول
     */

    public function destroy($id)
    {
        try {
            // د بیل موندل (د حذف شوي بیلونو په شمول)
            $bill = Bill::withTrashed()->with('images', 'items')->findOrFail($id);

            // ==========================================
            // 1. د عکسونو فزیکي فایلونه حذف کول
            // ==========================================
            foreach ($bill->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                // د عکس ریکارډ په بشپړه توګه حذف کول
                $image->forceDelete();
            }

            // ==========================================
            // 2. د اجناسو ریکارډونه حذف کول
            // ==========================================
            foreach ($bill->items as $item) {
                $item->forceDelete();
            }

            // ==========================================
            // 3. د بیل ریکارډ په بشپړه توګه حذف کول
            // ==========================================
            $bill->forceDelete();

            // که د AJAX غوښتنه وي
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'بیل په بریالیتوب سره حذف شو'
                ]);
            }

            // که د عادي غوښتنه وي
            return redirect()->route('bills.index')
                ->with('success', 'بیل په بریالیتوب سره حذف شو');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'تېروتنه رامنځته شوه: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('bills.index')
                ->with('error', 'تېروتنه رامنځته شوه: ' . $e->getMessage());
        }
    }
    /**
     * د عکس حذف کول
     */
    public function deleteImage($id)
    {
        try {
            $image = BillImage::findOrFail($id);
            Storage::disk('public')->delete($image->image_path);
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'عکس په بریالیتوب سره حذف شو'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'تېروتنه رامنځته شوه'
            ], 500);
        }
    }

    /**
     * د بیل حالت بدلول
     */
    public function changeStatus($id, $status)
    {
        try {
            $bill = Bill::findOrFail($id);
            $bill->update(['status' => $status]);

            return response()->json([
                'success' => true,
                'message' => 'د بیل حالت بدل شو'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'تېروتنه رامنځته شوه'
            ], 500);
        }
    }



    //بیل راپورونه
    /**
     * د راپور لومړنی صفحه
     */
    public function reports(Request $request)
    {
        // د شمسي کلونو لیست
        $years = [];
        $allDates = Bill::select('bill_date')
            ->whereNotNull('bill_date')
            ->orderBy('bill_date', 'desc')
            ->pluck('bill_date');

        foreach ($allDates as $date) {
            $jalaliYear = Jalalian::fromCarbon(\Carbon\Carbon::parse($date))->getYear();
            $years[$jalaliYear] = $jalaliYear;
        }
        krsort($years);
        $years = array_values($years);

        // د شمسي میاشتو لیست
        $jalaliMonths = [
            1 => 'حمل',
            2 => 'ثور',
            3 => 'جوزا',
            4 => 'سرطان',
            5 => 'اسد',
            6 => 'سنبله',
            7 => 'میزان',
            8 => 'عقرب',
            9 => 'قوس',
            10 => 'جدی',
            11 => 'دلو',
            12 => 'حوت'
        ];

        // د دوکانونو لیست
        $shops = Bill::select('shop_name')
            ->distinct()
            ->orderBy('shop_name')
            ->pluck('shop_name');

        // د جنسونو لیست
        $itemsList = BillItem::select('item_name')
            ->distinct()
            ->orderBy('item_name')
            ->pluck('item_name');

        return view('goods_invoices.reports', compact('years', 'jalaliMonths', 'shops', 'itemsList'));
    }

    public function reportsData(Request $request)
    {
        $query = Bill::with(['items', 'images', 'user']);

        // ==========================================
        // د فلټرونو تطبیق
        // ==========================================

        // د بیل نمبر فلټر
        if ($request->filled('bill_number')) {
            $query->where('bill_number', 'like', '%' . $request->bill_number . '%');
        }

        // د دوکان نوم فلټر
        if ($request->filled('shop_name')) {
            $query->where('shop_name', 'like', '%' . $request->shop_name . '%');
        }

        // د پیل نېټه
        if ($request->filled('start_date')) {
            $startDate = $this->toGregorian($request->start_date);

            if (!$startDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'د پیل نېټه ناسمه ده.',
                ], 422);
            }

            $query->whereDate('bill_date', '>=', $startDate);
        }

        // د پای نېټه
        if ($request->filled('end_date')) {
            $endDate = $this->toGregorian($request->end_date);

            if (!$endDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'د پای نېټه ناسمه ده.',
                ], 422);
            }

            $query->whereDate('bill_date', '<=', $endDate);
        }

        if ($request->filled('year')) {
            $query->whereYear('bill_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('bill_date', $request->month);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // د جنس نوم فلټر
        $filterItemName = $request->get('item_name');
        if ($request->filled('item_name')) {
            $query->whereHas('items', function ($q) use ($filterItemName) {
                $q->where('item_name', 'like', '%' . $filterItemName . '%');
            });
        }

        $reportType = $request->get('report_type', 'summary');

        // ==========================================
        // 1. د ټولیز راپور (Summary) - د جنس فلټر سره
        // ==========================================
        if ($reportType === 'summary') {
            $bills = $query->latest('bill_date')->get();

            foreach ($bills as $bill) {
                $bill->bill_date_jalali = $this->toJalali($bill->bill_date);

                // که د جنس فلټر فعال وي، یوازې هغه جنس وساتئ
                if ($filterItemName) {
                    $bill->setRelation('items', $bill->items->filter(function ($item) use ($filterItemName) {
                        return stripos($item->item_name, $filterItemName) !== false;
                    })->values());

                    // د بیل مجموعي قیمت یوازې د فلټر شوي جنس لپاره
                    $bill->filtered_total = $bill->items->sum('total_price');
                } else {
                    $bill->filtered_total = $bill->total_amount;
                }
            }

            // که د جنس فلټر وي، هغه بیلونه لرې کړه چې فلټر شوی جنس نلري
            if ($filterItemName) {
                $bills = $bills->filter(function ($bill) {
                    return $bill->items->count() > 0;
                })->values();
            }

            $summary = [
                'total_bills' => $bills->count(),
                'total_amount' => $filterItemName
                    ? $bills->sum('filtered_total')
                    : $bills->sum('total_amount'),
                'total_items' => $bills->sum(function ($bill) {
                    return $bill->items->sum('quantity');
                }),
                'total_shops' => $bills->pluck('shop_name')->unique()->count(),
                'active_bills' => $bills->where('status', 'active')->count(),
                'cancelled_bills' => $bills->where('status', 'cancelled')->count(),
                'cash_bills' => $bills->where('payment_method', 'cash')->count(),
                'credit_bills' => $bills->where('payment_method', 'credit')->count(),
                'card_bills' => $bills->where('payment_method', 'card')->count(),
                'average_amount' => $bills->avg('filtered_total') ?? 0,
                'filter_item' => $filterItemName,
            ];

            return response()->json([
                'success' => true,
                'report_type' => 'summary',
                'data' => $bills,
                'summary' => $summary,
            ]);
        }

        // ==========================================
        // 2. د جنس له مخې راپور
        // ==========================================
        if ($reportType === 'items') {
            $billIds = $query->pluck('id');

            $itemsQuery = BillItem::whereIn('bill_id', $billIds);

            // که د جنس فلټر وي، یوازې هغه ښکاره کړه
            if ($filterItemName) {
                $itemsQuery->where('item_name', 'like', '%' . $filterItemName . '%');
            }

            $items = $itemsQuery
                ->select('item_name', 'category')
                ->selectRaw('SUM(quantity) as total_quantity')
                ->selectRaw('SUM(total_price) as total_amount')
                ->selectRaw('COUNT(DISTINCT bill_id) as bill_count')
                ->selectRaw('AVG(unit_price) as avg_price')
                ->groupBy('item_name', 'category')
                ->orderBy('total_amount', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'report_type' => 'items',
                'data' => $items,
                'summary' => [
                    'total_items' => $items->count(),
                    'total_quantity' => $items->sum('total_quantity'),
                    'total_amount' => $items->sum('total_amount'),
                    'filter_item' => $filterItemName,
                ],
            ]);
        }

        // ==========================================
        // 3. د دوکان له مخې راپور
        // ==========================================
        if ($reportType === 'shops') {
            $shops = $query->clone()
                ->select('shop_name', 'shop_phone', 'shop_address')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->selectRaw('AVG(total_amount) as avg_amount')
                ->groupBy('shop_name', 'shop_phone', 'shop_address')
                ->orderBy('total_amount', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'report_type' => 'shops',
                'data' => $shops,
                'summary' => [
                    'total_shops' => $shops->count(),
                    'total_amount' => $shops->sum('total_amount'),
                    'total_bills' => $shops->sum('total_bills'),
                ],
            ]);
        }

        // ==========================================
        // 4. میاشتنی راپور
        // ==========================================
        if ($reportType === 'monthly') {
            $year = $request->get('year', now()->year);

            $monthlyData = Bill::whereYear('bill_date', $year);

            if ($request->filled('shop_name')) {
                $monthlyData->where('shop_name', 'like', '%' . $request->shop_name . '%');
            }
            if ($request->filled('payment_method')) {
                $monthlyData->where('payment_method', $request->payment_method);
            }
            if ($request->filled('status')) {
                $monthlyData->where('status', $request->status);
            }

            $monthlyData = $monthlyData->selectRaw('MONTH(bill_date) as month')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->selectRaw('AVG(total_amount) as avg_amount')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $jalaliMonths = [
                1 => 'حمل',
                2 => 'ثور',
                3 => 'جوزا',
                4 => 'سرطان',
                5 => 'اسد',
                6 => 'سنبله',
                7 => 'میزان',
                8 => 'عقرب',
                9 => 'قوس',
                10 => 'جدی',
                11 => 'دلو',
                12 => 'حوت'
            ];

            $completeData = [];
            for ($i = 1; $i <= 12; $i++) {
                $found = $monthlyData->firstWhere('month', $i);
                $completeData[] = [
                    'month' => $i,
                    'month_name' => $jalaliMonths[$i],
                    'total_bills' => $found ? $found->total_bills : 0,
                    'total_amount' => $found ? $found->total_amount : 0,
                    'avg_amount' => $found ? $found->avg_amount : 0,
                ];
            }

            return response()->json([
                'success' => true,
                'report_type' => 'monthly',
                'data' => $completeData,
                'year' => $year,
                'summary' => [
                    'total_bills' => collect($completeData)->sum('total_bills'),
                    'total_amount' => collect($completeData)->sum('total_amount'),
                ],
            ]);
        }

        // ==========================================
        // 5. د تادیې طریقې له مخې راپور
        // ==========================================
        if ($reportType === 'payment') {
            $paymentData = $query->clone()
                ->select('payment_method')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->groupBy('payment_method')
                ->get();

            $paymentMethods = ['cash' => 'نقد', 'credit' => 'پور', 'card' => 'کارت'];

            $completeData = [];
            foreach ($paymentMethods as $key => $name) {
                $found = $paymentData->firstWhere('payment_method', $key);
                $completeData[] = [
                    'payment_method' => $key,
                    'payment_method_name' => $name,
                    'total_bills' => $found ? $found->total_bills : 0,
                    'total_amount' => $found ? $found->total_amount : 0,
                ];
            }

            return response()->json([
                'success' => true,
                'report_type' => 'payment',
                'data' => $completeData,
                'summary' => [
                    'total_bills' => collect($completeData)->sum('total_bills'),
                    'total_amount' => collect($completeData)->sum('total_amount'),
                ],
            ]);
        }

        // ==========================================
        // 6. د حالت له مخې راپور
        // ==========================================
        if ($reportType === 'status') {
            $statusData = $query->clone()
                ->select('status')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->groupBy('status')
                ->get();

            $statuses = ['active' => 'فعال', 'cancelled' => 'لغو شوی'];

            $completeData = [];
            foreach ($statuses as $key => $name) {
                $found = $statusData->firstWhere('status', $key);
                $completeData[] = [
                    'status' => $key,
                    'status_name' => $name,
                    'total_bills' => $found ? $found->total_bills : 0,
                    'total_amount' => $found ? $found->total_amount : 0,
                ];
            }

            return response()->json([
                'success' => true,
                'report_type' => 'status',
                'data' => $completeData,
                'summary' => [
                    'total_bills' => collect($completeData)->sum('total_bills'),
                    'total_amount' => collect($completeData)->sum('total_amount'),
                ],
            ]);
        }

        // ==========================================
        // 7. د عکسونو راپور
        // ==========================================

        if ($reportType === 'images') {
            $billIds = $query->pluck('id');

            $images = BillImage::whereIn('bill_id', $billIds)
                ->with('bill')
                ->orderBy('bill_id')
                ->orderBy('is_primary', 'desc')
                ->get();

            // ⭐ دا برخه اضافه کړئ
            foreach ($images as $image) {
                if ($image->bill) {
                    $image->bill->bill_date_jalali = $this->toJalali($image->bill->bill_date);
                }
            }

            $summary = [
                'total_images' => $images->count(),
                'total_bills' => $images->pluck('bill_id')->unique()->count(),
            ];

            return response()->json([
                'success' => true,
                'report_type' => 'images',
                'data' => $images,
                'summary' => $summary,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'د راپور ډول ونه موندل شو'
        ], 400);
    }

    /**
     * د راپور چاپ - د براوزر لپاره (HTML)
     */
    public function printReport(Request $request)
    {
        // ==========================================
        // د فلټر پوښتنې
        // ==========================================
        $query = Bill::with(['items', 'images', 'user']);

        if ($request->filled('bill_number')) {
            $query->where('bill_number', 'like', '%' . $request->bill_number . '%');
        }
        if ($request->filled('shop_name')) {
            $query->where('shop_name', 'like', '%' . $request->shop_name . '%');
        }
        if ($request->filled('start_date')) {
            $query->whereDate('bill_date', '>=', $this->toGregorian($request->start_date));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('bill_date', '<=', $this->toGregorian($request->end_date));
        }
        if ($request->filled('year')) {
            $query->whereYear('bill_date', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('bill_date', $request->month);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $filterItemName = $request->get('item_name');
        if ($request->filled('item_name')) {
            $query->whereHas('items', function ($q) use ($filterItemName) {
                $q->where('item_name', 'like', '%' . $filterItemName . '%');
            });
        }

        $reportType = $request->get('report_type', 'summary');
        $filterData = $request->all();

        // ==========================================
        // متغیرونه
        // ==========================================
        $bills = collect();
        $items = collect();
        $shops = collect();
        $images = collect();
        $completeData = [];
        $summary = [];

        // ==========================================
        // 1. ټولیز راپور
        // ==========================================
        if ($reportType === 'summary') {
            $bills = $query->latest('bill_date')->get();

            foreach ($bills as $bill) {
                $bill->bill_date_jalali = $this->toJalali($bill->bill_date);

                if ($filterItemName) {
                    $bill->setRelation('items', $bill->items->filter(function ($item) use ($filterItemName) {
                        return stripos($item->item_name, $filterItemName) !== false;
                    })->values());
                    $bill->filtered_total = $bill->items->sum('total_price');
                } else {
                    $bill->filtered_total = $bill->total_amount;
                }
            }

            if ($filterItemName) {
                $bills = $bills->filter(function ($bill) {
                    return $bill->items->count() > 0;
                })->values();
            }

            $summary = [
                'total_bills' => $bills->count(),
                'total_amount' => $filterItemName
                    ? $bills->sum('filtered_total')
                    : $bills->sum('total_amount'),
                'total_items' => $bills->sum(function ($bill) {
                    return $bill->items->sum('quantity');
                }),
                'total_shops' => $bills->pluck('shop_name')->unique()->count(),
            ];
        }
        // 2. د جنس له مخې
        elseif ($reportType === 'items') {
            $billIds = $query->pluck('id');
            $itemsQuery = BillItem::whereIn('bill_id', $billIds);

            if ($filterItemName) {
                $itemsQuery->where('item_name', 'like', '%' . $filterItemName . '%');
            }

            $items = $itemsQuery
                ->select('item_name', 'category')
                ->selectRaw('SUM(quantity) as total_quantity')
                ->selectRaw('SUM(total_price) as total_amount')
                ->selectRaw('COUNT(DISTINCT bill_id) as bill_count')
                ->selectRaw('AVG(unit_price) as avg_price')
                ->groupBy('item_name', 'category')
                ->orderBy('total_amount', 'desc')
                ->get();

            $summary = [
                'total_items' => $items->count(),
                'total_quantity' => $items->sum('total_quantity'),
                'total_amount' => $items->sum('total_amount'),
            ];
        }
        // 3. د دوکان له مخې
        elseif ($reportType === 'shops') {
            $shops = $query->clone()
                ->select('shop_name', 'shop_phone', 'shop_address')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->selectRaw('AVG(total_amount) as avg_amount')
                ->groupBy('shop_name', 'shop_phone', 'shop_address')
                ->orderBy('total_amount', 'desc')
                ->get();

            $summary = [
                'total_shops' => $shops->count(),
                'total_amount' => $shops->sum('total_amount'),
                'total_bills' => $shops->sum('total_bills'),
            ];
        }
        // 4. میاشتنی راپور
        elseif ($reportType === 'monthly') {
            $year = $request->get('year', now()->year);
            $monthlyData = Bill::whereYear('bill_date', $year);

            if ($request->filled('shop_name')) {
                $monthlyData->where('shop_name', 'like', '%' . $request->shop_name . '%');
            }
            if ($request->filled('payment_method')) {
                $monthlyData->where('payment_method', $request->payment_method);
            }
            if ($request->filled('status')) {
                $monthlyData->where('status', $request->status);
            }

            $monthlyData = $monthlyData->selectRaw('MONTH(bill_date) as month')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->selectRaw('AVG(total_amount) as avg_amount')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $jalaliMonths = [
                1 => 'حمل',
                2 => 'ثور',
                3 => 'جوزا',
                4 => 'سرطان',
                5 => 'اسد',
                6 => 'سنبله',
                7 => 'میزان',
                8 => 'عقرب',
                9 => 'قوس',
                10 => 'جدی',
                11 => 'دلو',
                12 => 'حوت'
            ];

            $completeData = [];
            for ($i = 1; $i <= 12; $i++) {
                $found = $monthlyData->firstWhere('month', $i);
                $completeData[] = [
                    'month' => $i,
                    'month_name' => $jalaliMonths[$i],
                    'total_bills' => $found ? $found->total_bills : 0,
                    'total_amount' => $found ? $found->total_amount : 0,
                    'avg_amount' => $found ? $found->avg_amount : 0,
                ];
            }

            $summary = [
                'total_bills' => collect($completeData)->sum('total_bills'),
                'total_amount' => collect($completeData)->sum('total_amount'),
            ];
        }
        // 5. د تادیې طریقې
        elseif ($reportType === 'payment') {
            $paymentData = $query->clone()
                ->select('payment_method')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->groupBy('payment_method')
                ->get();

            $paymentMethods = ['cash' => 'نقد', 'credit' => 'پور', 'card' => 'کارت'];

            $completeData = [];
            foreach ($paymentMethods as $key => $name) {
                $found = $paymentData->firstWhere('payment_method', $key);
                $completeData[] = [
                    'payment_method' => $key,
                    'payment_method_name' => $name,
                    'total_bills' => $found ? $found->total_bills : 0,
                    'total_amount' => $found ? $found->total_amount : 0,
                ];
            }

            $summary = [
                'total_bills' => collect($completeData)->sum('total_bills'),
                'total_amount' => collect($completeData)->sum('total_amount'),
            ];
        }
        // 6. د حالت راپور
        elseif ($reportType === 'status') {
            $statusData = $query->clone()
                ->select('status')
                ->selectRaw('COUNT(*) as total_bills')
                ->selectRaw('SUM(total_amount) as total_amount')
                ->groupBy('status')
                ->get();

            $statuses = ['active' => 'فعال', 'cancelled' => 'لغو شوی'];

            $completeData = [];
            foreach ($statuses as $key => $name) {
                $found = $statusData->firstWhere('status', $key);
                $completeData[] = [
                    'status' => $key,
                    'status_name' => $name,
                    'total_bills' => $found ? $found->total_bills : 0,
                    'total_amount' => $found ? $found->total_amount : 0,
                ];
            }

            $summary = [
                'total_bills' => collect($completeData)->sum('total_bills'),
                'total_amount' => collect($completeData)->sum('total_amount'),
            ];
        }
        // 7. د عکسونو راپور
        elseif ($reportType === 'images') {
            $billIds = $query->pluck('id');

            $images = BillImage::whereIn('bill_id', $billIds)
                ->with('bill')
                ->orderBy('bill_id')
                ->orderBy('is_primary', 'desc')
                ->get();

            // ⭐ دا برخه اضافه کړئ
            foreach ($images as $image) {
                if ($image->bill) {
                    $image->bill->bill_date_jalali = $this->toJalali($image->bill->bill_date);
                }
            }

            $summary = [
                'total_images' => $images->count(),
                'total_bills' => $images->pluck('bill_id')->unique()->count(),
            ];
        }

        // ==========================================
        // د HTML ویو بیرته راکول
        // ==========================================
        return view('goods_invoices.reports-print', compact(
            'bills',
            'items',
            'shops',
            'images',
            'completeData',
            'summary',
            'filterData',
            'filterItemName',
            'reportType'
        ));
    }
}
