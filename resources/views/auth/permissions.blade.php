@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron text-center">
                <h1>{{ Auth::user()->first_name }}</h1>
                <p class="lead">
                    You did not have permission to do that!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
