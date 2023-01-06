@extends('layouts.equipment')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <strong>Equipment Intervals</strong>
    <div class="pull-right" style="display:none">
      <a href="{{ route("equipment.intervals.create", ['id' => $equipment->id]) }}" class="btn btn-success">
        <i class="glyphicon glyphicon-plus"></i>
          Add Interval
      </a>
    </div>
  </div>
  @include("equipment.partials.navbar")
  <div class="panel-body">
  <div class="col-md-12">
    <div class="pull-left" style="display:none">
        <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="#">Name</a></li>
          <li role="presentation"><a href="#">Meter</a></li>
          <li role="presentation"><a href="#">Day</a></li>
        </ul>
      </div>

      <div id="equipment-intervals-container" style="display:none">
      </div>
  </div>
  </div>
<br><br><br>


</div>
@section('form-script')
<script>
var hour_flag_input=0;
var reset_cnt=0;
GetIntervals();
function GetIntervals(){
  $("#equipment-intervals-container").hide(500);
  $.ajax({
    url: "{{ route("workorders.intervals") }}",
    method: 'get',
    data: {
      equipment_id: {{ $equipment->id }},
      hour_flag: hour_flag_input,
      _token: $("input[equipment_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      console.log("Intervals Ready");
      // console.log(response);
      $('#equipment-intervals-container').html(response);
      $("#equipment-intervals-container").show(500);
      $("#view-interval-button-container").show(500);
      $("#equipment-intervals-view-by-btn").show(500);
    }
  });
}
function ToggleResetView(interval_id){
  // document.getElementById("interval-contents-" + interval_id).style.display="block";
  $("#interval-reset-" + interval_id).toggle(500);
  $("#interval-overview-" + interval_id).toggle(500);
}
function ToggleIntervalView(interval_id){
  // document.getElementById("interval-contents-" + interval_id).style.display="block";
  $("#interval-overview-" + interval_id).toggle(500);
  $("#interval-contents-" + interval_id).toggle(500);
}
function SaveInterval(interval_id){
  reset_cnt=1;
  ResetInterval(interval_id);
}
function ResetInterval(interval_id){
  $.ajax({
    url: "{{ route("workorders.reset_interval") }} ",
    method: 'post',
    data: {
      name: "new_group",
      interval_id: interval_id,
      equipment_id: {{ $equipment->id }},
      workorder_id: $("#workorder_id").val(),
      meter_due: $("#next_meter_interval_" + interval_id).val(),
      date_due: $("#next_date_interval_" + interval_id).val(),
      current_meter: $("#current_meter_interval_" + interval_id).val(),
      _token: $("input[name=_token]").val()
    },
    success: function (group){
      $("#save-current-meter-container").hide(500);
      reset_cnt--;
      if(reset_cnt==0){
        GetIntervals();
      }
    },
    error: function (xhr){
        alert(xhr);
    }
  });
}
</script>

@endsection
@endsection
