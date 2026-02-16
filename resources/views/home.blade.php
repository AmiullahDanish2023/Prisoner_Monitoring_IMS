@extends('layouts.master')
<style>
    .chart-box {
        height: 280px;
        
    }

    .chart-box canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>
>
@section('content')
    <div class="container-fluid">

        {{-- ================= KPI CARDS ================= --}}
        <div class="row g-4 mb-6">

            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>ټول بندیان</h6>
                        <h2 class="fw-bold">{{ $totalPrisoners }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>نارینه</h6>
                        <h2 class="fw-bold">{{ $maleCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>ښځینه</h6>
                        <h2 class="fw-bold">{{ $femaleCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>اطفال</h6>
                        <h2 class="fw-bold">{{ $childrenCount }}</h2>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= CHARTS ================= --}}
        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-md-6">

                {{-- Status Bar --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">د بندیانو حالت</h6>
                        <div class="chart-box">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Livelihood --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">   بدل اعاشه میاشتني مصرف</h6>
                        <div class="chart-box">
                            <canvas id="livelihoodChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h6 class="mb-3">جنسیت</h6>

                        <div class="chart-box flex-grow-1">
                            <canvas id="genderChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>



        </div>
    @endsection



    @section('scripts')
        <script src="{{ asset('assets/plugins/custom/chart/chart.js') }}"></script>

        <script>
            /* ================== COMMON COLORS ================== */
            const primaryBlue = '#0d6efd';
            const successGreen = '#198754';
            const lightBlue = 'rgba(13,110,253,0.15)';
            const lightGreen = 'rgba(25,135,84,0.15)';

            /* ================== Status Bar ================== */
            new Chart(document.getElementById('statusChart'), {
                type: 'bar',
                data: {
                    labels: ['په نظارت کې مظنونین', 'خلاص شوي مظنونین'],
                    datasets: [{
                        label: 'شمېر',
                        data: [{{ $detainedCount }}, {{ $releasedCount }}],
                        backgroundColor: [primaryBlue, successGreen],
                        borderRadius: 6,
                        maxBarThickness: 60
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#212529',
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e9ecef'
                            }
                        }
                    }
                }
            });

            /* ================== Gender Donut ================== */
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['نارینه', 'ښځینه', 'اطفال'],
                    datasets: [{
                        data: @json($genderChart),
                        backgroundColor: [primaryBlue, '#d63384', '#fd7e14'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    devicePixelRatio: 2,
                    cutout: '45%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 18
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let value = context.raw;
                                    let percent = ((value / total) * 100).toFixed(1);
                                    return context.label + ' : ' + percent + '%';
                                }
                            }
                        }
                    }
                }
            });

            /* ================== Livelihood Line ================== */
            new Chart(document.getElementById('livelihoodChart'), {
                type: 'line',
                data: {
                    labels: @json($livelihoodLabels),
                    datasets: [{
                        label: 'AFN',
                        data: @json($livelihoodTotals),
                        borderColor: primaryBlue,
                        backgroundColor: lightBlue,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: primaryBlue
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: '#212529',
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e9ecef'
                            }
                        }
                    }
                }
            });
        </script>
    @endsection
