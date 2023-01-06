@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron text-center">
                <h1>Hello, {{ Auth::user()->first_name }}</h1>
                <p class="lead">
                    Welcome back to Equipment Manager
                </p>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Fuel Ups</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Pump</th>
                  <th>Today</th>
                  <th>This Week</th>
                </tr>
              </thead>
              <tbody>
                @foreach( Auth::user()->company()->first()->stations()->orderBy('name')->get() as $fuel_station)
                  @foreach( $fuel_station->pumps()->orderBy('name')->get() as $fuel_pump)
                  <tr>
                    <td>{{ $fuel_station->name }}-{{ $fuel_pump->name }}</td>
                    <td>{{ $fuel_pump->fuel_logs()->where('created_at', '>=', \Carbon\Carbon::today()->toDateString())->whereIn('type', [3100, 3101])->count() }}</td>
                    <td>{{ $fuel_pump->fuel_logs()->where('created_at', '>', \Carbon\Carbon::today()->subWeek())->whereIn('type', [3100, 3101])->count() }}</td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Fuel Pumps</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Pump</th>
                  <th>Current Gallons</th>
                </tr>
              </thead>
              <tbody>
                @foreach( Auth::user()->company()->first()->stations()->orderBy('name')->get() as $fuel_station)
                  @foreach( $fuel_station->pumps()->orderBy('name')->get() as $fuel_pump)
                  <tr>
                    <td>
                      <a href="{{ route("stations.edit", ['id' => $fuel_station->id]) }}" title="Edit">
                        {{ $fuel_station->name }}-{{ $fuel_pump->name }}
                      </a>
                      </td>
                    <td>{{ number_format($fuel_pump->tank_logs()->orderBy('created_at', 'desc')->first()->current_gallons,0) }}</td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Maintenance</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Totals</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <a href="{{ route("workorders.index") }}" title="View">Completed Today</a>
                  </td>
                  <td>{{ App\Workorder::where('created_at', '>=', \Carbon\Carbon::today()->toDateString())->count() }}</td>
                </tr>
                <tr>
                  <td>
                    <a href="{{ route("workorders.index") }}" title="View">Completed This Week</a>
                  </td>
                  <td>{{ App\Workorder::where('created_at', '>', \Carbon\Carbon::today()->subWeek())->count() }}</td>
                </tr>
                <thead style="display:none">
                  <tr>
                    <th>Intervals</th>
                    <th>Totals</th>
                  </tr>
                </thead>
                <tr style="display:none">
                  <td>
                    <a href="{{ route('workorders.interval_view', ['type' => 0]) }}" title="View">Okay Intervals</a>
                  </td>
                  <td>  $okay_status  </td>
                </tr>
                <tr style="display:none">
                  <td>
                    <a href="{{ route('workorders.interval_view', ['type' => 1]) }}" title="View">Upcoming Intervals</a>
                  </td>
                  <td>  $upcoming_status  </td>
                </tr>
                <tr style="display:none">
                  <td>
                    <a href="{{ route('workorders.interval_view', ['type' => 2]) }}" title="View">Current Intervals</a>
                  </td>
                  <td>  $current_status  </td>
                </tr>
                <tr style="display:none">
                  <td>
                    <a href="{{ route('workorders.interval_view', ['type' => 3]) }}" title="View">Overdue Intervals</a>
                  </td>
                  <td> $overdue_status </td>
                </tr>
                <tr style="display:none">
                  <td>
                    <a href="{{ route('workorders.interval_view') }}" title="View">Total Intervals</a>
                  </td>
                  <td> $cnt </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Users</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Fuel Groups</th>
                  <th>Qty</th>
                </tr>
              </thead>
              <tbody>
                @foreach( Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
                  <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->users()->count() }}</td>
                  </tr>
                @endforeach
                <tr>
                  <td>Non Fueler</td>
                  <td>{{ Auth::user()->company()->first()->users()->where('fuel_group_id', 0)->count() }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4" style="display:none">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Equipment</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Qty</th>
                </tr>
              </thead>
              <tbody>
                @foreach( Auth::user()->company()->first()->equipment_types()->orderBy('name')->get() as $account)
                  <tr>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->count() }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- <p>
        <ul>
          <li>Finish Users</li>
          <li>Populate make/model/year on Equipment</li>
          <li>Add Parts to year_id</li>
          <li>Ensure unit_ids are unique</li>
          <li>Roles</li>
          <li>Search Bars</li>
          <li>Reports</li>
        </ul>
      </p> -->
    </div>
</div>
@endsection
