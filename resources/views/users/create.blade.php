@extends('layouts.users')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Add User</strong>
            </div>
            {!! Form::open(['route' => 'users.store', 'files' => true]) !!}
  				@include("users.form")
            {!! Form::close() !!}
          </div>

@endsection
