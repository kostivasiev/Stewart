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
                    <label for="company" class="control-label col-md-3">Unit Number</label>
                    <div class="col-md-8">
                      {!! Form::text('unit_number',null, ['class' => 'form-control', 'id' => 'unit_number', 'original_pin' =>  !empty($equipment) ? $equipment->unit_number : -1]) !!}
                      <p class="help-block" id="unit-number-help-text"></p>
                    </div>
                  </div>
                  <div class="form-group">
                   <label for="company" class="control-label col-md-3">VIN/Serial</label>
                   <div class="col-md-8">
                     {!! Form::text('vin',null, ['class' => 'form-control']) !!}
                     <p class="help-block" id="unit-number-help-text"></p>
                   </div>
                 </div>
                 <div class="form-group">
                  <label for="company" class="control-label col-md-3">Plate Number</label>
                  <div class="col-md-8">
                    {!! Form::text('plate_number',null, ['class' => 'form-control']) !!}
                    <p class="help-block" id="unit-number-help-text"></p>
                  </div>
                </div>
                <div class="form-group" id="meter-type-field" style="display:none">
                  <label for="group" class="control-label col-md-3">Fuel Type</label>
                  <div class="col-md-8">
                   {!! Form::select('fuel_type', ['Not Selected', 'Red Diesel', 'Clear Diesel', 'Gasoline', 'DFM', 'Other'], null, ['class' =>'form-control']) !!}
                  </div>
                </div>
                <div class="form-group" style="display:none">
                  <label for="company" class="control-label col-md-3">Group</label>
                  <div class="col-md-8">
                    {!! Form::select('equipment_groups_id', App\EquipmentGroup::orderBy('name','asc')->pluck('name','id'), null, ['class' =>'form-control']) !!}
                  </div>
                </div>
                <div class="form-group" style="display:none">
                  <label for="group" class="control-label col-md-3">Fueler</label>
                  <div class="col-md-8">
                    {!! Form::select('fueler',['Does Not Fuel', 'Fuels'], null, ['class' =>'form-control', 'onchange' => 'ToggleFuelerFields()', 'id' => 'is-fueler-btn']) !!}
                  </div>
                </div>
                <div class="form-group" id="meter-type-field" style="display:none">
                  <label for="group" class="control-label col-md-3">Meter</label>
                  <div class="col-md-8">
                   {!! Form::select('meter_type', ['Hour Meter', 'Odometer', 'No Meter', 'Non Fueler'], null, ['class' =>'form-control']) !!}
                  </div>
                </div>
                <div class="form-group" id="current-meter-field" style="display:none">
                  <label for="phone" class="control-label col-md-3">Current Miles</label>
                  <div class="col-md-8">
                    {!! Form::text('current_meter',$current_meter, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group">
                 <label for="company" class="control-label col-md-3">Notes</label>
                 <div class="col-md-8">
                   {!! Form::textarea('notes',null, ['class' => 'form-control']) !!}
                   <p class="help-block" id="notes-help-text"></p>
                 </div>
               </div>
                <div class="form-group" style="display:{{ Auth::user()->hasRole("Edit Intervals") ? "block" : "none" }}">
                  <label for="group" class="control-label col-md-3">Type</label>
                  <div class="col-md-5">
                    <select class="form-control" name="equipment_type_id" id="equipment_type_id">
                    @foreach ($equipment_types as $equipment_type)
                     <option value="{{ $equipment_type->id }}" {{ !empty($equipment->equipment_type_id) ? $equipment_type->id==$equipment->equipment_type_id ? "selected" : "" : "" }}>{{ $equipment_type->name }}</option>
                    @endforeach
                  </select>
                 </div>
                 <div class="col-md-3">
                    <a id="add-equipment-type-btn" class="btn btn-default btn-block">Add Type</a>
                 </div>
                </div>
                <div class="form-group" id="add-new-equipment-type" style="display:none">
                <div class="col-md-offset-3 col-md-8">
                  <div class="input-group">
                    <input type="text" name="new_type" id="new_type" class="form-control">
                    <span class="input-group-btn">
                      <a id="add-new-equipment-type-btn" class="btn btn-default">
                        <i class="glyphicon glyphicon-ok"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
                <div class="form-group" id="make-div" style="display:none">
                  <label for="group" class="control-label col-md-3">Make</label>
                  <div class="col-md-5">
                   {!! Form::select('make_id', !empty($makes) ? $makes : ['--'], !empty($make_id) ? $make_id : null, ['class' =>'form-control', 'id' => 'make_id']) !!}
                 </div>
                 <div class="col-md-3">
                    <a href="#" id="add-make-btn" class="btn btn-default btn-block">Add Make</a>
                 </div>
                </div>
                <div class="form-group" id="add-new-make" style="display:none">
                <div class="col-md-offset-3 col-md-8">
                  <div class="input-group">
                    <input type="text" name="new_make" id="new_make" class="form-control">
                    <span class="input-group-btn">
                      <a href="#" id="add-new-make-btn" class="btn btn-default">
                        <i class="glyphicon glyphicon-ok"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
                <div class="form-group" id="model-div" style="display:none">
                  <label for="group" class="control-label col-md-3">Model</label>
                  <div class="col-md-5">
                   {!! Form::select('emodel_id', !empty($emodels) ? $emodels : ['--'], !empty($equipment->emodel_id) ? $equipment->emodel_id : null, ['class' =>'form-control', 'id' => 'emodel_id']) !!}
                 </div>
                 <div class="col-md-3">
                  <a href="#" id="add-model-btn" class="btn btn-default btn-block">Add Model</a>
                </div>
              </div>
              <div class="form-group" id="add-new-model" style="display:none">
                <div class="col-md-offset-3 col-md-8">
                  <div class="input-group">
                    <input type="text" name="new_model" id="new_model" class="form-control">
                    <span class="input-group-btn">
                      <a href="#" id="add-new-model-btn" class="btn btn-default">
                        <i class="glyphicon glyphicon-ok"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="year-div" style="display:none">
                  <label for="group" class="control-label col-md-3">Year</label>
                  <div class="col-md-5">
                   {!! Form::select('year_id', !empty($years) ? $years : ['--'], !empty($equipment->year_id) ? $equipment->year_id : null, ['class' =>'form-control', 'id' => 'year_id']) !!}
                 </div>
                 <div class="col-md-3">
                    <a href="#" id="add-year-btn" class="btn btn-default btn-block">Add Year</a>
                 </div>
                </div>
              <div class="form-group" id="add-new-year" style="display:none">
                <div class="col-md-offset-3 col-md-8">
                  <div class="input-group">
                    <input type="text" name="new_year" id="new_year" class="form-control">
                    <span class="input-group-btn">
                      <a href="#" id="add-new-year-btn" class="btn btn-default">
                        <i class="glyphicon glyphicon-ok"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="trim-div" style="display:none">
                  <label for="group" class="control-label col-md-3">Trim</label>
                  <div class="col-md-5">
                   {!! Form::select('trim_id', App\Trim::orderBy('name','asc')->pluck('name','id'), null, ['class' =>'form-control']) !!}
                 </div>
                 <div class="col-md-3">
                    <a href="#" id="add-trim-btn" class="btn btn-default btn-block">Add Trim</a>
                 </div>
                </div>
              <div class="form-group" id="add-new-trim" style="display:none">
                <div class="col-md-offset-3 col-md-8">
                  <div class="input-group">
                    <input type="text" name="new_trim" id="new_trim" class="form-control">
                    <span class="input-group-btn">
                      <a href="#" id="add-new-trim-btn" class="btn btn-default">
                        <i class="glyphicon glyphicon-ok"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
              @foreach(Auth::user()->company()->first()->variables()->get() as $variable)

                <div class="form-group">
                  <label for="name" class="control-label col-md-3">{{ $variable->name }}</label>
                  @if ($variable->type=="text")
                    <div class="col-md-8">
                     <input type="text" name="variable_id_{{ $variable->id }}" other="12" class="form-control" value="test">
                    </div>
                  @endif
                  @if ($variable->type=="select")
                    <div class="col-md-8">
                     <select class="form-control" name="variable_id_{{ $variable->id }}">
                       @foreach($variable->values()->get() as $value)
                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                       @endforeach
                     </select>

                    </div>
                  @endif
               </div>
              @endforeach
              <div class="form-group" id="fuel-groups-fueler-fields" style="display:none">
                <label for="group" class="control-label col-md-3">Fuel Groups</label>
                <div class="col-md-8">
                  @foreach($fuel_groups as $fuel_group)
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="fuel_groups[]" value="{{ $fuel_group->id }}" {{ $fuel_group->checked ? "checked" : ""}}> {{ $fuel_group->name }}
                    </label>
                  </div>
                  @endforeach
                </div>
              </div>
              <div class="form-group" id="fuel-stations-fueler-fields" style="display:none">
                <label for="group" class="control-label col-md-3">Fuel Stations</label>
                <div class="col-md-8">
                  @foreach($fuel_pumps as $fuel_pump)
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="fuel_pumps[]" value="{{ $fuel_pump->id }}" {{ $fuel_pump->checked ? "checked" : ""}}> {{ $fuel_pump->station()->first()->name }} - {{ $fuel_pump->name }}
                    </label>
                  </div>
                  @endforeach
                </div>
              </div>
              <div class="form-group" style="display:{{ Auth::user()->hasRole("Edit Intervals") ? "block" : "none" }}">
                <label for="name" class="control-label col-md-3"></label>
                <div class="col-md-8">
                  <button type="button" class="btn btn-default btn-block" onClick="ToggleSetupAlertsFields()" id="change-pwd-btn-text">Maintenance Details</button>
                </div>
              </div>
              <div class="form-group" id="setup-alerts-fields" style="display:none">
                <label for="group" class="control-label col-md-3">Mechanics to receive Alerts</label>
                <div class="col-md-8">
                  <table>
                    <tr>
                      <td>
                        User
                      </td>
                      <td>
                        Assigned
                      </td>
                      <td>
                        Daily Report
                      </td>
                      <td>
                        Detailed Daily Report
                      </td>
                      <td>
                        Weekly Report
                      </td>
                    </tr>
                  @foreach( $mechanics as $user)
                  <tr>
                    <td>{{ $user->last_name }}, {{ $user->first_name }}</td>
                    <td>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="assigned[]" value="{{ $user->id }}" {{ !empty ($equipment) ? $equipment->users->contains($user->id) ? 'checked' : '' : ''}}  >
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="daily_reports[]" value="{{ $user->id }}" >
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="weekly_reports[]" value="{{ $user->id }}" >
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="detailed_reports[]" value="{{ $user->id }}" >
                        </label>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  </table>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                  <?php $photo = ! empty($equipment->photo) ? $equipment->photo : 'default.png' ?>
                  {!! Html::image('uploads/' . $photo, "Choose photo", ['max-width'=>150, 'height'=>'auto']) !!}
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                <div class="text-center">
                  <span class="btn btn-default btn-file"><span class="fileinput-new">Choose Photo</span><span class="fileinput-exists">Change</span>{!! Form::file('photo') !!}</span>
                  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
              </div>
            </div>
            @if (!empty($equipment))
            @foreach($equipment->photos()->get() as $photo)
            <div class="col-md-4">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                @if ( ends_with($photo->file_path, 'jpg')
                || ends_with($photo->file_path, 'png')
                || ends_with($photo->file_path, 'jpeg'))
                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                  {!! Html::image('uploads/' . $photo->file_path, "Choose photo", ['max-width'=>150, 'height'=>'auto']) !!}
                </div>
                <div class="text-center">
                  <a href="{{ asset('uploads') }}/{{ $photo->file_path }}">{{ $photo->name }}</a>
                  <button type="button" class="btn btn-circle btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
                </div>
                @else
                <div class="text-center">
                  <a href="{{ asset('uploads') }}/{{ $photo->file_path }}">{{ $photo->name }}</a>
                  <button type="button" class="btn btn-circle btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
                </div>
                @endif

              </div>
            </div>
            @endforeach
              @endif

            <button type="button" class="btn btn-default">Add File</button>
          </div>
        </div>
      </div>
      <div class="panel-footer" style="display:{{ Auth::user()->hasRole("Edit Equipment") ? "block" : "none" }}">
        <div class="row">
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <button type="submit" class="btn btn-primary" id="save-equipment-btn">
                  <i class="glyphicon glyphicon-check"></i>
                  {{ ! empty($contact->id) ? "Update" : "Save" }}
              </button>
                @if( Auth::user()->hasRole("Delete Equipment"))
                  <button onclick="DeleteEquipment()" type="button" class="btn btn-danger" title="Edit">
                    <i class="glyphicon glyphicon-remove"></i>
                    Delete
                  </button>
                @endif
                <a href="{{ url('/equipment?size=10&equipment-in-view=1') }}" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      @section('form-script')

      <script>

      $("#unit_number").on('change keyup paste', function() {
        if($("#unit_number").val()==$("#unit_number").attr('original_pin')){
          $("#unit-number-help-text").hide(500);
          return;
        }
        $("#save-equipment-btn").prop('disabled', true);
        $('#unit-number-help-text').html("Checking");
        $("#unit-number-help-text").show(500);
        $.ajax({
          url: "{{ route("equipment.validate_unit_number") }}",
          method: 'get',
          data: {
            unit_number: $("#unit_number").val(),
            _token: $("input[unit_number=_token]").val()
          },
          context: document.body,
          success: function(response){
            if(response>0){
              $('#unit-number-help-text').html("Unit Number Unavailable");
              $("#unit-number-help-text").show(500);
            }else{
              $('#unit-number-help-text').html("Unit Number Available");
              $("#save-equipment-btn").prop('disabled', false);
            }
            // alert(response);

            // $("#view-parts-button-container").show(500);
            // $("#labor-container").show(500);
          }
        });
      });


      ToggleFuelerFields();
      function ToggleFuelerFields(){
        if($("#is-fueler-btn").val()==""){
          // $("#fuel-stations-fueler-fields").toggle(500);
          $("#fuel-groups-fueler-fields").toggle(500);
          $("#current-meter-field").toggle(500);
          $("#meter-type-field").toggle(500);
        }else{
          // $("#fuel-stations-fueler-fields").toggle(500);
          $("#fuel-groups-fueler-fields").toggle(500);
          $("#current-meter-field").toggle(500);
          $("#meter-type-field").toggle(500);
        }

      }
      function ToggleSetupAlertsFields(){
        $("#setup-alerts-fields").toggle(500);
      }

      @if (Auth::user()->hasRole("Edit Intervals"))
        organize_tmmy_lists();
      @endif

      function organize_tmmy_lists(){
        @if (!empty($equipment))
        get_makes({{ $equipment->make_id }}, {{ $equipment->emodel_id }}, {{ $equipment->year_id }});
        @endif
        // get_years();

      }
      $("#equipment_type_id").change(function(){get_makes(); });
      $("#make_id").change(function() {get_models()});
      $("#emodel_id").change(function() {get_years()});

      $("#trim-div").hide();

      function get_makes(selected_make_id, selected_emodel_id, selected_year_id) {
          $("#make-div").hide(500);
          $("#model-div").hide(500);
          $("#year-div").hide(500);
          $.ajax({
            url: "{{ route("makes.index_from_type") }}",
            method: 'get',
            data: {
              equipment_type_id: $("#equipment_type_id").val(),
              _token: $("input[equipment_type_id=_token]").val()
            },
            context: document.body,
            success: function(makes){
              $('select[name=make_id]').empty();
              var newOption = $('<option></option>')
                .attr('value', '')
                .text("--");
                $("select[name=make_id]")
                   .append( newOption );
              for (var i=0; i<makes.length; i++) {
               var newOption = $('<option></option>')
                 .attr('value', makes[i].id)
                 .text(makes[i].name);
              $("select[name=make_id]")
                 .append( newOption );
              }
              if(selected_make_id>0){
                $('select[name=make_id]').val(selected_make_id);
                get_models(selected_emodel_id, selected_year_id);
              }
              $("#make-div").slideToggle(500);
            }
        });
      }


      function get_models(selected_emodel_id, selected_year_id){
          $("#model-div").hide(500);
          $("#year-div").hide(500);
          $.ajax({
            url: "{{ route("models.index_from_make") }}",
            method: 'get',
            data: {
              make_id: $("#make_id").val(),
              _token: $("input[make_id=_token]").val()
            },
            context: document.body,
            success: function(models){

              $('select[name=emodel_id]').empty();

              var newOption = $('<option></option>')
                .attr('value', '')
                .text("--");
                $("select[name=emodel_id]")
                   .append( newOption );
              for (var i=0; i<models.length; i++) {
               var newOption = $('<option></option>')
                 .attr('value', models[i].id)
                 .text(models[i].name);
              $("select[name=emodel_id]")
                 .append( newOption );
              }
              if(selected_emodel_id>0){
                $('select[name=emodel_id]').val(selected_emodel_id);
                get_years(selected_year_id);
              }

              $("#model-div").slideToggle(500);
            }
        });

      }

      function get_years(selected_year_id){
          $("#year-div").hide(500);
          $.ajax({
            url: "{{ route("years.index_from_model") }}",
            method: 'get',
            data: {
              model_id: $("#emodel_id").val(),
              _token: $("input[make_id=_token]").val()
            },
            context: document.body,
            success: function(models){
              $('select[name=year_id]').empty();
              var newOption = $('<option></option>')
                .attr('value', '')
                .text("--");
                $("select[name=year_id]")
                   .append( newOption );
              for (var i=0; i<models.length; i++) {
               var newOption = $('<option></option>')
                 .attr('value', models[i].id)
                 .text(models[i].year);
              $("select[name=year_id]")
                 .append( newOption );
              }
              if(selected_year_id>0){
                $('select[name=year_id]').val(selected_year_id);
              }
              $("#year-div").slideToggle(500);
            }
        });

      }


      </script>

      <script>
      $("#add-new-equipment-type").hide();
      $('#add-equipment-type-btn').click(function () {
        $("#add-new-equipment-type").slideToggle(function() {
          $('#new_type').focus();
        });
        return false;
      });

      $("#add-new-equipment-type-btn").click(function() {

        var newGroup = $("#new_type");
        var inputGroup = newGroup.closest('.input-group');

        $.ajax({
          url: "{{ route("equipment_types.store") }} ",
          method: 'post',
          data: {
            name: $("#new_type").val(),
            _token: $("input[name=_token]").val()
          },
          success: function (equipment_type){
            if(equipment_type.id != null){
              inputGroup.removeClass('has-error');
              inputGroup.next('.text-danger').remove();

              var newOption = $('<option></option>')
              .attr('value', equipment_type.id)
              .attr('selected', true)
              .text(equipment_type.name);


              $("select[name=equipment_type_id]")
              .append( newOption );
              newGroup.val("");
              $("#add-new-equipment-type").slideToggle();
              $("#equipment_type_id" ).change();
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
            <script>
      $("#add-new-make").hide();
      $('#add-make-btn').click(function () {
        $("#add-new-make").slideToggle(function() {
          $('#new_make').focus();
        });
        return false;
      });

      $("#add-new-make-btn").click(function() {

        var newGroup = $("#new_make");
        var inputGroup = newGroup.closest('.input-group');

        $.ajax({
          url: "{{ route("makes.store") }} ",
          method: 'post',
          data: {
            name: $("#new_make").val(),
            equipment_type_id: $("#equipment_type_id").val(),
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


              $("select[name=make_id]")
              .append( newOption );

              newGroup.val("");
              $("#add-new-make").slideToggle();
              $("#make_id" ).change();
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
            <script>
      $("#add-new-model").hide();
      $('#add-model-btn').click(function () {
        $("#add-new-model").slideToggle(function() {
          $('#new_model').focus();
        });
        return false;
      });

      $("#add-new-model-btn").click(function() {

        var newGroup = $("#new_model");
        var inputGroup = newGroup.closest('.input-group');

        $.ajax({
          url: "{{ route("models.store") }} ",
          method: 'post',
          data: {
            name: $("#new_model").val(),
            make_id: $("#make_id").val(),
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


              $("select[name=emodel_id]")
              .append( newOption );
              newGroup.val("");
              $("#add-new-model").slideToggle();
              $("#emodel_id" ).change();
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
            <script>
      $("#add-new-year").hide();
      $('#add-year-btn').click(function () {
        $("#add-new-year").slideToggle(function() {
          $('#new_year').focus();
        });
        return false;
      });

      $("#add-new-year-btn").click(function() {

        var newGroup = $("#new_year");
        var inputGroup = newGroup.closest('.input-group');

        $.ajax({
          url: "{{ route("years.store") }} ",
          method: 'post',
          data: {
            year: $("#new_year").val(),
            emodel_id: $("#emodel_id").val(),
            _token: $("input[name=_token]").val()
          },
          success: function (group){
            if(group.id != null){
              inputGroup.removeClass('has-error');
              inputGroup.next('.text-danger').remove();

              var newOption = $('<option></option>')
              .attr('value', group.id)
              .attr('selected', true)
              .text(group.year);


              $("select[name=year_id]")
              .append( newOption );
              newGroup.val("");
              $("#add-new-year").slideToggle();
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
            <script>
      $("#add-new-trim").hide();
      $('#add-trim-btn').click(function () {
        $("#add-new-trim").slideToggle(function() {
          $('#new_trim').focus();
        });
        return false;
      });

      $("#add-new-trim-btn").click(function() {

        var newGroup = $("#new_trim");
        var inputGroup = newGroup.closest('.input-group');

        $.ajax({
          url: "{{ route("makes.store") }} ",
          method: 'post',
          data: {
            name: $("#new_type").val(),
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
