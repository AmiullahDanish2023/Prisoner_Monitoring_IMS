@extends('Frontend.layouts.master')
@section('contents')
@section('css')
    <style>
        tbody {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        thead>tr>th,
        .sorting_1 {
            background-color: #F1F7FD !important;
        }
    </style>
@endsection

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center"
    @if (Session::get('locale') != 'en') style="background-image: url('{{ asset('frontend/assets/img/hero-bg.jpg') }}')"
@else
style="background-image: url('{{ asset('frontend/assets/img/hero-bg1.jpg') }}')" @endif>

    <div class="container col-sx-12">
        <span class="me-auto why-us text-center m-2" style="font-size: 25px;">
            {{ $setting->name }}
        </span>
               <h2>
            {{ $setting->main_text }}
        </h2>
        <!-- <a href="#about" class="btn-get-started scrollto">Get Started</a> -->
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
        <div class="container">

            <div class="row">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="content">
                        <span style="font-size: 25px;">{{ $announcemet->title }}</span>
                        <p>
                            {{ $announcemet->description }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="icon-boxes d-flex flex-column justify-content-center">
                        <div class="row">

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-book"></i>

                                    <p>{{ __('translate.third_card_title') }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-receipt"></i>
                                    <p> {{ __('translate.second_card_title') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-receipt"></i>
                                    <p> {{ __('translate.first_card_title') }}</p>
                                </div>
                            </div>


                        </div>
                    </div><!-- End .content-->
                </div>
            </div>

        </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container">

            <div class="row">
                <div class="col-xl-5 col-lg-6  d-flex justify-content-center align-items-stretch position-relative">
                    <img src="{{ asset($about->image) }}" alt="" width="100%" height="auto">
                    <a href="{{ $about->video_link }}" class="glightbox play-btn mb-4"></a>
                </div>
                <div
                    class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <span class="me-auto why-us text-center m-2" style="font-size: 25px">{{ $about->title }}</span>
                    <p>{{ $about->description }} </p>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="fas fa-user-md"></i>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $all_doctors }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>{{ __('translate.doctors') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="far fa-hospital"></i>
                        <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <!-- <p>Departments</p> -->
                        <p>{{ __('translate.departments') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="fas fa-book"></i>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $all_books }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>{{ __('translate.books') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="fas fa-book"></i>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $all_articals }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>{{ __('translate.papers') }}</p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- End Counts Section -->



    <!-- ======= Doctors Section ======= -->
    <section id="doctors" class="doctors">
        <div class="container">

            <div class="section-title">
                <h2>{{ __('translate.doctors') }}</h2>

            </div>

            <div class="row">
                @foreach ($doctors as $doctor)
                    <div class="col-lg-6  mt-4">
                        <div class="member d-flex align-items-start">
                            <div class="pic">
                                <img src="{{ $doctor->image }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info p-4">

                                @if (Session::get('locale') == 'en')
                                    <h4> {{ $doctor->name_en }} </h4>
                                @else
                                    <h4> {{ $doctor->name_pa }} </h4>
                                @endif
                                @if (Session::get('locale') == 'en')
                                    <span> {{ $doctor->specialist_en }} </span>
                                @else
                                    <span> {{ $doctor->specialist_pa }} </span>
                                @endif

                                @if (Session::get('locale') == 'en')
                                    <p> {{ $doctor->about_en }} </p>
                                @else
                                    <p class="mr-3"> {{ $doctor->about_pa }} </p>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
    <!-- End Doctors Section -->


    <!-- ======= Book Section ======= -->
    <section class="book_sectoion" id="books">
        <div class="container mt-2">
            <div class="section-title">
                <h2>{{ __('translate.publication') }}</h2>

            </div>

            <div class="row mb-3 ">
                <div class="col-md-2">
                    <div class="flex gap-12">
                        <label class="form-label flex items-center gap-2.5 text-nowrap">
                            <input class="radio content" name="radio2" type="radio" value="1" />
                            {{-- 1 value for all contents  --}}
                            {{ __('translate.all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="flex gap-12">
                        <label class="form-label flex items-center gap-2.5 text-nowrap">
                            <input class="radio content" name="radio2" type="radio" value="2" />
                            {{-- 2 value for all books  --}}
                            {{ __('translate.books') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label flex items-center gap-2.5 text-nowrap">
                        <input class="radio content" name="radio2" type="radio" value="3" />
                        {{-- 3 value for academic & research articals  --}}
                        {{ __('translate.articals') }}
                    </label>
                </div>
            </div>

            <table id="table_id" class="table yajra-datatable justify-content-center table-responsive">
                <tbody>
                </tbody>
            </table>

    </section>
    <!-- End Book Section -->


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>{{ __('translate.contact') }}</h2>
                <p>{{ __('translate.If you want to contact us, share your name, email and your problem with us.') }}
                </p>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">

                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>{{ __('translate.location') }}:</h4>
                            <p>{{ $setting->location }}</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>{{ __('translate.email') }}:</h4>
                            <p>{{ $setting->email }}</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>{{ __('translate.number') }}:</h4>
                            <p>+93-{{ $setting->number }}</p>
                        </div>

                    </div>

                </div>

                <div class="col-lg-8 mt-5 mt-lg-0">

                    <form method="POST" action="{{ route('contacts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control input"
                                    style="border-radius: 0;  padding: 8px 12px; border: 1px solid #ccc;  font-size: 16px;"
                                    id="name" placeholder="{{ __('translate.your name') }}" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    style="border-radius: 0;  padding: 8px 12px; border: 1px solid #ccc;  font-size: 16px;"
                                    placeholder="{{ __('translate.your email') }}" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject"
                                style="border-radius: 0;  padding: 8px 12px; border: 1px solid #ccc;  font-size: 16px;"
                                placeholder="{{ __('translate.subject') }}">
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="{{ __('translate.message') }}" required></textarea>
                        </div>
                        {{-- <div class="my-3">
                                <div class="loading m-4">{{ __('translate.loading') }}</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div> --}}
                        <div class="text-center"><button class="btn btn-primary mt-3"
                                style="background-color: #166ab5;  padding: 8px 25px; border-radius: 50px;"
                                type="submit">{{ __('translate.send message') }}</button></div>
                    </form>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('.yajra-datatable').DataTable({
            "paging": true,
            "lengthChange": true,
            "info": true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('welcome.index') }}",
            columns: [{
                data: 'card',
            }, ],
            orderable: true,
            searchable: true,
            order: [
                [0, 'decs']
            ],
            pageLength: 8,
            lengthMenu: [
                [8, 12, 50, 100],
                [8, 12, 50, "{{ __('translate.all') }}"]
            ],
            language: {
                "emptyTable": "{{ __('translate.information not exists') }}",
                "lengthMenu": "{{ __('translate.showing') }} _MENU_ {{ __('translate.information') }}",
                "info": "{{ __('translate.from') }} _START_ {{ __('translate.to') }} _END_  {{ __('translate.total information') }} _TOTAL_",
                "infoEmpty": "{{ __('translate.form 0 to 0 - total 0 records') }}",
                "search": "{{ __('translate.search') }}:",
                "sProcessing": "{{ __('translate.under processing') }}",
                "paginate": {
                    "first": "{{ __('first') }}",
                    "last": "{{ __('last') }}",
                    "next": "{{ __('translate.next') }}",
                    "previous": "{{ __('translate.previous') }}"
                },
            },
        });

    });
</script>

<script>
    $(document).ready(function() {
        // Get the value when the checkbox is checked
        $(".content").on("change", function(e) {
            e.preventDefault();

            var table = $('.yajra-datatable').DataTable();
            if ($(this).is(":checked")) {

                var content = $(this).val();
                table.ajax.url("{{ route('welcome.all_books', ':content') }}".replace(':content',
                        content))
                    .load();
            }
        });
    });
</script>
@endsection
