@extends('layouts.equipment')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add Equipment</strong>
            </div>       
            {!! Form::open(['route' => 'equipment.store', 'files' => true]) !!}    
  				@include("equipment.form")
            {!! Form::close() !!}
          </div>

@endsection