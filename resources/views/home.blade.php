@extends('layouts.master')
@section('content')
    {{-- Home Page  --}}
    <div class="card shadow-sm mt-6">
        <div class="card-header">
            <div class="card-title">
                <h1>{{ __('translate.dashboard') }}</h1>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                            <h4>{{ __('translate.collection of books') }}:</h4>
                           <b> {{ $books }} :</b> {{ __('translate.books') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                            <h4>{{ __('translate.collection of academic articals') }}:</h4>
                            <b>{{ $academic_articals }} :</b> {{ __('translate.academic articals') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                            <h4>{{ __('translate.collection of research articals') }}:</h4>
                            <b>{{ $research_articals }} :</b> {{ __('translate.research articals') }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="mt-5">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mt-5">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection



@section('scripts')

<script src = "{{ asset('assets/plugins/custom/chart/chart.js') }}"></script>

<script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['{{ __('translate.books') }}', '{{ __('translate.academic articals') }}', '{{ __('translate.research articals') }}'],
                datasets: [{
                    label: '{{ __('translate.books and articals') }}',
                    data: [{{ $books }}, {{ $academic_articals }}, {{ $research_articals }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });



</script>

<script>
        const pieChart = document.getElementById('chart');
        new Chart(pieChart, {
            type: 'pie',
            data: {
                labels: ['{{ __('translate.books') }}', '{{ __('translate.academic articals') }}', '{{ __('translate.research articals') }}'],
                datasets: [{
                    label: '{{ __('translate.books and articals') }}',
                    data: [{{ $books }}, {{ $academic_articals }}, {{ $research_articals }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });



</script>
@endsection
