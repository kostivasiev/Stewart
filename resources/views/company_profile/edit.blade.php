@extends('layouts.users')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Company Profile</strong>
            </div>
            {!! Form::model($company, ['files' => true, 'route' => ['company_profile.update', $company->id], 'method' => 'PATCH']) !!}

            @include("company_profile.form")

            {!! Form::close() !!}
          </div>

@endsection
