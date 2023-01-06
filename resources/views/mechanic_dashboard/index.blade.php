@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">



      @foreach ( $users as $user)

      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">{{ $user->first_name }} {{ $user->last_name }}</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Total</th>
                </tr>
              </thead>
                <tr>
                  <td>Submitted Not Complete</td>
                  <td>1</td>
                </tr>
                <tr>
                <td>Completed Today</td>
                <td>1</td>
                </tr>
                <tr>
                <td>Completed This Week</td>
                <td>1</td>
                </tr>
                <tr>
                <td>Total Completed</td>
                <td>1</td>
                </tr>
              <tbody>
              </tbody>
              <thead>
                <tr>
                  <th>Intervals</th>
                  <th>Total</th>
                </tr>
              </thead>
                <tr>
                  <td>Okay Intervals</td>
                  <td>1</td>
                </tr>
                <tr>
                <td>Upcoming Intervals</td>
                <td>1</td>
                </tr>
                <tr>
                <td>Current Intervals</td>
                <td>1</td>
                </tr>
                <tr>
                <td>Overdue Intervals</td>
                <td>1</td>
                </tr>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endforeach
    </div>
</div>
@endsection
