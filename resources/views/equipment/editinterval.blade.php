@extends('layouts.equipment')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Interval</strong>
            </div>

            @include("equipment.partials.navbar")

            {!! Form::model($interval, ['files' => true, 'route' => ['intervals.intervals_update', 'interval_id' => "$interval->id", 'equipment_id' => $equipment->id], 'method' => 'PATCH']) !!}

            @include("intervals.form")

            {!! Form::close() !!}
          </div>

@endsection
