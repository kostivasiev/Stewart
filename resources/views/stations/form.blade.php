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
      <div class="form-group">
        <label for="name" class="control-label col-md-3">Name</label>
        <div class="col-md-8">
         {!! Form::text('name',null, ['class' => 'form-control']) !!}
       </div>
     </div>
     <div class="form-group" style="display:{{ Auth::user()->hasRole("Super Admin") ? "block" : "none" }}">
       <label for="name" class="control-label col-md-3">Tunnel Port</label>
       <div class="col-md-8">
        {!! Form::text('tunnel_port',null, ['class' => 'form-control']) !!}
      </div>
    </div>
     <div class="form-group">
       <label for="name" class="control-label col-md-3">Mac Address</label>
       <div class="col-md-8">
       {{ $station->mac_address }}
      </div>
    </div>
    

     @foreach($station->pumps as $pump )

     <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">{{ $pump->name }}</h3>
      </div>
      <input type="hidden" name="fuel_pump_ids[]" value="{{$pump->id}}">
      <div class="panel-body">
        <div class="form-group">
          <label for="pump_names[]" class="control-label col-md-3">Name</label>
          <div class="col-md-8">
            {!! Form::text('pump_names[]',$pump->name, ['class' => 'form-control', 'rows' => 2]) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="current_gallons[]" class="control-label col-md-3">Current Gallons</label>
          <div class="col-md-8">
            {!! Form::number('current_gallons[]',!empty($pump->tank_logs()->orderBy('created_at', 'desc')->first()->current_gallons) ? $pump->tank_logs()->orderBy('created_at', 'desc')->first()->current_gallons : 0, ['class' => 'form-control', 'rows' => 2]) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="calibration_numbers[]" class="control-label col-md-3">Calibration Number</label>
          <div class="col-md-8">
            {!! Form::number('calibration_numbers[]',$pump->calibration_number, ['class' => 'form-control', 'rows' => 2]) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="inactivit_timers[]" class="control-label col-md-3">Inactivity Timer</label>
          <div class="col-md-8">
            {!! Form::text('inactivity_times[]',$pump->inactivity_time, ['class' => 'form-control', 'rows' => 2]) !!}
          </div>
        </div>
        <div class="form-group" id="meter-type-field" style="">
          <label for="group" class="control-label col-md-3">Fuel Type</label>
          <div class="col-md-8">
            <select class="form-control" rows="2" name="fuel_types[]">
              <option value="0" {{ $pump->fuel_type == 0 ? "selected" : "" }}>Not Selected</option>
              <option value="1" {{ $pump->fuel_type == 1 ? "selected" : "" }}>Red Diesel</option>
              <option value="2" {{ $pump->fuel_type == 2 ? "selected" : "" }}>Clear Diesel</option>
              <option value="3" {{ $pump->fuel_type == 3 ? "selected" : "" }}>Gasoline</option>
              <option value="4" {{ $pump->fuel_type == 4 ? "selected" : "" }}>DFM</option>
              <option value="5" {{ $pump->fuel_type == 5 ? "selected" : "" }}>Other</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">Options</label>
          <div class="col-md-8">
            <div class="checkbox">
             <label>
               <input type="checkbox" name="pin_required{{$pump->id}}" {{ !empty($pump) ? $pump->pin_required ? "checked" : "" : "" }}> Require PIN
             </label>
           </div>
           <div class="checkbox">
             <label>
               <input type="checkbox" name="equipment_id_required{{$pump->id}}" {{ !empty($pump) ? $pump->equipment_id_required ? "checked" : "" : "" }}> Require Unit ID
             </label>
           </div>
           <div class="checkbox">
             <label>
               <input type="checkbox" name="meter_required{{$pump->id}}" {{ !empty($pump) ? $pump->meter_required ? "checked" : "" : "" }}> Require Meter
             </label>
           </div>
          </div>
        </div>
      </div>
    </div>
     @endforeach
</div>
<div class="col-md-4">
  <div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
      <?php $photo = ! empty($contact->photo) ? $contact->photo : 'default-station.png' ?>
      {!! Html::image('uploads/' . $photo, "Choose photo", ['width'=>150, 'height'=>150]) !!}
    </div>
    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
    <div class="text-center">
      <span class="btn btn-default btn-file"><span class="fileinput-new">Choose Photo</span><span class="fileinput-exists">Change</span>{!! Form::file('photo') !!}</span>
      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
    </div>
  </div>
  <div id="station_status">
  </div>
  <div>
    <button class="btn btn-success btn-block" type="button" onclick="sync_now()">Sync Now</button>
  </div>
  <div>
    <button class="btn btn-success btn-block" type="button" onclick="mirror_now()">Mirror</button>
  </div>
  <div>
    <button class="btn btn-success btn-block" type="button" onclick="check_status()">Check Status</button>
  </div>
  <div id="fuel_mirror" style="display:none">
    <div id="lcd_screen" style="height: 100px;width: 200px;background-color: green">
      <div id="line1"></div>
      <div id="line2"></div>
      <div id="line3"></div>
      <div id="line4"></div>
    </div>
    <div id="keypad">
      <table class="table">
        <tr>
          <td><button class="btn" type="button" onclick="key_press('a')">^</button></td>
          <td><button class="btn" type="button" onclick="key_press('b')">^</button></td>
          <td><button class="btn" type="button" onclick="key_press('c')">^</button></td>
          <td><button class="btn" type="button" onclick="key_press('d')">^</button></td>
        </tr>
        <tr>
          <td><button class="btn" type="button" onclick="key_press('1')">1</button></td>
          <td><button class="btn" type="button" onclick="key_press('2')">2</button></td>
          <td><button class="btn" type="button" onclick="key_press('3')">3</button></td>
          <td><button class="btn btn-danger" type="button" onclick="key_press('e')">Can</button></td>
        </tr>
        <tr>
          <td><button class="btn" type="button" onclick="key_press('4')">4</button></td>
          <td><button class="btn" type="button" onclick="key_press('5')">5</button></td>
          <td><button class="btn" type="button" onclick="key_press('6')">6</button></td>
          <td><button class="btn btn-warning" type="button" onclick="key_press('f')">Clr</button></td>
        </tr>
        <tr>
          <td><button class="btn" type="button" onclick="key_press('7')">7</button></td>
          <td><button class="btn" type="button" onclick="key_press('8')">8</button></td>
          <td><button class="btn" type="button" onclick="key_press('9')">9</button></td>
          <td><button class="btn btn-primary" type="button" onclick="key_press('g')">?</button></td>
        </tr>
        <tr>
          <td><button class="btn" type="button" onclick="key_press('#')">#</button></td>
          <td><button class="btn" type="button" onclick="key_press('0')">0</button></td>
          <td><button class="btn" type="button" onclick="key_press('*')">*</button></td>
          <td><button class="btn btn-success" type="button" onclick="key_press('h')">Ent</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>
</div>
</div>
</div>
<div class="panel-footer">
<div class="row">
<div class="col-md-8">
<div class="row">
  <div class="col-md-offset-3 col-md-6">
    <button type="submit" class="btn btn-primary">{{ ! empty($contact->id) ? "Update" : "Save" }}</button>
    <a href="{{ url('/stations') }}" class="btn btn-default">Cancel</a>
  </div>
</div>
</div>
</div>
</div>

@section('form-script')

<script>

$("#add-new-group").hide();
$('#add-group-btn').click(function () {
$("#add-new-group").slideToggle(function() {
$('#new_group').focus();
});
return false;
});

$("#add-new-btn").click(function() {

var newGroup = $("#new_group");
var inputGroup = newGroup.closest('.input-group');

$.ajax({
url: "{{ route("groups.store") }} ",
method: 'post',
data: {
name: $("#new_group").val(),
_token: $("input[name=_token]").val()
},
success: function (group){
if(group.id != null){
  inputGroup.removeClass('has-error');
  inputGroup.next('.text-danger').remove();

  var newOption = $('<option></option>')
  .attr('value', group.id)
  .attr('selected', true)
  .text(group.name);


  $("select[name=group_id]")
  .append( newOption );

  newGroup.val("");
}
},
error: function (xhr){
var errors = xhr.responseJSON;
var error = errors.name[0];
if(error){

  inputGroup.next('.text-danger').remove();

  inputGroup
  .addClass('has-error')
  .after('<p class="text-danger">' + error + '</p>');
}
}
});
});
</script>

@endsection
