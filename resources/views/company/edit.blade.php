@extends('layouts.users')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Company</strong>
            </div>
            {!! Form::model($company, ['files' => true, 'route' => ['company.update', $company->id], 'method' => 'PATCH']) !!}

            @include("company.form")

            {!! Form::close() !!}
          </div>

@endsection
