@extends('layouts.equipment')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Equipment</strong>
            </div>

            @include("equipment.partials.navbar")

            {!! Form::model($equipment, ['files' => true, 'route' => ['equipment.update', $equipment->id], 'method' => 'PATCH']) !!}

            @include("equipment.form")

            {!! Form::close() !!}
            @if( Auth::user()->hasRole("Delete Equipment"))
            {!! Form::open(['method' => 'DELETE', 'route' => ['equipment.destroy', $equipment->id], 'id' => 'delete_form']) !!}

            {!! Form::close() !!}
            @endif

            <script>

            function DeleteEquipment(){
              if(confirm('Are you sure? This cannot be undone.')){
                document.getElementById("delete_form").submit();
              }
            }
            </script>
          </div>

@endsection
