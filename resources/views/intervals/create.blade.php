@extends('layouts.intervals')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add Equipment</strong>
            </div>
            {!! Form::open(['route' => 'intervals.store', 'files' => true]) !!}
  				@include("intervals.form")
            {!! Form::close() !!}
          </div>

@endsection
