<div class="panel-body">
  <div class="form-horizontal">
    <div class="row">
      <div class="col-md-8">
        @if (count($errors))
        <div class="alert alert-danger">
         <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <input name="workorder_id" type="hidden" id="workorder_id" value="{{ !empty($workorder) ? $workorder->id : -1 }}">
      <div class="form-group">
        <div class="col-md-offset-3 col-md-8">
         <input class="form-control" name="search" type="text" id="search" placeholder="Search">
       </div>
     </div>
      <div class="form-group" id="selectable-equipment-container">
        <label for="company" class="control-label col-md-3">Equipment</label>
        <div class="col-md-8">
          <select class="form-control" name="equipment_id" id="equipment_id" placeholder="Please select">
            @foreach (Auth::user()->company()->first()->equipment()->orderBy('name','asc')->get() as $piece)
              <option value="{{ $piece->id }}" {{ !empty($workorder) ? $workorder->equipment_id==$piece->id ? "selected" : "" : '' }}>({{ $piece->unit_number }}) {{ $piece->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group" id="searchable-equipment-container" style="display:none">
       <label for="company" class="control-label col-md-3">Options</label>
       <div class="col-md-8">
         @foreach (Auth::user()->company()->first()->equipment()->orderBy('name','asc')->get() as $equipment_option)
         <span name="MachineOptions" class="searchable-option" onclick="SelectEquipment({{ $equipment_option->id }})">({{ $equipment_option->unit_number }}) {{ $equipment_option->name }}</span>
         @endforeach
       </div>
     </div>
     <div class="form-group" id="selectable-equipment-container">
        <label for="company" class="control-label col-md-3">Assigned User</label>
        <div class="col-md-8">
          <select class="form-control" name="user_id" id="user_id" placeholder="Please select">
          <option value="0">Select User</option>
            @foreach (Auth::user()->company()->first()->mechanics()->orderBy('last_name','asc')->get() as $user)
              <option value="{{ $user->id }}" {{ !empty($workorder) ? $workorder->user_id==$user->id ? "selected" : "" : '' }}>{{ $user->last_name }}, {{ $user->first_name }}</option>
            @endforeach
          </select>
        </div>
      </div>
     <div class="form-group" id="selectable-equipment-container">
        <label for="company" class="control-label col-md-3">Due Date</label>
        <div class="col-md-8">
        <input class="form-control" name="due_date" type="date" id="due_date" value="{{!empty($workorder) ? $workorder->due_date : '0' }}">
        </div>
      </div>
      

      <div class="form-group" id="searchable-equipment-container" style="display:none">
       <label for="company" class="control-label col-md-3">Options</label>
       <div class="col-md-8">
         @foreach (Auth::user()->company()->first()->equipment()->orderBy('name','asc')->get() as $equipment_option)
         <span name="MachineOptions" class="searchable-option" onclick="SelectEquipment({{ $equipment_option->id }})">({{ $equipment_option->unit_number }}) {{ $equipment_option->name }}</span>
         @endforeach
       </div>
     </div>
     <div class="form-group" id="current-meter-container" style="display:none">
      <label for="company" class="control-label col-md-3">Current Meter</label>
      <div class="col-md-8">
        <input type="number" class="form-control" id="current_meter" name="current_meter">
      </div>
    </div>
     <div class="form-group" id="save-current-meter-container" style="display:none">
      <label for="company" class="control-label col-md-3"></label>
      <div class="col-md-8">
        <a class="btn btn-primary" id='save-current-meter-btn' onclick="UpdateCurrentMeter()">Save Meter</a>
      </div>
    </div>
      <div class="form-group" id="notes-container" style="display:none">
        <label for="name" class="control-label col-md-3">Notes</label>
        <div class="col-md-8">
          <?php $notes = !empty($workorder) ? $workorder->wologs()->orderBy('created_at', 'desc')->first()->notes : "" ?>
         {!! Form::textarea('notes',$notes, ['class' => 'form-control', 'rows' => 4, 'id' => 'notes']) !!}
       </div>
     </div>
     <div class="form-group" id="view-parts-button-container" style="display:none">
      <label for="company" class="control-label col-md-3"></label>
      <div class="col-md-8">
        <a onclick="TogglePartsView()" class="btn btn-default btn-block">
          <i class="glyphicon glyphicon-eye-open"></i>
          <span id="equipment-parts-btn-text">View Parts/Supplies</span>
        </a>
      </div>
    </div>
    <div class="col-md-offset-3 col-md-8" id="equipment-parts-container" style="display:block">
</div>
<div class="form-group" id="view-interval-button-container" style="display:none">
 <label for="company" class="control-label col-md-3"></label>
 <div class="col-md-8">
   <a onclick="ToggleIntervalsView()" class="btn btn-default btn-block">
     <i class="glyphicon glyphicon-eye-open"></i>
     <span id="interval-btn-text">Hide Intervals</span>
   </a>
 </div>
</div>
<div class="form-group" id="equipment-intervals-view-by-btn" style="display:none">
 <label for="company" class="control-label col-md-3"></label>
 <div class="col-md-8" style="display:none">
   <a onclick="ToggleViewByIntervalsView()" class="btn btn-default btn-block">
     <i class="glyphicon glyphicon-eye-open"></i>
     <span id="view-by-interval-btn-text">View Intervals By Name</span>
   </a>
 </div>
</div>
<div class="col-md-offset-3 col-md-8" id="equipment-intervals-container" style="display:none">
</div>
<div class="col-md-offset-3 col-md-8" id="tags-container" style="display:none">
</div>
<div class="form-group" id="view-history-button-container" style="display:block">
 <label for="company" class="control-label col-md-3"></label>
 <div class="col-md-8">
   <a onclick="ToggleHistoryView()" class="btn btn-default btn-block">
     <i class="glyphicon glyphicon-eye-open"></i>
     <span id="history-btn-text">View History</span>
   </a>
 </div>
</div>
<div class="col-md-offset-3 col-md-8" id="history-container" style="display:none">
</div>



  <div class="col-md-offset-3 col-md-8" id="labor-container" style="display:none">
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <strong>Labor</strong>
        </div>
        @if (!empty($workorder))
        @foreach ($workorder->labor()->get() as $labor)
          @include('workorders.partials.labor')
        @endforeach
        @endif
        <div id="additional-labor-fields">
        </div>
        <div class="panel-footer clearfix">
          <div class="pull-right">
            <a onclick="AddLaborFields()" class="btn btn-default">
              <i class="glyphicon glyphicon-plus"></i>
              Add
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-offset-3 col-md-8" id="photo-container" style="display:none">
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <strong>Photos</strong>
        </div>
        @if (!empty($workorder))
        @foreach($workorder->photos()->get() as $photo)
        <div class="fileinput fileinput-new" data-provides="fileinput">
          <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
            {!! Html::image('uploads/' . $photo->file_path, "Choose photo", ['max-width'=>150, 'height'=>'auto']) !!}
          </div>
        </div>
        @endforeach
        @endif

        <div class="fileinput fileinput-new" data-provides="fileinput">
          <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
            <?php $photo = ! empty($equipment->photo) ? $equipment->photo : 'default.png' ?>
            {!! Html::image('uploads/' . $photo, "Choose photo", ['max-width'=>150, 'height'=>'auto']) !!}
          </div>
          <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
          <div class="text-center">
            <span class="btn btn-default btn-file"><span class="fileinput-new">Choose Photo</span><span class="fileinput-exists">Change</span>{!! Form::file('photo') !!}</span>
            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
            <a class="btn btn-default fileinput-exists" onclick="AddPhotoToWorkorder()">Add to Workorder</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-11" id='interval-update-notes'>
    </div>

    <div class="col-md-11">
      @if (!empty($workorder))
      @if (count($workorder->wologs()->orderBy('created_at', 'desc')->get()))
    <div class="alert alert-warning">
      Updated
     <ul>
       @foreach ($workorder->wologs()->orderBy('created_at', 'desc')->get() as $logs)
       <li>{{ $logs->user()->first()->first_name }} {{ $logs->user()->first()->last_name }} - {{ $logs->created_at->format('m/d/y h:i') }}</li>
       @endforeach
    </ul>
    </div>
    @endif
    @endif
    </div>


</div>
<div class="col-md-4">
</div>
</div>
</div>
</div>
<div class="panel-footer">
<div class="row">
<div class="col-md-8">
<div class="row">
  <div class="col-md-offset-3 col-md-8">
    <input type="hidden" name="workorder_status" id="workorder_status" value="0">
    <button onclick="UpdateStatus(2)" type="submit" class="btn btn-primary">Complete</button>
    <button onclick="UpdateStatus(1)" type="submit" class="btn btn-default">Not Complete</button>
    <button onclick="UpdateStatus(3)" type="submit" class="btn btn-danger">Void</button>
    <a href="{{ url('/workorders') }}" class="btn btn-default">Cancel</a>
  </div>
</div>
</div>
</div>
</div>

<input type="hidden" name="tag_filters" value="{{ app('request')->get('tags') }}">
<input type="hidden" name="type_filters" value="{{ app('request')->get('types') }}">
<input type="hidden" name="user_filters" value="{{ app('request')->get('users') }}">

@section('form-script')



<script>

{{ !empty($_GET['id']) ? "SelectEquipment(" . $_GET['id'] . ");" : '' }}

function AddPhotoToWorkorder(){
  if($("#workorder_id").val()==-1){
    console.log('Createding work order');
    CreateWorkorder(false,true);
  }else{
    console.log('WO already exists: ' + $("#workorder_id").val())
    AttachPhotoToWorkorder();
  }
}

// function AttachPhotoToWorkorder(){
  
//   $.ajax({
//     url: "{{ route("workorders.add_photo_to_workorder") }} ",
//     method: 'post',
//     data: {
//       workorder_id: $("#workorder_id").val(),
//       _token: $("input[name=_token]").val()
//     },
//     context: document.body,
//     success: function (photos){
//       console.log("AddPhotoToWorkorder complete");
//     },
//     error: function (xhr){
//         alert(xhr);
//     }
//   });
// }

function AttachPhotoToWorkorder(){
  
  var file_data = $('#photo').prop('files')[0];
  var form_data = new FormData($(this)[0]);
  form_data.append('photo', file_data);
  form_data.append('workorder_id', $("#workorder_id").val());
  form_data.append('_token', $("input[name=_token]").val());

  $.ajax({
    url: "{{ route("workorders.add_photo_to_workorder") }} ",
    method: 'post',
    data: form_data,
    cache : false,
    processData: false,
    // processData: false,
    // contentType: false,
    // type: "POST",
    context: document.body,
    success: function (photos){
      console.log("AddPhotoToWorkorder complete: " + photos);
    },
    error: function (xhr){
        alert(xhr);
    }
  });
}

function UpdateStatus(status){
  $("#workorder_status").val(status);
}

var hour_flag_input=0;
{{ !empty($workorder) ? "SelectEquipment($workorder->equipment_id);" : '' }}
{{ !empty($workorder) ? 'GetWorkorder();' : '' }}


function ToggleIntervalsView(){
  $("#equipment-intervals-container").toggle(500);
  $("#equipment-intervals-view-by-btn").toggle(500);
  $("#interval-btn-text").text($("#interval-btn-text").text() == 'View Intervals' ? 'Hide Intervals' : 'View Intervals' );
}
function ToggleViewByIntervalsView(){
  $("#equipment-intervals-container").hide(500);
  if(hour_flag_input==1){
    hour_flag_input=0;
    $("#view-by-interval-btn-text").text('View Intervals By Meter');
  }else{
    hour_flag_input=1;
    $("#view-by-interval-btn-text").text('View Intervals By Name');
  }

  $.ajax({
    url: "{{ route("workorders.intervals") }}",
    method: 'get',
    data: {
      equipment_id: $("#equipment_id").val(),
      hour_flag: hour_flag_input,
      _token: $("input[equipment_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      // console.log(response);
      $('#equipment-intervals-container').html(response);
      $("#equipment-intervals-container").show(500);
      $("#view-interval-button-container").show(500);
      $("#equipment-intervals-view-by-btn").show(500);
    }
  });
}
function ToggleHistoryView(){
  $("#history-container").toggle(500);
  $("#history-btn-text").text($("#history-btn-text").text() == 'View History' ? 'Hide History' : 'View History' );
}


function TogglePartsView(){
  $("#equipment-parts-container").toggle(500);
  $("#equipment-parts-btn-text").text($("#equipment-parts-btn-text").text() == 'View Parts/Supplies' ? 'Hide Parts/Supplies' : 'View Parts/Supplies' );
}

function ToggleIntervalView(interval_id){
  // document.getElementById("interval-contents-" + interval_id).style.display="block";
  $("#interval-overview-" + interval_id).toggle(500);
  $("#interval-contents-" + interval_id).toggle(500);
}

function ToggleResetView(interval_id){
  // document.getElementById("interval-contents-" + interval_id).style.display="block";
  $("#interval-reset-" + interval_id).toggle(500);
  $("#interval-overview-" + interval_id).toggle(500);
}

$("#trim-div").hide();
$("#equipment_id").change(function() {
  GetWorkorder();
});
var workorder_id;
function GetWorkorder(){
  workorder_id = {{ !empty($workorder) ? $workorder->id : -1 }};
  $("#equipment-intervals-container").hide(500);
  $("#equipment-parts-container").hide(500);
  $("#current-meter-container").hide(500);
  $("#view-parts-button-container").hide(500);
  $("#view-interval-button-container").hide(500);
  $("#equipment-intervals-view-by-btn").hide(500);
  $("#history-container").hide(500);
  $("#view-history-button-container").hide(500);


  $.ajax({
    url: "{{ route("workorders.intervals") }}",
    method: 'get',
    data: {
      equipment_id: $("#equipment_id").val(),
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
  $.ajax({
    url: "{{ route("workorders.parts") }}",
    method: 'get',
    data: {
      equipment_id: $("#equipment_id").val(),
      _token: $("input[equipment_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      console.log("Parts Ready");
       console.log(response);
      $('#equipment-parts-container').html(response);
      $("#notes-container").show(500);
      $("#view-parts-button-container").show(500);
      $("#labor-container").show(500);
      // $("#photo-container").show(500);
    }
  });
  $.ajax({
    url: "{{ route("workorders.currentMeter") }}",
    method: 'get',
    data: {
      equipment_id: $("#equipment_id").val(),
      _token: $("input[equipment_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      console.log("Current Meter Ready");
      current_meter = response;
      $("#current_meter").val(response);
      $("#current-meter-container").show(500);
      $("#current-meter-container").show(500);

    }
  });
  $.ajax({
    url: "{{ route("workorders.intervalnotes") }}",
    method: 'get',
    data: {
      workorder_id: $("#workorder_id").val(),
      _token: $("input[workorder_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      console.log("Interval Notes Ready");
      $('#interval-update-notes').html(response);
      $("#interval-update-notes").show(500);

    }
  });
  $.ajax({
    url: "{{ route("workorders.equipment_history") }}",
    method: 'get',
    data: {
      equipment_id: $("#equipment_id").val(),
      _token: $("input[equipment_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      console.log("History Ready");
      // console.log(response);
      $('#history-container').html(response);
      // $("#history-container").show(500);
      $("#view-history-button-container").show(500);
    }
  });
  $.ajax({
    url: "{{ route("workorders.tags") }}",
    method: 'get',
    data: {
      workorder_id: $("#workorder_id").val(),
      _token: $("input[workorder_id=_token]").val()
    },
    context: document.body,
    success: function(response){
      console.log("Tags Ready");
      $('#tags-container').html(response);
      $("#tags-container").show(500);

    }
  });
}

function SaveInterval(interval_ids){
  reset_cnt=1;
  if($("#workorder_id").val()==-1){
    CreateWorkorder(interval_ids);
  }else{
    ResetMultipleIntervals(interval_ids);
  }
}

var reset_cnt = 0;
function ResetMultipleIntervals(interval_ids){
  reset_cnt = interval_ids.length;
  for(var i=0; i<interval_ids.length; i++){
    // alert($("#reset-interval-checkbox-" + interval_ids[i]).is(":checked"));
    if($("#reset-interval-checkbox-" + interval_ids[i]).is(":checked")){
        ResetInterval(interval_ids[i]);
    }else{
      reset_cnt--;
    }
  }
}

function ResetInterval(interval_id){
  $.ajax({
    url: "{{ route("workorders.reset_interval") }} ",
    method: 'post',
    data: {
      name: "new_group",
      interval_id: interval_id,
      equipment_id: $("#equipment_id").val(),
      workorder_id: $("#workorder_id").val(),
      meter_due: $("#next_meter_interval_" + interval_id).val(),
      date_due: $("#next_date_interval_" + interval_id).val(),
      current_meter: $("#current_meter_interval_" + interval_id).val(),
      _token: $("input[name=_token]").val()
    },
    success: function (group){
      // console.log(group);
      // return;
      $("#save-current-meter-container").hide(500);
      reset_cnt--;
      if(reset_cnt==0){
        GetWorkorder();
      }
    },
    error: function (xhr){
        alert(xhr);
    }
  });
}

function CreateWorkorder(interval_ids,photo_flag){
  $.ajax({
    url: "{{ route("workorders.ajax_store") }} ",
    method: 'post',
    data: {
      name: "new_group",
      notes: $("#notes").val(),
      equipment_id: $("#equipment_id").val(),
      user_id: $("#user_id").val(),
      due_date: $("#due_date").val(),
      _token: $("input[name=_token]").val()
    },
    success: function (result){
      workorder_id = result;
      $("#workorder_id").val(workorder_id);
      if(interval_ids){
        ResetMultipleIntervals(interval_ids);
      }else if(photo_flag){
        AttachPhotoToWorkorder();
      }
      
    },
    error: function (xhr){
        alert(xhr);
    }
  });
}

$("#search").on('change keyup paste click', function() {
    SearchEquipment();
});

function SearchEquipment()
{
  $("#equipment-intervals-container").hide(500);
  $("#equipment-parts-container").hide(500);
  $("#current-meter-container").hide(500);
  $("#view-parts-button-container").hide(500);
  $("#view-interval-button-container").hide(500);
  $("#equipment-intervals-view-by-btn").hide(500);
  $("#interval-update-notes").hide(500);
  $("#notes-container").hide(500);
  $("#view-parts-button-container").hide(500);
  $("#labor-container").hide(500);
  $("#photo-container").hide(500);

  $("#searchable-equipment-container").show(500);
  $("#selectable-equipment-container").hide(500);

  var searchQuery = $("#search").val();

  $("span[name=MachineOptions]").each(function()
  {

    if($(this).text().toLowerCase().includes(searchQuery.toLowerCase())){
      $(this).show(100);
    }else{
      $(this).hide(100);
    }
  });
}

$("#search").blur(function() {
    $("#searchable-equipment-container").hide(500);
    $("#selectable-equipment-container").show(500);
});

function SelectEquipment(id)
{
  $("#search").val("");
  $("#equipment_id").val(id);
  $("#searchable-equipment-container").hide(500);
  $("#selectable-equipment-container").show(500);
  GetWorkorder();
}

var current_meter;
$("#current_meter").on('change keyup paste', function() {
    ShowCurrentMeterSaveButton();
});

function ShowCurrentMeterSaveButton(){
  if($("#current_meter").val() != current_meter){
    $("#save-current-meter-container").show(500);
  }else{
    $("#save-current-meter-container").hide(500);
  }
}

function UpdateCurrentMeter(){
  $.ajax({
    url: "{{ route("workorders.update_meter") }} ",
    method: 'post',
    data: {
      name: "new_group",
      equipment_id: $("#equipment_id").val(),
      current_meter: $("#current_meter").val(),
      _token: $("input[name=_token]").val()
    },
    success: function (group){
      GetWorkorder();
      $("#save-current-meter-container").hide(500);
    },
    error: function (xhr){
        alert(xhr);
    }
  });
}

function update_all_current_meter_fields_and_next_meter_fields(current_meter, meter_interval, interval_id){
  current_meter = parseInt(current_meter);
  $('[name="current_meter"]').val(current_meter);
  $('[interval_id="' + interval_id + '"]').val(current_meter + meter_interval);
  ShowCurrentMeterSaveButton()
}

function update_next_meter_fields(next_meter, interval_id){
  interval_id = parseInt(interval_id);
  // console.log(next_meter);
  // console.log(interval_id);
  $('[name="interval_next_meter_' + interval_id + '"]').val(next_meter);
}

function AddLaborFields(){
  $.ajax({
    url: "{{ route("workorders.add_labor_fields") }} ",
    method: 'post',
    data: {
      name: "new_group",
      equipment_id: $("#equipment_id").val(),
      current_meter: $("#current_meter").val(),
      _token: $("input[name=_token]").val()
    },
    success: function (response){
      $('#additional-labor-fields').append(response);
    },
    error: function (xhr){
        alert(xhr);
    }
  });
}
function ApplyTag(tag_id)
{
  if($('#tag-btn-' + tag_id).attr('class') == "btn btn-default btn-block"){
    $('#tag-btn-' + tag_id).attr('class', "btn btn-primary btn-block");
  }else{
    $('#tag-btn-' + tag_id).attr('class', "btn btn-default btn-block");
  }

}

</script>



@endsection
