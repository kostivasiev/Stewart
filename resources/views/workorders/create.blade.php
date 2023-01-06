@extends('layouts.single_workorder')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add Work Order</strong>
            </div>
            {!! Form::open(['route' => 'workorders.store', 'files' => true]) !!}
  				@include("workorders.form")
            {!! Form::close() !!}
          </div>

@endsection
