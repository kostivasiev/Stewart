@extends('layouts.equipment')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add Part</strong>
            </div>
            {!! Form::open(['route' => 'parts.store', 'files' => true]) !!}
            <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
  				@include("parts.form")
            {!! Form::close() !!}
          </div>

@endsection
