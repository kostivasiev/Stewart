@extends('layouts.intervals')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Interval</strong>
            </div>

            {!! Form::model($interval, ['files' => true, 'route' => ['intervals.update', 'id' => "$interval->id"], 'method' => 'PATCH']) !!}

            @include("intervals.form")

            {!! Form::close() !!}
          </div>

@endsection
