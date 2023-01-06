
<!DOCTYPE html>
<html lang="en">
  @include('layouts.partials.header')
  <body>
    <!-- navbar -->
    @include('layouts.partials.navbar')

    <!-- content -->

    <div class="container">
      <div class="row">
        <div class="col-md-6" id="edit-report-container">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Report</h3>
            </div>
            <div class="panel-body">
              <form action="{{ route("reports.fuel_group_users") }}" method="post" id='download-report-form'>
                {{ csrf_field() }}

                <input type="hidden" name="download" id="download" value="true">
                <input type="hidden" name="type" id="type" value="xls">
              <div class="form-group">
                <div class="col-md-11">
                 <select class='form-control' onchange="PickFilters()" id='selected-report'>
                   <option>Select A Report</option>
                   <optgroup label="Admin">
                     <option>Logins</option>
                   </optgroup>
                   <optgroup label="Equipment">
                     <option>Equipment</option>
                     <option>Equipment All</option>
                   </optgroup>
                   <optgroup label="Fuel Reports">
                     <option>Fuel Report</option>
                     <option>Fuel Groups-Users</option>
                     <option>Fuel Groups-Equipment</option>
                   </optgroup>
                   <optgroup label="Maintenance">
                     <option>Equipment Assignment</option>
                     <option>User Assignment</option>
                     <option>Adjusted Intervals</option>
                     <option>Intervals</option>
                     <option>Workorders By Equipment</option>
                     <option>Workorders By User</option>
                     <option>Workorders Labor By User</option>
                   </optgroup>
                   <optgroup label="Users">
                     <option>Users</option>
                   </optgroup>
                 </select>
               </div>
              </div>

              <div class="col-md-11">

                <a class="btn btn-default btn-block" onclick="GetReport()">
      		        <i class="glyphicon glyphicon-refresh"></i>
      		        Refresh
      		      </a>

                <div id="report-coming-soon-message" class="alert alert-warning" style="display:none">
                  Report Coming Soon!
                </div>
                <div id="select-a-report-message" class="alert alert-danger" style="display:none">
                  Select a Report
                </div>

  	  					<h3>Filters</h3>
                <div class="form-group" id="start-date-filter" style="display:none">
                  <div class="col-md-11">
                   <input class="form-control"name="start_date" type="date" id="start_date" value="{{ Carbon\Carbon::today()->toDateString() }}">
                   <p class="help-block">Start Date</p>
                 </div>
                </div>
                <div class="form-group" id="end-date-filter" style="display:none">
                  <div class="col-md-11">
                   <input class="form-control" name="end_date" type="date" id="end_date" value="{{ Carbon\Carbon::today()->toDateString() }}">
                   <p class="help-block">End Date</p>
                 </div>
                </div>
              </div>
              <div class="col-md-11">

                <div>
  				        <ul id="tree1">
  				                <li id="users-filter" style="display:none">
                              <input type="checkbox" onChange="ToggleUserCheckboxes(this.checked)" checked> Users
                              <ul>
                                <li>
                              	    <input type="checkbox" name="users[]" value="0" checked> Invalid User
                              	</li>
                                @foreach( Auth::user()->company()->first()->users()->orderBy("last_name")->orderBy("first_name")->get() as $user)
                                <li>
                              	    <input type="checkbox" name="users[]" value="{{ $user->id }}" checked> {{ $user->last_name }}, {{ $user->first_name }}
                              	</li>
                                @endforeach
                              </ul>
  				                </li>

                          <li id="stations-filter" style="display:none">
                              <input type="checkbox" onChange="ToggleStationCheckboxes(this.checked)" checked> Stations
                              <ul>
                                @foreach( Auth::user()->company()->first()->stations()->orderBy("name")->get() as $station)
                              	<li>
                              	    <input type="checkbox" name="stations[]" onChange="TogglePumpCheckboxes(this.checked, {{ $station->id }})" checked> {{ $station->name }}
                                    <ul>
                                      @foreach( $station->pumps()->orderBy("name")->get() as $pump)
                                    	<li>
                                    	    <input type="checkbox" name="pumps[]" value="{{ $pump->id }}" stationID="{{ $station->id }}" checked> {{ $pump->name }}
                                    	</li>
                                      @endforeach
                                    </ul>
                              	</li>
                                @endforeach
                              </ul>
  				                </li>
                          <li id="fuel-entries-filter" style="display:none">
                              <input type="checkbox" onChange="ToggleEntryCheckboxes(this.checked)"> Entries
                              <ul>
                                <li>
                              	    <input type="checkbox" name="entries[]" value="3500" > Approved
                                </li>
                                <li>
                                    <input type="checkbox" name="entries[]" value="3100" checked> User Finished
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3042" checked> Unauthorized For This Station
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3044" checked> Wrong Fuel Type
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3101" checked> Inactivity Time Reached
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3010" checked> Invalid User
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3062" > Text Message Failed to Send
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3102" checked> Approved Gallons Reached
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3012" checked> Unauthorized for this machine
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3507" checked> Station Powered Up
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3509" checked> Station Restarting
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3511" checked> Sync Started
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3510" checked> Sync Complete
                                  </li>
                                  <li>
                                    <input type="checkbox" name="entries[]" value="3020" checked> Invalid Machine
                              	</li>
                              </ul>
  				                </li>
                          <li id="equipment-filter-old" style="display:none">
                              <input type="checkbox" onChange="ToggleEquipmentCheckboxes(this.checked)" checked> Equipment
                              <ul>
                                <li>
                              	    <input type="checkbox" name="equipment_[]" value="0" checked> Invalid Equipment
                              	</li>
                                @foreach( Auth::user()->company()->first()->equipment()->orderBy("unit_number")->get() as $equipment)
                                <li>
                              	    <input type="checkbox" name="equipment_[]" value="{{ $equipment->id }}" checked> ({{ $equipment->unit_number }}) {{ $equipment->name }}
                              	</li>
                                @endforeach
                              </ul>
  				                </li>
                          <li id="equipment-filter" style="display:none">
                              <input type="checkbox" onChange="ToggleEquipmentTypeCheckboxes(this.checked)" checked> Equipment
                              <ul>
                                <li>
                              	    <input type="checkbox" name="equipment[]" value="0" checked> Invalid Equipment
                              	</li>
                                @foreach( Auth::user()->company()->first()->equipment_types()->orderBy("name")->get() as $equipment_types)
                                <li>
                            	    <input type="checkbox" parent="equipment_types[]" onChange="ToggleEquipmentTypeGroupCheckboxes(this.checked, {{ $equipment_types->id }})" name="equipment_types[]" value="{{ $equipment_types->id }}" checked> {{ $equipment_types->name }}
                                  <ul>
                                    @foreach($equipment_types->equipment()->orderBy('unit_number')->get() as $equipment)
                                    <li>
                                      <input type="checkbox" equipment_type="{{ $equipment_types->id }}[]" parent="equipment_types[]" name="equipment[]" value="{{ $equipment->id }}" checked> ({{ $equipment->unit_number }}) {{ $equipment->name }}
                                    </li>
                                    @endforeach
                                  </ul>
                              	</li>
                                @endforeach
                              </ul>
  				                </li>
  				        </ul>
                </div>
  	  				</div>
            </form>
            </div>

          </div>

        </div><!-- /.col-md-3 -->

        <div class="col-md-12">
          @if (session('message'))
            <div class='alert alert-success'>
              {{ session('message') }}
            </div>
          @endif
          @yield('content')

        </div>
      </div>
    </div>
    @section('form-script')
    <script>

    function ExcelReport(type){
      $("#type").val(type);
      $("#download-report-form").val(type);
      $('#download-report-form').submit();
    }
    function PrintReport(){
      $("#type").val('');
      $("#download").val(false);
      $('#download-report-form').submit();
    }

    function EditReport()
    {
      $("#edit-report-container").show(500);
    }

    function ToggleUserCheckboxes(value)
    {
      $("input[name='users[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }
    function ToggleEquipmentTypeCheckboxes(value)
    {
      $("input[parent='equipment_types[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }
    function ToggleEquipmentTypeGroupCheckboxes(value, id)
    {
      $("input[equipment_type='" + id + "[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }
    function ToggleEquipmentCheckboxes(value)
    {
      $("input[name='equipment[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }
    function ToggleStationCheckboxes(value)
    {
      $("input[name='pumps[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
      $("input[name='stations[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }
    function TogglePumpCheckboxes(value, station_id)
    {
      $("input[stationID='" + station_id + "']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }
    function ToggleEntriesCheckboxes(value)
    {
      $("input[name='entries[]']").each(function ()
      {
        $(this).prop('checked', value);
      });
    }

    function GetWorkorderByUserReport(){
      $("#report-container").hide(500);
      var users = [];
      $("input[name='users[]']:checked").each(function ()
      {
        users.push(parseInt($(this).val()));
      });
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.workorders_by_user") }} ",
        method: 'post',
        data: {
          name: "new_group",
          start_date: $("#start_date").val(),
              end_date: $("#end_date").val(),
              users: users,
              equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetWorkorderLaborByUserReport(){
      $("#report-container").hide(500);
      var users = [];
      $("input[name='users[]']:checked").each(function ()
      {
        users.push(parseInt($(this).val()));
      });
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.workorders_labor_by_user") }} ",
        method: 'post',
        data: {
          name: "new_group",
          start_date: $("#start_date").val(),
              end_date: $("#end_date").val(),
              users: users,
              equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetWorkorderByEquipmentReport(){
      $("#report-container").hide(500);
      var users = [];
      $("input[name='users[]']:checked").each(function ()
      {
        users.push(parseInt($(this).val()));
      });
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.workorders_by_equipment") }} ",
        method: 'post',
        data: {
          name: "new_group",
          start_date: $("#start_date").val(),
              end_date: $("#end_date").val(),
              users: users,
              equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetFuelReport(){
      $("#report-container").hide(500);
      var users = [];
      $("input[name='users[]']:checked").each(function ()
      {
        users.push(parseInt($(this).val()));
      });
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      var pumps = [];
      $("input[name='pumps[]']:checked").each(function ()
      {
        pumps.push(parseInt($(this).val()));
      });
      var entries = [];
      $("input[name='entries[]']:checked").each(function ()
      {
        entries.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.fuel_report") }} ",
        method: 'post',
        data: {
          name: "new_group",
          start_date: $("#start_date").val(),
              end_date: $("#end_date").val(),
              users: users,
              equipment: equipment,
              pumps: pumps,
              entries: entries,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }

    function GetFuelGroupUsersReport(){
      $("#report-container").hide(500);
      $.ajax({
        url: "{{ route("reports.fuel_group_users") }} ",
        method: 'post',
        data: {
          name: "new_group",
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }

    function GetFuelGroupEquipmentReport(){
      $("#report-container").hide(500);
      $.ajax({
        url: "{{ route("reports.fuel_group_equipment") }} ",
        method: 'post',
        data: {
          name: "new_group",
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetEquipmentReport(){
      $("#report-container").hide(500);
      $.ajax({
        url: "{{ route("reports.equipment") }} ",
        method: 'post',
        data: {
          name: "new_group",
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetEquipmentAllReport(){
      $("#report-container").hide(500);
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.equipment_all") }} ",
        method: 'post',
        data: {
          name: "new_group",
          equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetUsersReport(){
      $("#report-container").hide(500);
      $.ajax({
        url: "{{ route("reports.users") }} ",
        method: 'post',
        data: {
          name: "new_group",
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetIntervalsReport(){
      $("#report-container").hide(500);
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.intervals_all") }} ",
        method: 'post',
        data: {
          name: "new_group",
          equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetEquipmentAssignmentReport(){
      $("#report-container").hide(500);
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.equipment_assignment") }} ",
        method: 'post',
        data: {
          name: "new_group",
          equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetEquipmentAssignmentByUserReport(){
      $("#report-container").hide(500);
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.equipment_assignment_by_user") }} ",
        method: 'post',
        data: {
          name: "new_group",
          equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function GetAdjustedIntervalsReport(){
      $("#report-container").hide(500);
      var equipment = [];
      $("input[name='equipment[]']:checked").each(function ()
      {
        equipment.push(parseInt($(this).val()));
      });
      $.ajax({
        url: "{{ route("reports.adjusted_intervals") }} ",
        method: 'post',
        data: {
          name: "new_group",
          equipment: equipment,
          _token: $("input[name=_token]").val()
        },
        success: function (response){
          $('#report-table-container').html(response);
          $("#report-container").show(500);
          $("#edit-report-container").hide(500);
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }

    function GetReport(){
      $("#report-coming-soon-message").hide(500);
      $("#select-a-report-message").hide(500);


      var selected_report = $('#selected-report').find(":selected").text();
      $('#report-name').html(selected_report);
      switch (selected_report) {
        case "Fuel Report":
          GetFuelReport();
          $("#download-report-form").attr('action',"{{ route('reports.fuel_report')}}");
          break;
        case "Workorders By User":
          GetWorkorderByUserReport();
          $("#download-report-form").attr('action',"{{ route('reports.workorders_by_user')}}");
          break;
        case "Workorders Labor By User":
          GetWorkorderLaborByUserReport();
          $("#download-report-form").attr('action',"{{ route('reports.workorders_by_user')}}");
          break;
        case "Workorders By Equipment":
          GetWorkorderByEquipmentReport();
          $("#download-report-form").attr('action',"{{ route('reports.workorders_by_user')}}");
          break;
        case "Fuel Groups-Users":
            GetFuelGroupUsersReport();
            $("#download-report-form").attr('action',"{{ route('reports.fuel_group_users')}}");
            break;
        case "Fuel Groups-Equipment":
                GetFuelGroupEquipmentReport();
                $("#download-report-form").attr('action',"{{ route('reports.fuel_group_equipment')}}");
                break;
        case "Users":
                GetUsersReport();
                $("#download-report-form").attr('action',"{{ route('reports.users')}}");
                break;
        case "Equipment":
                GetEquipmentReport();
                $("#download-report-form").attr('action',"{{ route('reports.fuel_group_equipment')}}");
        break;
        case "Equipment All":
                GetEquipmentAllReport();
                $("#download-report-form").attr('action',"{{ route('reports.equipment_all')}}");
        break;
        case "Intervals":
                GetIntervalsReport();
                $("#download-report-form").attr('action',"{{ route('reports.users')}}");
        break;
        case "Adjusted Intervals":
                GetAdjustedIntervalsReport();
                $("#download-report-form").attr('action',"{{ route('reports.adjusted_intervals')}}");
        break;
        case "Equipment Assignment":
                GetEquipmentAssignmentReport();
                $("#download-report-form").attr('action',"{{ route('reports.adjusted_intervals')}}");
        break;
        case "User Assignment":
                GetEquipmentAssignmentByUserReport();
                $("#download-report-form").attr('action',"{{ route('reports.adjusted_intervals')}}");
        break;
        case "Select A Report":
            $("#select-a-report-message").show(500);
            break;
        default:
        $("#report-coming-soon-message").show(500);
      }
    }
    function PickFilters(){

      $("#start-date-filter").hide(500);
      $("#end-date-filter").hide(500);
      $("#users-filter").hide(500);
      $("#equipment-filter").hide(500);
      $("#stations-filter").hide(500);
      $("#fuel-entries-filter").hide(500);

      var selected_report = $('#selected-report').find(":selected").text();
      switch (selected_report) {
        case "Fuel Report":
          $("#users-filter").show(500);
          $("#equipment-filter").show(500);
          $("#start-date-filter").show(500);
          $("#end-date-filter").show(500);
          $("#stations-filter").show(500);
          $("#fuel-entries-filter").show(500);
          break;
        case "Workorders By User":
          $("#users-filter").show(500);
          $("#equipment-filter").show(500);
          $("#start-date-filter").show(500);
          $("#end-date-filter").show(500);
          break;
        case "Workorders By Equipment":
          $("#users-filter").show(500);
          $("#equipment-filter").show(500);
          $("#start-date-filter").show(500);
          $("#end-date-filter").show(500);
          break;
        case "Workorders Labor By User":
          $("#users-filter").show(500);
          $("#equipment-filter").show(500);
          $("#start-date-filter").show(500);
          $("#end-date-filter").show(500);
            break;
       case "Equipment All":
         $("#equipment-filter").show(500);
         break;
       case "Intervals":
         $("#equipment-filter").show(500);
         break;
       case "Adjusted Intervals":
         $("#equipment-filter").show(500);
         break;
       case "Equipment Assignment":
         $("#equipment-filter").show(500);
         break;

        case "Fuel Groups-Users":
          break;
        case "Fuel Groups-Equipment":
          break;
      }
    }
    </script>
    @endsection
    @include('layouts.partials.footer')
