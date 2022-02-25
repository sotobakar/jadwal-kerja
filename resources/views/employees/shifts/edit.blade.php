@extends('adminlte::page')

@section('title', 'Create Employee Shift')

@section('content_header')
<h1 class="text-center">Edit Employee Shift</h1>
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      @if(session()->has('success'))
      <div class="alert alert-success text-center">
        {{ session()->get('success') }}
      </div>
      @elseif (session()->has('error'))
      <div class="alert alert-danger text-center">
        {{ session()->get('error') }}
      </div>
      @endif
      <x-adminlte-card title="Employee Shift Form" theme="light" icon="fas fa-lg fa-bell">
        <form action={{ route('employees.shifts', ['shift_schedule'=> $shift_schedule->id]) }} method="POST">
          @csrf
          @method('PUT')
          <x-adminlte-select2 name="employee" label="Employee" label-class="text-black">
            <option value="">-- Nama Karyawan --</option>
            @foreach ($employees as $employee)
            <option value={{ $employee->id }} {{ $employee->id === $shift_schedule->user->id ? 'selected' : ''}}>{{
              $employee->name }}</option>
            @endforeach
          </x-adminlte-select2>
          <x-adminlte-select2 name="shift" label="Shift" label-class="text-black">
            <option>-- Kode Shift --</option>
            @foreach ($shifts as $shift)
            <option value={{ $shift->id }} {{
              $shift->id === $shift_schedule->shift->id ? 'selected' : ''}}>{{ $shift->code . ' - ' . $shift->start_time
              . ' - ' . $shift->end_time }}
            </option>
            @endforeach
          </x-adminlte-select2>
          @php
          $config = ['format' => 'YYYY-MM-DD'];
          @endphp
          <x-adminlte-input-date name="date" placeholder="2020-07-24" :config="$config" label="Date (YYYY-MM-DD)"
            label-class="text-black" value="{{
            $shift_schedule->schedule->date }}" />

          <x-adminlte-button class="d-flex ml-auto" theme="primary" label="Update" type="submit" />
        </form>
      </x-adminlte-card>
    </div>
    <div class="col-lg-6">
      <x-adminlte-card title="Shift Information" theme="light" icon="fas fa-lg fa-info-circle">
        <dl class="row">
          <dt class="col-sm-4">Nama Shift</dt>
          <dt class="col-sm-8">Waktu Shift</dt>
          @foreach ($shifts as $shift)
          <dt class="col-sm-4">{{ 'Shift' . ' ' . $shift->code }}</dt>
          <dd class="col-sm-8">{{ $shift->start_time . ' - ' . $shift->end_time }}</dd>
          @endforeach
        </dl>
      </x-adminlte-card>
    </div>
  </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop