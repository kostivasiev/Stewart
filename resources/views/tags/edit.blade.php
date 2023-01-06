@extends('layouts.generic')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Tag</strong>
            </div>
            {!! Form::model($tag, ['files' => true, 'route' => ['tags.update', $tag->id], 'method' => 'PATCH']) !!}

            @include("tags.form")

            {!! Form::close() !!}
          </div>

@endsection
