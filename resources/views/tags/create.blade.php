@extends('layouts.generic')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add Tag</strong>
            </div>
            {!! Form::open(['route' => 'tags.store', 'files' => true]) !!}
  				@include("tags.form")
            {!! Form::close() !!}
          </div>

@endsection
