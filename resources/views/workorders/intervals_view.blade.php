@extends('layouts.workorder')


@section('content')

				<div class="pull-right" style="display:none">
	    			<form action="{{ route("equipment.index") }}" class="navbar-form navbar-right" role="search">
		              <div class="input-group">
		                <input type="text" name="term" value="{{ Request::get("term") }}" class="form-control" placeholder="Search...">
		                <span class="input-group-btn">
		                  <button class="btn btn-default" type="submit">
		                    <i class="glyphicon glyphicon-search"></i>
		                  </button>
		                </span>
		              </div>
		            </form>
	    		</div>
	<h1> List of Equipment with Intervals</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>Equipment</h4>
	    		</div>

	    		<div class="pull-right">

					<a href="{{ route("workorders.create") }}" class="btn btn-success">
	          <i class="glyphicon glyphicon-plus"></i>
	          Add Work Order
		      </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($equipments as $equipment)
              <?php $display_type = "none"; ?>
              <?php $type = !empty($_GET['interval_status']) ? $_GET['interval_status'] : -1 ?>
							@if($type=='okay' && $equipment->okay)
  							<?php $display_type = ""; ?>
							@elseif($type=='upcoming' && $equipment->upcoming)
  							<?php $display_type = ""; ?>
							@elseif($type=='current' && $equipment->current)
  							<?php $display_type = ""; ?>
							@elseif($type=='overdue' && $equipment->overdue)
  							<?php $display_type = ""; ?>
							@endif

              <tr style="display:{{$display_type}}">
                <td class="middle">
                  <div class="media">
										<div class="media-left">
										</div>
                    <div class="media-body">
                      <h4 class="media-heading">{{ $equipment->name }}</h4>
                      <address>
                        <strong>Unit ID:{{ $equipment->unit_number }}</strong><br>
                        Current Meter: {{ $equipment->current_meter() }}<br>
											</address>
                    </div>
                    <div class="media-right">
											<span style="display:{{ $equipment->okay ? "" : "none"}}"><span class="label label-default" title="">Okay: {{ $equipment->okay }}</span><br><br></span>
											<span style="display:{{ $equipment->upcoming ? "" : "none"}}"><span class="label label-primary" title="">Upcoming: {{ $equipment->upcoming }}</span><br><br></span>
											<span style="display:{{ $equipment->current ? "" : "none"}}"><span class="label label-warning" title="">Current: {{ $equipment->current }}</span><br><br></span>
											<span style="display:{{ $equipment->overdue ? "" : "none"}}"><span class="label label-danger" title="">Overdue: {{ $equipment->overdue }}</span><br><br></span>
                    </div>
                  </div>
                </td>
                <td width="100" class="middle">
                  <div>
										<a class="btn btn-circle btn-default btn-xs" title="View Intervals" onclick="ToggleViewIntervals({{ $equipment->id }})">
											<i class="glyphicon glyphicon-time"></i>
										</a>
											<a href="{{ route("workorders.create", ['id' => $equipment->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
                        <i class="glyphicon glyphicon-edit"></i>
                      </a>
                  </div>
                </td>
              </tr>
							<tr style="display:none" id="interval-view-{{ $equipment->id }}">
								<td>

									@foreach ($equipment->intervals as $interval)
									<strong>{{ $interval->name }}</strong>
									@if ($interval->meter_interval != 0)<br>&nbsp;&nbsp;&nbsp;&nbsp;
										@if ($equipment->current_meter + $interval->meter_alert < $interval->meter_due)
										<span class="label label-success">Okay</span>  Due in {{ $interval->meter_due - $equipment->current_meter }} machine hours ({{ $interval->meter_due }})
										@elseif ($equipment->current_meter < $interval->meter_due)
										<span class="label label-primary">Upcomming</span>  Due in {{ $interval->meter_due - $equipment->current_meter }} machine hours ({{ $interval->meter_due }})
										@elseif ($equipment->current_meter < $interval->meter_due + $interval->meter_alert)
										<span class="label label-warning">Current</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})
										@else
										<span class="label label-danger">Overdue</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})
										@endif
										@else
									@endif
									@if ($interval->date_interval != 0)<br>&nbsp;&nbsp;&nbsp;&nbsp;
										@if ($interval->date_status == "Okay")
										<span class="label label-success">Okay</span>  Due in {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }})
										@elseif ($interval->date_status == "Upcomming")
										<span class="label label-primary">Upcomming</span>  Due in {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }})
										@elseif ($interval->date_status == "Current")
										<span class="label label-warning">Current</span>  Overdue by {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }})
										@else
										<span class="label label-danger">Overdue</span>  Overdue by {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }})
										@endif
										@else
									@endif
									<br>
									@if (!empty($interval->interval_log))
										Last Service: {{ Carbon\Carbon::parse($interval->interval_log->created_at)->format('M d, y') }} at meter {{ $interval->interval_log->current }}
									@else
										Not Yet Serviced
									@endif
									<br>
				          @endforeach
								</td>
							</tr>
              @endforeach
            </table>
          </div>

          <div class="text-center">
            <nav>
            </nav>
          </div>
@endsection

<script>

function ToggleViewIntervals(equipment_id){
	// alert(equipment_id);
	// $("#interval-view" + equipment_id).toggle(500);
	// document.getElementById("interval-view-" + equipment_id).style.display = "none";
	$('#interval-view-' + equipment_id).toggle(500);
}
</script>
