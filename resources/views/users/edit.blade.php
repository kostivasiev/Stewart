@extends('layouts.users')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit User</strong>
            </div>
            {!! Form::model($user, ['files' => true, 'route' => ['users.update', $user->id], 'method' => 'PATCH']) !!}

            @include("users.form")

            {!! Form::close() !!}
          </div>

@endsection
