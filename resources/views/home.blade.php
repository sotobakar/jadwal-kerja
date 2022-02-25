@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="pt-4 col-12">
            <h1 class="m-0">Dashboard</h1>
        </div>
    </div>
    @can('view-all-schedules')
    <div class="mt-4 row">
        <div class="col-12">
            <h2>Minggu Ini</h2>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $week['overtime'] }}</h3>
                    <p>Shift lembur</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $week['leave'] }}</h3>
                    <p>Shift cuti</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="mt-4 row">
        <div class="col-12">
            <h2>Bulan ini</h2>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $month['overtime'] }}</h3>
                    <p>Shift lembur</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $month['leave'] }}</h3>
                    <p>Shift cuti</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection