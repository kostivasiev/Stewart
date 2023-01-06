@extends('layouts.equipment')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <strong>Equipment History</strong>
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

      <div id="equipment-history-container" style="display:none">
      </div>
  </div>
  </div>
<br><br><br>


</div>
@section('form-script')
<script>
GetHistory();
function GetHistory(){
  $("#equipment-history-container").hide(500);
  $.ajax({
    url: "{{ route("workorders.equipment_history") }}",
    method: 'get',
    data: {
      equipment_id: {{ $equipment->id }},
      _token: $("input[equipment_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      $('#equipment-history-container').html(response);
      $("#equipment-history-container").show(500);
      $("#view-interval-button-container").show(500);
      $("#equipment-history-view-by-btn").show(500);
    }
  });
}
</script>

@endsection
@endsection
