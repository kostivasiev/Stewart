@extends('layouts.single_workorder')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Work Order - WO: {{ $workorder->id }}</strong>
            </div>

            {!! Form::model($workorder, ['files' => true, 'route' => ['workorders.update', $workorder->id], 'method' => 'PATCH']) !!}

            @include("workorders.form")

            {!! Form::close() !!}
          </div>

@endsection
