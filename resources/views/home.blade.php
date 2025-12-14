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
 


</script>

<script>
     



</script>
@endsection
