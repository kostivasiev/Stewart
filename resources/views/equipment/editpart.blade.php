@extends('layouts.equipment')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Part</strong>
            </div>

            @include("equipment.partials.navbar")

            {!! Form::model($part, ['files' => true, 'route' => ['parts.update', $part->id], 'method' => 'PATCH']) !!}

            <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

            @include("parts.form")

            {!! Form::close() !!}
          </div>

@endsection
