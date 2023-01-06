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
                    <label for="name" class="control-label col-md-3">First Name</label>
                    <div class="col-md-8">
                     {!! Form::text('first_name',null, ['class' => 'form-control']) !!}
                   </div>
                 </div>
                 <div class="form-group">
                   <label for="name" class="control-label col-md-3">Last Name</label>
                   <div class="col-md-8">
                    {!! Form::text('last_name',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="control-label col-md-3">Email</label>
                  <div class="col-md-8">
                    {!! Form::text('email',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group" style="display:none">
                  <label for="group" class="control-label col-md-3">Login Account</label>
                  <div class="col-md-8">
                   {!! Form::select('login_account_id', App\LoginAccount::orderBy('name','asc')->pluck('name','id'), null, ['class' =>'form-control', 'placeholder' => 'User will not login', 'onchange' => 'CheckAccounts()', 'id' => 'login_account_id']) !!}
                 </div>
              </div>
              <div class="form-group" title="Fuel groups determine what machine a user can fill.">
                  <label for="group" class="control-label col-md-3">Fuel Group</label>
                  <div class="col-md-8">
                   {!! Form::select('fuel_group_id', App\FuelGroup::where('company_id',Auth::user()->company()->first()->id)->orderBy('name','asc')->pluck('name','id'), null, ['class' =>'form-control', 'placeholder' => 'User will not fuel', 'onchange' => 'CheckAccounts()', 'id' => 'fuel_group_id']) !!}
                 </div>
              </div>
              <div class="form-group" id="fuel-options" style="display:none">
                <label for="group" class="control-label col-md-3">Fuel Options</label>
                <div class="col-md-8">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="send_text_at_fueling" id="send_text_at_fueling" onchange="CheckAccounts()" {{ !empty($user) ? $user->send_text_at_fueling==1 ? "checked" : "" : "" }}> Send Text After Fueling
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="send_email_at_fueling" id="send_email_at_fueling" onchange="CheckAccounts()" {{ !empty($user) ? $user->send_email_at_fueling==1 ? "checked" : "" : "" }}> Send Email After Fueling
                    </label>
                  </div>
                </div>
              </div>
                <div class="form-group" id="phone-field" style="display:none">
                  <label for="phone" class="control-label col-md-3">Phone</label>
                  <div class="col-md-8">
                    {!! Form::number('cell_number',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group" id="provider-field" style="display:none">
                  <label for="group" class="control-label col-md-3">Cell Provider</label>
                  <div class="col-md-8">
                    {!! Form::select('cell_provider',['Verizon', 'AT&T'], null, ['class' =>'form-control', 'placeholder' => 'Select a Provider']) !!}
                  </div>
              </div>

                <div class="form-group" id="pwd-field" style="display:none">
                  <label for="name" class="control-label col-md-3">Password</label>
                  <div class="col-md-8" style="display:{{ !empty($user) ? "" : "none"}}">
                    <button type="button" class="btn btn-default btn-block" onClick="TogglePassword()" id="change-pwd-btn-text">Change Password</button>
                  </div>
                  <div class="{{ !empty($user) ? "col-md-offset-3" : ""}} col-md-8" id="change-pwd-field" style="display:{{ !empty($user) ? "none" : ""}}">
                    {!! Form::text('password', null, ['class' => 'form-control', 'rows' => 2, 'id' => 'password', 'original_value' => empty($user) ? "" : $user->password ]) !!}
                  </div>
                </div>
                <div class="form-group" id="pin-field" style="display:none">
                  <label for="name" class="control-label col-md-3">PIN</label>
                  <div class="col-md-8">
                    {!! Form::text('PIN',null, ['class' => 'form-control', 'id' => 'PIN', 'original_pin' =>  !empty($user) ? $user->PIN : -1 ]) !!}
                    <p class="help-block" id="pin-help-text"></p>
                  </div>
                </div>

                <div class="form-group" id="role-options">
                  <label for="group" class="control-label col-md-3">Rights</label>
                  <div class="col-md-8">
                    @foreach (App\Role::where('name', '<>', 'Super Admin')->orderBy('name')->get() as $role)

                        <div class="checkbox" style="display:{{ Auth::user()->company()->first()->hasRight($role->name) ? "block" : "none" }}">
                          <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" title="{{ $role->description }}" onchange="CheckAccounts()" {{ !empty($user) ? $user->hasRole($role->name) ? 'checked' : '' : '' }}> {{ $role->name }}
                          </label>
                        </div>
                    @endforeach
                  </div>
                </div>
                <div class="form-group" id="Assignment">
                  <label for="group" class="control-label col-md-3">Assignment</label>
                  <div class="col-md-8">
                    Checkbox 1: Assignment<br>
                    Checkbox 2: Daily Text Message<br>
                    Checkbox 3: Weekly Text Message<br>
                    <ul id="tree1">
                      <?php
                        $assignment_array=[];
                        $daily_array=[];
                        $weekly_array=[];
                        if(!empty($user)){
                          $assignment_array = $user->equipment()->get()->pluck('id')->toArray();
                          $daily_array = $user->equipment()->where('daily', '=', 1)->get()->pluck('id')->toArray();
                          $weekly_array = $user->equipment()->where('weekly', '=', 1)->get()->pluck('id')->toArray();
                        }
                      ?>
                      @foreach( Auth::user()->company()->first()->equipment_types()->orderBy("name")->get() as $equipment_types)
                      <li>
                        <input type="checkbox" parent="equipment_types[]" onChange="ToggleAssignment(this.checked, {{ $equipment_types->id }})" name="equipment_types[]" value="{{ $equipment_types->id }}" >
                        <input type="checkbox" parent="equipment_types[]" onChange="ToggleDaily(this.checked, {{ $equipment_types->id }})" name="equipment_types[]" value="{{ $equipment_types->id }}">
                        <input type="checkbox" parent="equipment_types[]" onChange="ToggleWeekly(this.checked, {{ $equipment_types->id }})" name="equipment_types[]" value="{{ $equipment_types->id }}">
                        {{ $equipment_types->name }}
                        <ul>
                          @foreach($equipment_types->equipment()->orderBy('unit_number')->get() as $equipment)
                          <li>
                            <input type="checkbox" assignment="{{ $equipment_types->id }}[]" name="equipment_assignment[]" value="{{ $equipment->id }}" {{ in_array($equipment->id, $assignment_array) ? "checked" : "" }}>
                            <input type="checkbox" daily="{{ $equipment_types->id }}[]" name="equipment_daily[]" value="{{ $equipment->id }}" {{ in_array($equipment->id, $daily_array) ? "checked" : "" }}>
                            <input type="checkbox" weekly="{{ $equipment_types->id }}[]" name="equipment_weekly[]" value="{{ $equipment->id }}" {{ in_array($equipment->id, $weekly_array) ? "checked" : "" }}>
                            ({{ $equipment->unit_number }}) {{ $equipment->name }}
                          </li>
                          @endforeach
                        </ul>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>

                <script>
                function ToggleAssignment(value, id)
                {
                  $("input[assignment='" + id + "[]']").each(function ()
                  {
                    $(this).prop('checked', value);
                  });
                }
                function ToggleDaily(value, id)
                {
                  $("input[daily='" + id + "[]']").each(function ()
                  {
                    $(this).prop('checked', value);
                  });
                }
                function ToggleWeekly(value, id)
                {
                  $("input[weekly='" + id + "[]']").each(function ()
                  {
                    $(this).prop('checked', value);
                  });
                }
                </script>




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
            <div class="col-md-4">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                  <?php $photo = ! empty($user->photo) ? $user->photo : 'default-user.png' ?>
                  {!! Html::image('uploads/' . $photo, "Choose photo", ['max-width'=>150, 'height'=>'auto']) !!}
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                <div class="text-center">
                  <span class="btn btn-default btn-file"><span class="fileinput-new">Choose Photo</span><span class="fileinput-exists">Change</span>{!! Form::file('photo') !!}</span>
                  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-footer" style="display:{{ Auth::user()->hasRole("Edit Users") ? "block" : "none" }}">
        <div class="row">
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <button type="submit" class="btn btn-primary" id="save-user-btn">
                  <i class="glyphicon glyphicon-check"></i>
                  {{ ! empty($user->id) ? "Update" : "Save" }}
                </button>
                @if(false)
                <!-- empty($user->id) -->
                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                  <button onclick="return confirm('Are you sure? This cannot be undone.')" type="submit" class="btn btn-danger" title="Edit">
                    <i class="glyphicon glyphicon-remove"></i>
                    Delete
                  </button>
              {!! Form::close() !!}
              @endif
                <a href="{{ url('/users') }}" class="btn btn-default">
                  Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      @section('form-script')

      <script>

      $('#fuel_group_id').append('<option value="">User will not fuel</option>');

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
        if($("#change-pwd-btn-text").text() == 'Change Password'){
          $("#password").val($("#password").attr('original_value'));
        }else{
          $("#password").val('');
        }
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
