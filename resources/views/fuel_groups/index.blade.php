@extends('layouts.fuel_groups')


@section('content')


	<h1>Fuel Group Assignments</h1>
		<div id="fuel-group-assignments-container">
	    <div class="panel panel-default" style="display:block">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>Equipment</h4>
	    		</div>
          <div class="pull-right">
            <a class="btn btn-default" id='hide-equipment-btn'>
              <i class="glyphicon glyphicon-eye-open"></i>
              <span id="equipment-btn-text">Hide</span>
            </a>
	    		</div>
	    	</div>
            <table class="table" id='equipment-container'>
              <tr>
                <thead>
                <th>Equipment</th>
                @foreach (Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
                	<th>{{ $group->name }}</th>
                @endforeach
                </thead>
              </tr>
            	@foreach (Auth::user()->company()->first()->equipment()->orderBy('unit_number')->get() as $equipment)
	              <tr>
	                <td>
										<font id="equipment-name-fuel-group-{{ $equipment->id }}">
	                  	({{ $equipment->unit_number }}) {{ $equipment->name }}
										</font>
	                </td>
									<?php
										$groups = $equipment->fuel_groups()->get();
									?>
                  @foreach (Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
										<?php
											$checked = $groups->contains($group);
										?>
                  <th><input type="checkbox" onchange="UpdateEquipment({{ $equipment->id }}, {{ $group->id }}, this.checked)" {{ $checked ? "checked" : "" }}></th>
                  @endforeach
	              </tr>
              @endforeach
            </table>
          </div>
          <div class="panel panel-default">
    	    	<div class="panel-heading clearfix">
    	    		<div class="pull-left">
    	    			<h4>Stations</h4>
    	    		</div>
              <div class="pull-right">
                <a class="btn btn-default" id='hide-stations-btn'>
                  <i class="glyphicon glyphicon-eye-open"></i>
                  <span id="stations-btn-text">Hide</span>
                </a>
    	    		</div>
    	    	</div>
                <table class="table" id='stations-container'>
                  <tr>
                    <thead>
                    <th>Station</th>
                    @foreach (Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
                    <th>{{ $group->name }}</th>
                    @endforeach
                    </thead>
                  </tr>
                	@foreach (Auth::user()->company()->first()->stations()->orderBy('name')->get() as $station)
                    @foreach ($station->pumps()->orderBy('name')->get() as $pump)
      	              <tr>
      	                <td>
													<font id="fuel-station-name-fuel-group-{{ $pump->id }}">
      	                  	{{ $station->name }} - {{ $pump->name }}
													</font>
      	                </td>
                        @foreach (Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
                        <th><input type="checkbox" onchange="UpdateStation({{ $pump->id }}, {{ $group->id }}, this.checked)" {{ $group->fuel_pump->contains($pump->id) ? "checked" : "" }}></th>
                        @endforeach
      	              </tr>
                      @endforeach
                  @endforeach
                </table>
              </div>
              <div class="panel panel-default">
        	    	<div class="panel-heading clearfix">
        	    		<div class="pull-left">
        	    			<h4>Users</h4>
        	    		</div>
                  <div class="pull-right">
                    <a class="btn btn-default" id='hide-users-btn'>
                      <i class="glyphicon glyphicon-eye-open"></i>
                      <span id="users-btn-text">Hide</span>
                    </a>
        	    		</div>
        	    	</div>
                    <table class="table" id='users-container'>
                      <tr>
                        <thead>
                        <th>User</th>
                        @foreach (Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
                        	<th>{{ $group->name }}</th>
                        @endforeach
												<th>Non Fueler</th>
                        </thead>
                      </tr>
                      <tbody>
                    	@foreach (Auth::user()->company()->first()->users()->orderBy('last_name')->orderBy('first_name')->get() as $user)
        	              <tr>
        	                <td>
														<font id="user-name-fuel-group-{{ $user->id }}">
        	                  	{{ $user->last_name }}, {{ $user->first_name }}
														</font>
        	                </td>
                          @foreach (Auth::user()->company()->first()->fuel_groups()->orderBy('name')->get() as $group)
          	                <td>
                              <input type="radio" name="group-id-{{ $user->id }}" onchange="UpdateUserFuelGroup({{$user->id}}, {{ $group->id }})" {{ $user->fuel_group_id == $group->id ? "checked" : "" }}>
          	                </td>
                          @endforeach
													<td>
														<input type="radio" name="group-id-{{ $user->id }}" onchange="UpdateUserFuelGroup({{$user->id}}, 0)" {{ $user->fuel_group_id == 0 ? "checked" : "" }}>
													</td>
        	              </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
								</div>

          <div class="text-center">
            <nav>
              {!! $pieces->appends( Request::query() )->render() !!}
            </nav>
          </div>

          @section('form-script')
          <script>

					function UpdateEquipment(equipment_id, group_id, checked){
						$("#equipment-name-fuel-group-" + equipment_id).attr('color', 'red');
						console.log ( "equipment_id: " + equipment_id + " group_id: " + group_id + " checked:" + checked);
						$.ajax({
		          url: "{{ route("fuel_groups.update_equipment_assignment" ) }} ",
		          method: 'post',
		          data: {
			          equipment_id: equipment_id,
			          group_id: group_id,
			          checked: checked,
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
									$("#equipment-name-fuel-group-" + equipment_id).attr('color', 'green');
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

					function UpdateStation(pump_id, group_id, checked){
						$("#fuel-station-name-fuel-group-" + pump_id).attr('color', 'red');
						console.log ( "pump_id: " + pump_id + " group_id: " + group_id + " checked:" + checked);
						$.ajax({
		          url: "{{ route("fuel_groups.update_station_assignment" ) }} ",
		          method: 'post',
		          data: {
			          pump_id: pump_id,
			          group_id: group_id,
			          checked: checked,
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
									$("#fuel-station-name-fuel-group-" + pump_id).attr('color', 'green');
		          },
		          error: function (xhr){
								console.log(xhr);
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

					function UpdateUserFuelGroup(user_id, group_id){
						// #800517
						$("#user-name-fuel-group-" + user_id).attr('color', 'red');
						console.log ( "user_id: " + user_id + " group_id: " + group_id);
						$.ajax({
		          url: "{{ route("fuel_groups.update_user_assignment" ) }} ",
		          method: 'post',
		          data: {
			          user_id: user_id,
			          group_id: group_id,
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
								$("#user-name-fuel-group-" + user_id).attr('color', 'green');
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

					function EditGroups(){
						$("#edit-groups-container").toggle(500);
            $("#edit-groups-btn").text($("#edit-groups-btn").text() == 'Edit Groups' ? 'Done Editing' : 'Edit Groups' );
					}

					var fuel_group_id=-1;

					function ShowAddGroup(){
						$("#edit-group-save-btn").hide(500);
						$("#edit-group-cancel-btn").show(500);
						$("#edit-group-delete-btn").hide(500);
						$("#edit-group-add-btn").show(500);
						$("#edit-group-show-add-btn").hide(500);
						$("#edit-group-name").show(500);
						$("#edit-group-name").val('');
					}

		      function EditGroup(id,name){
						$("#edit-group-save-btn").show(500);
						$("#edit-group-cancel-btn").show(500);
						$("#edit-group-delete-btn").show(500);
						$("#edit-group-add-btn").hide(500);
						$("#edit-group-show-add-btn").hide(500);
						$("#edit-group-name").show(500);

		        $("#edit-group-name").val(name);
						fuel_group_id = id;
		      }

					function CancelGroupEdit(){
						$("#edit-group-save-btn").hide(500);
						$("#edit-group-cancel-btn").hide(500);
						$("#edit-group-delete-btn").hide(500);
						$("#edit-group-add-btn").hide(500);
						$("#edit-group-show-add-btn").show(500);
						$("#edit-group-name").hide(500);
					}

					function UpdateGroupName(){
						$.ajax({
		          url: "{{ route("fuel_groups.ajax_update" ) }} ",
		          method: 'post',
		          data: {
		            name: $("#edit-group-name").val(),
			          id: fuel_group_id,
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
								$("#edit-group-text-" + fuel_group_id).text(group.name);
								CancelGroupEdit();
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
					function AddGroup(){
						$.ajax({
		          url: "{{ route("fuel_groups.store" ) }} ",
		          method: 'post',
		          data: {
		            name: $("#edit-group-name").val(),
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
								console.log(group);
								$("#fuel-groups-for-edit").append(group);
								CancelGroupEdit();
								$("#edit-groups-message").show(500);
								$("#fuel-group-assignments-container").hide(500);
								// $("#edit-group-text-" + fuel_group_id).text(group.name);
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
					function DeleteGroup(){
						$.ajax({
		          url: "{{ route("fuel_groups.ajax_destroy" ) }} ",
		          method: 'post',
		          data: {
		            id: fuel_group_id,
		            _token: $("input[name=_token]").val()
		          },
		          success: function (group){
								console.log(group);
								$("#edit-group-container-" + fuel_group_id).hide(500);
								CancelGroupEdit();
								$("#edit-groups-message").show(500);
								$("#fuel-group-assignments-container").hide(500);
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

          $('#hide-equipment-btn').click(function () {
            $("#equipment-container").toggle(500);
            $("#equipment-btn-text").text($("#equipment-btn-text").text() == 'View' ? 'Hide' : 'View' );
          });
          $('#hide-stations-btn').click(function () {
            $("#stations-container").toggle(500);
            $("#stations-btn-text").text($("#stations-btn-text").text() == 'View' ? 'Hide' : 'View' );
          });
          $('#hide-users-btn').click(function () {
            $("#users-container").toggle(500);
            $("#users-btn-text").text($("#users-btn-text").text() == 'View' ? 'Hide' : 'View' );
          });
          </script>
          @endsection

@endsection
