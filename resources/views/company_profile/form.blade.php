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

    <div class="form-group">
      <label for="email" class="control-label col-md-3">Email</label>
      <div class="col-md-8">
        {!! Form::text('email',null, ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="form-group" id="phone-field">
      <label for="phone" class="control-label col-md-3">Phone</label>
      <div class="col-md-8">
        {!! Form::text('phone',null, ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="form-group" id="phone-field">
      <label for="phone" class="control-label col-md-3">Address</label>
      <div class="col-md-8">
        {!! Form::text('address',null, ['class' => 'form-control']) !!}
      </div>
    </div>
    @if( Auth::user()->company()->first()->subscribed('main') )
    <div class="form-group" id="phone-field">
      <label for="phone" class="control-label col-md-3">Has monthly subscription</label>
    </div>
    @endif
    @if( Auth::user()->company()->first()->onTrial() )
    <div class="form-group" id="phone-field">
      <label for="phone" class="control-label col-md-3">On Trial</label>
    </div>
    @endif




  <div class="form-group" id="add-new-group" style="display:none">
    <div class="col-md-offset-3 col-md-8">
      <div class="input-group">
        <input type="text" name="new_group" id="new_group" class="form-control">
        <span class="input-group-btn">
          <a href="#" id="add-new-btn" class="btn btn-default">
            <i class="glyphicon glyphicon-ok"></i>
          </a>
        </span>
      </div>
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
    <button type="submit" class="btn btn-primary" id="save-user-btn">{{ ! empty($contact->id) ? "Update" : "Save" }}</button>
    <a href="{{ url('/companies') }}" class="btn btn-default">Cancel</a>
  </div>
</div>
</div>
</div>
</div>

@section('form-script')

<script>

$("#PIN").on('change keyup paste', function() {
if($("#PIN").val()==$("#PIN").attr('original_pin')){
$("#pin-help-text").hide(500);
return;
}
$("#save-user-btn").prop('disabled', true);
$('#pin-help-text').html("Checking");
$("#pin-help-text").show(500);
$.ajax({
url: "{{ route("users.validate_pin") }}",
method: 'get',
data: {
pin: $("#PIN").val(),
_token: $("input[pin=_token]").val()
},
context: document.body,
success: function(response){
if(response>0){
  $('#pin-help-text').html("PIN Unavailable");
  $("#pin-help-text").show(500);
}else{
  $('#pin-help-text').html("PIN Available");
  $("#save-user-btn").prop('disabled', false);
}
// alert(response);

// $("#view-parts-button-container").show(500);
// $("#labor-container").show(500);
}
});
});


$("#add-new-group").hide();

function TogglePassword()
{
$("#change-pwd-field").toggle(500);
$("#change-pwd-btn-text").text($("#change-pwd-btn-text").text() == 'Change Password' ? 'Keep Original Password' : 'Change Password' );
}
CheckAccounts();
function CheckAccounts()
{
var hide_phone_fields = true;

if($("#fuel_group_id").val()==""){
$("#fuel-options").hide(500);
}else{
$("#pin-field").show(500);
$("#fuel-options").show(500);

if(document.getElementById('send_text_at_fueling').checked){
hide_phone_fields = false;
}else{
hide_phone_fields = true;
}
}
if($("input[name='roles[]']:checked").size()==0){
$("#pwd-field").hide(500);
}else{
hide_phone_fields = false;
$("#pwd-field").show(500);
$("#pin-field").show(500);
}

if($("#fuel_group_id").val()=="" && $("input[name='roles[]']:checked").size()==0){
$("#pin-field").hide(500);
hide_phone_fields = true;
}
if(hide_phone_fields){
$("#phone-field").hide(500);
$("#provider-field").hide(500);
}else{
$("#phone-field").show(500);
$("#provider-field").show(500);
}
}


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
