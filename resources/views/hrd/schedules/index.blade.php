@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.DateRangePicker', true)

{{-- Setup data for datatables --}}
@php
$heads = [
'Tanggal',
'Nama Karyawan',
['label' => 'Kode Shift', 'width' => 20],
['label' => 'Status', 'width' => 20],
['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

function createBtnEdit($id) {
return '<a href='. ' /employees/shifts/edit/' . $id .' class="btn btn-xs btn-default text-primary mx-1 shadow"
  title="Edit">
  <i class="fa fa-lg fa-fw fa-pen"></i>
</a>';
}

// PROJECT_TODO : Fix padding of button
function createBtnDelete($id) {
return '<form action="/employees/shifts/' . $id .'" method="POST" class="btn btn-xs btn-default" title="Delete">
  <input type="hidden" name="_method" value="DELETE">
  <input type="hidden" name="_token" value="' . csrf_token() .'">
  <button class="btn btn-xs btn-default text-danger shadow" type="submit">
    <i class="fa fa-lg fa-fw fa-trash"></i>
  </button>
</form>';
}

$config = [
'data' => [],
'order' => [],
'columns' => [null, null, null, null,['orderable' => false]],
];

foreach ($shift_schedules as $shift_schedule) {
$config['data'][] = [ $shift_schedule->schedule->date, $shift_schedule->user->name, $shift_schedule->shift->code . ' ('
. $shift_schedule->shift->start_time . ' - ' . $shift_schedule->shift->end_time . ') ',
$shift_schedule->shift->status ,'
<nobr>
  '. createBtnEdit($shift_schedule->id) . createBtnDelete($shift_schedule->id) .'
</nobr>'];
}



$datePickerConfig = [
"startDate" => $shift_schedules->date_range[0],
"endDate" => $shift_schedules->date_range[1],
]

@endphp
@section('content')
<div class="container pt-4">
  <form class="row">
    @csrf
    {{-- Prepend slot and custom ranges enables --}}
    <div class="col-10">
      <x-adminlte-date-range name="date_range" :config="$datePickerConfig">
        <x-slot name="prependSlot">
          <div class="input-group-text bg-gradient-info">
            <i class="fas fa-calendar-alt"></i>
          </div>
        </x-slot>
      </x-adminlte-date-range>
    </div>
    <div class="col-2">
      <x-adminlte-button type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save" />
    </div>
  </form>
  @if(session()->has('success'))
  <x-adminlte-alert theme="success" title="Success" dismissable />
  @elseif(session()->has('error'))
  <x-adminlte-alert theme="danger" title="Danger" dismissable />
  @endif

  {{-- With buttons --}}
  <x-adminlte-datatable id="table7" :heads="$heads" :config="$config" striped hoverable with-buttons />
</div>
@endsection