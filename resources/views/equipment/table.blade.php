@extends('layouts.equipment_table')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Equipment Table</strong>
            </div>
            <div class="form-group" id="setup-alerts-fields">
              <div class="panel-body">
                <table class="">
                  <tr>
                    <td>
                      Unit Number
                    </td>
                    <td>
                      Name
                    </td>
                    <td>
                      Meter Type
                    </td>
                    <td>
                      Fuel Type
                    </td>
                    <td>Equipment Type</td>
                    <td>Make</td>
                    <td>Model</td>
                    <td>Year</td>
                  </tr>
                @foreach( $pieces as $piece)
                <tr>
                  <td>
                    <input type="text" value="{{ $piece->unit_number }}" id="unit-number-{{ $piece->id }}" set-value="{{ $piece->unit_number }}" onchange="AttributeChanged(this, 'unit-number-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'unit-number-', {{ $piece->id }})"></td>
                  <td>
                    <input type="text" value="{{ $piece->name }}" id="name-{{ $piece->id }}" set-value="{{ $piece->name }}" onchange="AttributeChanged(this, 'name-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'name-', {{ $piece->id }})">
                  </td>
                  <td>
                    <select class="form-control" value="{{ $piece->meter_type }}" id="meter-type-{{ $piece->id }}" set-value="{{ $piece->meter_type }}" onchange="AttributeChanged(this, 'meter-type-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'meter-type-', {{ $piece->id }})">
                      <option value=2 {{ $piece->meter_type==2 ? "selected" : ""}}>No Meter</option>
                      <option value=1 {{ $piece->meter_type==1 ? "selected" : ""}}>Odometer</option>
                      <option value=0 {{ $piece->meter_type==0 ? "selected" : ""}}>Hour Meter</option>
                      <option value=3 {{ $piece->meter_type==3 ? "selected" : ""}}>Non Fueler</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" value="{{ $piece->fuel_type }}" id="fuel-type-{{ $piece->id }}" set-value="{{ $piece->fuel_type }}" onchange="AttributeChanged(this, 'fuel-type-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'fuel-type-', {{ $piece->id }})">
                      <option value="0" {{ $piece->fuel_type == 0 ? "selected" : "" }}>Not Selected</option>
                      <option value="1" {{ $piece->fuel_type == 1 ? "selected" : "" }}>Red Diesel</option>
                      <option value="2" {{ $piece->fuel_type == 2 ? "selected" : "" }}>Clear Diesel</option>
                      <option value="3" {{ $piece->fuel_type == 3 ? "selected" : "" }}>Gasoline</option>
                      <option value="4" {{ $piece->fuel_type == 4 ? "selected" : "" }}>DFM</option>
                      <option value="5" {{ $piece->fuel_type == 5 ? "selected" : "" }}>Other</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" value="{{ $piece->equipment_type }}" id="equipment-type-sel-{{ $piece->id }}" set-value="{{ $piece->equipment_type_id }}" onchange="DependentAttributeChanged(this, 'equipment-type-sel-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'equipment-type-sel-', {{ $piece->id }})">
                    @foreach ($equipment_types as $equipment_type)
                      <option value="{{ $equipment_type->id }}" {{ !empty($piece->equipment_type_id) ? $equipment_type->id==$piece->equipment_type_id ? "selected" : "" : "" }}>{{ $equipment_type->name }}</option>
                    @endforeach
                      <option value="-1">Add Value</option>
                    </select>
                    <div class="form-group" id="add-new-equipment-type-{{ $piece->id }}" style="display:none">
                        <div class="input-group">
                          <input type="text" name="new-equipment-type-{{ $piece->id }}" id="new-equipment-type-{{ $piece->id }}" class="form-control">
                          <span class="input-group-btn">
                            <a id="add-new-type-btn" class="btn btn-default" onclick="AddNewEquipmentType({{ $piece->id }})">
                              <i class="glyphicon glyphicon-ok"></i>
                            </a>
                          </span>
                        </div>
                    </div>
                  </td>
                  <td>
                    <button class="btn btn-default btn-block" id="make-btn-{{ $piece->id }}" set-value="{{ $piece->make()->first() ?  $piece->make()->first()->name : "Unassigned" }}" onclick="ChangeMake({{ $piece->id }}, {{ $piece->make_id }})">{{ $piece->make()->first() ? $piece->make()->first()->name : "Unassigned" }}</button>
                    <select class="form-control" id="make-sel-{{ $piece->id }}" style="display:none" set-value="{{ $piece->make_id }}" onchange="DependentAttributeChanged(this, 'make-sel-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'make-sel-', {{ $piece->id }})">
                      <option value="{{ $piece->make_id }}" selected></option>
                    </select>
                    <div class="form-group" id="add-new-make-{{ $piece->id }}" style="display:none">
                        <div class="input-group">
                          <input type="text" name="new-make-{{ $piece->id }}" id="new-make-{{ $piece->id }}" class="form-control">
                          <span class="input-group-btn">
                            <a id="add-new-make-btn" class="btn btn-default" onclick="AddNewMake({{ $piece->id }})">
                              <i class="glyphicon glyphicon-ok"></i>
                            </a>
                          </span>
                        </div>
                    </div>
                  </td>
                  <td>
                    <button class="btn btn-default btn-block" id="model-btn-{{ $piece->id }}" set-value="{{ $piece->model()->first() ?  $piece->model()->first()->name : "Unassigned" }}" onclick="ChangeModel({{ $piece->id }}, {{ $piece->emodel_id }})">{{ $piece->model()->first() ?  $piece->model()->first()->name : "Unassigned" }}</button>
                    <select class="form-control" id="model-sel-{{ $piece->id }}" style="display:none" set-value="{{ $piece->emodel_id }}" onchange="DependentAttributeChanged(this, 'model-sel-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'model-sel-', {{ $piece->id }})">
                      <option value="{{ $piece->emodel_id }}" selected></option>
                    </select>
                    <div class="form-group" id="add-new-model-{{ $piece->id }}" style="display:none">
                        <div class="input-group">
                          <input type="text" name="new-model-{{ $piece->id }}" id="new-model-{{ $piece->id }}" class="form-control">
                          <span class="input-group-btn">
                            <a id="add-new-model-btn" class="btn btn-default" onclick="AddNewModel({{ $piece->id }})">
                              <i class="glyphicon glyphicon-ok"></i>
                            </a>
                          </span>
                        </div>
                    </div>
                  </td>
                  <td>
                    <button class="btn btn-default btn-block" id="year-btn-{{ $piece->id }}" set-value="{{ $piece->year()->first() ?  $piece->year()->first()->year : "Unassigned" }}" onclick="ChangeYear({{ $piece->id }}, {{ $piece->year_id }})">{{ $piece->year()->first() ? $piece->year()->first()->year : "Unassigned" }}</button>
                    <select class="form-control" id="year-sel-{{ $piece->id }}" style="display:none" set-value="{{ $piece->year_id }}" onchange="DependentAttributeChanged(this, 'year-sel-', {{ $piece->id }})" onkeyup="AttributeChanged(this, 'year-sel-', {{ $piece->id }})">
                      <option value="{{ $piece->year_id }}" selected></option>
                    </select>
                    <div class="form-group" id="add-new-year-{{ $piece->id }}" style="display:none">
                        <div class="input-group">
                          <input type="text" name="new-year-{{ $piece->id }}" id="new-year-{{ $piece->id }}" class="form-control">
                          <span class="input-group-btn">
                            <a id="add-new-year-btn" class="btn btn-default" onclick="AddNewYear({{ $piece->id }})">
                              <i class="glyphicon glyphicon-ok"></i>
                            </a>
                          </span>
                        </div>
                    </div>
                  </td>
                  <td>
                    <button type="button" class="btn btn-warning" onclick="GetIntervals({{ $piece->id }})">Intervals</button>

                  </td>
                  <td class="" style="display:none" id="equipment-intervals-container-{{ $piece->id }}">
                    <span id="equipment-intervals-span-{{ $piece->id }}"></span>
                  </td>
                  <td><button type="button" class="btn btn-warning" style="display:none" id="reset-button-{{ $piece->id }}" onclick="ResetRow({{ $piece->id }})" >Reset</button></td>
                  <td><button type="button" class="btn btn-danger"  style="display:none" id="save-button-{{ $piece->id }}"  onclick="SaveRow({{ $piece->id }})"  >Save</button></td>
                </tr>
                @endforeach
                </table>
              </div>

            </div>
          </div>

          <script>

          var reset_cnt = 0;
          function ResetMultipleIntervals(interval_ids, equipment_id){
            console.log(interval_ids + " " + equipment_id);
            reset_cnt = interval_ids.length;
            for(var i=0; i<interval_ids.length; i++){
              // alert($("#reset-interval-checkbox-" + interval_ids[i]).is(":checked"));
              ResetInterval(interval_ids[i], equipment_id);
            }
          }

          function ResetInterval(interval_id, equipment_id){
            console.log(equipment_id + " - " + interval_id);
            $.ajax({
              url: "{{ route("workorders.reset_interval") }} ",
              method: 'post',
              data: {
                name: "new_group",
                interval_id: interval_id,
                equipment_id: equipment_id,
                meter_due: $("#next-meter-interval-" + interval_id + "-" + equipment_id).val(),
                date_due: $("#next-date-interval-" + interval_id + "-" + equipment_id).val(),
                _token: $("input[name=_token]").val()
              },
              success: function (group){
                console.log(group);
                reset_cnt--;
                if(reset_cnt==0){
                  GetIntervals(equipment_id);
                }
              },
              error: function (xhr){
                  alert(xhr);
              }
            });
          }

          function GetIntervals(id){
            console.log(id);
            $("#equipment-intervals-container-"+id).hide(500);
            $.ajax({
              url: "{{ route("workorders.intervals") }}",
              method: 'get',
              data: {
                equipment_id: id,
                hour_flag: 3,
                _token: $("input[equipment_id=_token]").val()
              },
              context: document.body,
              success: function(response){
                console.log("Intervals Ready");
                // console.log(response);
                $('#equipment-intervals-span-'+id).html(response);
                $("#equipment-intervals-container-"+id).show(500);
              }
            });
          }

          function AddNewEquipmentType(id){
            $.ajax({
              url: "{{ route("equipment_types.store") }} ",
              method: 'post',
              data: {
                name: $("#new-equipment-type-"+id).val(),
                _token: $("input[name=_token]").val()
              },
              success: function (type){
                var newOption = $('<option></option>')
                .attr('value', type.id)
                .attr('selected', true)
                .text(type.name);
                $("select[id=equipment-type-sel-" + id + "]")
                .append( newOption );
                document.getElementById("add-new-equipment-type-" + id).style.display="none";
                var e = document.getElementById("equipment-type-sel-" + id);
                e.style.display="block";
                DependentAttributeChanged(e, "equipment-type-", id);
              },
              error: function (xhr){
              }
            });
          }

          function AddNewMake(id){
            $.ajax({
              url: "{{ route("makes.store") }} ",
              method: 'post',
              data: {
                name: $("#new-make-"+id).val(),
                equipment_type_id: $("select[id=equipment-type-sel-" + id + "]").val(),
                _token: $("input[name=_token]").val()
              },
              success: function (make){
                var newOption = $('<option></option>')
                .attr('value', make.id)
                .attr('selected', true)
                .text(make.name);
                $("select[id=make-sel-" + id + "]")
                .append( newOption );
                document.getElementById("add-new-make-" + id).style.display="none";
                var e = document.getElementById("make-sel-" + id);
                e.style.display="block";
                DependentAttributeChanged(e, "make-sel-", id);
              },
              error: function (xhr){
              }
            });
          }

          function AddNewModel(id){
            $.ajax({
              url: "{{ route("models.store") }} ",
              method: 'post',
              data: {
                name: $("#new-model-"+id).val(),
                make_id: $("select[id=make-sel-" + id + "]").val(),
                _token: $("input[name=_token]").val()
              },
              success: function (model){
                var newOption = $('<option></option>')
                .attr('value', model.id)
                .attr('selected', true)
                .text(model.name);
                $("select[id=model-sel-" + id + "]")
                .append( newOption );
                document.getElementById("add-new-model-" + id).style.display="none";
                var e = document.getElementById("model-sel-" + id);
                e.style.display="block";
                DependentAttributeChanged(e, "model-sel-", id);
              },
              error: function (xhr){
              }
            });
          }

          function AddNewYear(id){
            $.ajax({
              url: "{{ route("years.store") }} ",
              method: 'post',
              data: {
                year: $("#new-year-"+id).val(),
                emodel_id: $("select[id=model-sel-" + id + "]").val(),
                _token: $("input[name=_token]").val()
              },
              success: function (year){
                var newOption = $('<option></option>')
                .attr('value', year.id)
                .attr('selected', true)
                .text(year.year);
                $("select[id=year-sel-" + id + "]")
                .append( newOption );
                document.getElementById("add-new-year-" + id).style.display="none";
                var e = document.getElementById("year-sel-" + id);
                e.style.display="block";
                DependentAttributeChanged(e, "year-sel-", id);
              },
              error: function (xhr){
              }
            });
          }

          function AddValue(id, attr){
            document.getElementById(attr+ "-sel-" + id).style.display="none";
            document.getElementById("add-new-" + attr + "-" + id).style.display="block";
            $("#new-" + attr + "-" + id).focus();
          }

          function ChangeMake(id, selected_id){
            console.log(id);
            document.getElementById("make-btn-" + id).style.display="none";
            $.ajax({
              url: "{{ route("equipment_table.makes") }}",
              method: 'get',
              data: {
                id: id,
                equipment_type_id: $("select[id=equipment-type-sel-" + id + "]").val(),
                _token: $("input[equipment_id=_token]").val()
              },
              context: document.body,
              success: function(makes){
                console.log(makes)
                $("select[id=make-sel-" + id + "]").empty();
                var newOption = $('<option></option>')
                  .attr('value', '')
                  .text("--");
                  $("select[id=make-sel-" + id + "]")
                     .append( newOption );
                for (var i=0; i<makes.length; i++) {
                   var newOption = $('<option></option>')
                     .attr('value', makes[i].id)
                     .text(makes[i].name);
                   $("select[id=make-sel-" + id + "]")
                     .append( newOption );
                }
                var newOption = $('<option></option>')
                  .attr('value', -1)
                  .text("Add Value");
                $("select[id=make-sel-" + id + "]")
                  .append( newOption );
                $("select[id=make-sel-" + id + "]").val(selected_id);
                document.getElementById("make-sel-" + id).style.display="block";
              },
              error: function(err){
                document.getElementById("make-btn-" + id).style.display="block";
              }
            });
          }

          function ChangeModel(id, selected_id){
            console.log(id);
            document.getElementById("model-btn-" + id).style.display="none";
            $.ajax({
              url: "{{ route("equipment_table.emodels") }}",
              method: 'get',
              data: {
                id: id,
                make_id: $("select[id=make-sel-" + id + "]").val(),
                _token: $("input[equipment_id=_token]").val()
              },
              context: document.body,
              success: function(models){
                $("select[id=model-sel-" + id + "]").empty();
                var newOption = $('<option></option>')
                  .attr('value', '')
                  .text("--");
                  $("select[id=model-sel-" + id + "]")
                     .append( newOption );
                for (var i=0; i<models.length; i++) {
                   var newOption = $('<option></option>')
                     .attr('value', models[i].id)
                     .text(models[i].name);
                   $("select[id=model-sel-" + id + "]")
                     .append( newOption );
                }
                var newOption = $('<option></option>')
                  .attr('value', -1)
                  .text("Add Value");
                $("select[id=model-sel-" + id + "]")
                  .append( newOption );
                $("select[id=model-sel-" + id + "]").val(selected_id);
                document.getElementById("model-sel-" + id).style.display="block";
              },
              error: function(err){
                document.getElementById("model-btn-" + id).style.display="block";
              }
            });
          }

          function ChangeYear(id, selected_id){
            console.log(id);

            document.getElementById("year-btn-" + id).style.display="none";
            $.ajax({
              url: "{{ route("equipment_table.years") }}",
              method: 'get',
              data: {
                id: id,
                emodel_id: $("select[id=model-sel-" + id + "]").val(),
                _token: $("input[equipment_id=_token]").val()
              },
              context: document.body,
              success: function(years){
                $("select[id=year-sel-" + id + "]").empty();
                var newOption = $('<option></option>')
                  .attr('value', '')
                  .text("--");
                  $("select[id=year-sel-" + id + "]")
                     .append( newOption );
                for (var i=0; i<years.length; i++) {
                   var newOption = $('<option></option>')
                     .attr('value', years[i].id)
                     .text(years[i].year);
                   $("select[id=year-sel-" + id + "]")
                     .append( newOption );
                }
                var newOption = $('<option></option>')
                  .attr('value', -1)
                  .text("Add Value");
                $("select[id=year-sel-" + id + "]")
                  .append( newOption );
                $("select[id=year-sel-" + id + "]").val(selected_id);
                document.getElementById("year-sel-" + id).style.display="block";
              },
              error: function(err){
                document.getElementById("year-btn-" + id).style.display="block";
              }
            });
          }


          function CheckAttribute(attr, id){
            var e = document.getElementById(attr + id);
            return e.getAttribute("set-value") == e.value;
          }

          function ShowingButtons(id){
            var rb = document.getElementById("reset-button-" + id);
            var sb = document.getElementById("save-button-" + id);
            if(!CheckAttribute("name-", id)
                || !CheckAttribute("unit-number-", id)
                || !CheckAttribute("meter-type-", id)
                || !CheckAttribute("equipment-type-sel-", id)
                || !CheckAttribute("make-sel-", id)
                || !CheckAttribute("model-sel-", id)
                || !CheckAttribute("year-sel-", id)
                || !CheckAttribute("fuel-type-", id)){
                  rb.style.display = "";
                  sb.style.display = "";
            }else{
              rb.style.display = "none";
              sb.style.display = "none";
            }
          }

          function AssignValue(attr, id, changed){
            var btn = document.getElementById(attr + "-btn-" + id);
            var sel = document.getElementById(attr + "-sel-" + id);
            var add = document.getElementById("add-new-" + attr+ "-" + id);
            if(changed){
              add.style.display = "none";
              sel.style.display = "none";
              sel.value=0;
              btn.style.display = "block";
              btn.innerHTML = "Unassigned";
            }else{
              btn.innerHTML = btn.getAttribute("set-value");
            }

          }

          function DependentAttributeChanged(e, attr, id){

            var changed = false;
            if(e.getAttribute("set-value") != e.value){
              e.style.backgroundColor = "yellow";
              changed = true;
            }else{
              e.style.backgroundColor = "";
            }
            console.log(attr);
            switch(attr){
              case "equipment-type-sel-":
                if(e.value==-1){
                  AddValue(id, "equipment-type");
                  // return;
                }
                AssignValue("make", id, changed);
                AssignValue("model", id, changed);
                AssignValue("year", id, changed);
                break;
              case "make-sel-":
                if(e.value==-1){
                  AddValue(id, "make");
                  // return;
                }
                AssignValue("model", id, changed);
                AssignValue("year", id, changed);
                break;
              case "model-sel-":
                if(e.value==-1){
                  AddValue(id, "model");
                  // return;
                }
                AssignValue("year", id, changed);
                break;
              case "year-sel-":
                if(e.value==-1){
                  AddValue(id, "year");
                  // return;
                }
            }
            ShowingButtons(id);
          }

          function AttributeChanged(e, attr, id){
            if(e.getAttribute("set-value") != e.value){
              e.style.backgroundColor = "yellow";
            }else{
              e.style.backgroundColor = "";
            }
            ShowingButtons(id);
          }

          function ResetAttribute(attr, id){
            var e = document.getElementById(attr + id);
            e.value = e.getAttribute("set-value");
            e.style.backgroundColor = "";
          }

          function ResetButton(attr, id){
            var btn = document.getElementById(attr + "-btn-" + id);
            var sel = document.getElementById(attr + "-sel-" + id);
            btn.innerHTML = btn.getAttribute("set-value");
            btn.style.display="block";
            var sel = document.getElementById(attr + "-sel-" + id);
            sel.style.backgroundColor = "";
            sel.style.display="none";
          }

          function ResetRow(id){
            ResetAttribute("name-", id);
            ResetAttribute("unit-number-", id);
            ResetAttribute("meter-type-", id);
            ResetAttribute("fuel-type-", id);
            ResetAttribute("equipment-type-sel-", id);
            ResetButton("make", id);
            ResetButton("model", id);
            ResetButton("year", id);
            ShowingButtons(id)
          }

          function UpdateAttribute(attr, id, value){
            var e = document.getElementById(attr + id);
            e.value = value;

            e.setAttribute("set-value", value);
            e.style.backgroundColor = "";
          }

          function SaveRow(id){

            console.log(document.getElementById("name-" + id).value);

            $.ajax({
		          url: "{{ route("equipment_table.table_update" ) }} ",
		          method: 'post',
		          data: {
                id: id,
                name: document.getElementById("name-" + id).value,
                unit_number: document.getElementById("unit-number-" + id).value,
                meter_type: document.getElementById("meter-type-" + id).value,
                equipment_type_id: document.getElementById("equipment-type-sel-" + id).value,
                make_id: document.getElementById("make-sel-" + id).value,
                emodel_id: document.getElementById("model-sel-" + id).value,
                year_id: document.getElementById("year-sel-" + id).value,
                fuel_type: document.getElementById("fuel-type-" + id).value,
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
								console.log("Success");
                UpdateAttribute("name-", id, document.getElementById("name-" + id).value);
                UpdateAttribute("unit-number-", id, document.getElementById("unit-number-" + id).value);
                UpdateAttribute("meter-type-", id, document.getElementById("meter-type-" + id).value);
                UpdateAttribute("equipment-type-sel-", id, document.getElementById("equipment-type-sel-" + id).value);
                UpdateAttribute("make-sel-", id, document.getElementById("make-sel-" + id).value);
                UpdateAttribute("model-sel-", id, document.getElementById("model-sel-" + id).value);
                UpdateAttribute("year-sel-", id, document.getElementById("year-sel-" + id).value);
                UpdateAttribute("fuel-type-", id, document.getElementById("fuel-type-" + id).value);

                ShowingButtons(id)
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
          }

          </script>

@endsection
