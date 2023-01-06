@extends('layouts.equipment')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add Interval</strong>
            </div>
            {!! Form::open(['route' => 'equipment.intervals.intervals_store', 'equipment_id' => $equipment->id, 'files' => true]) !!}    
  				@include("intervals.form")
            {!! Form::close() !!}
          </div>

@endsection
