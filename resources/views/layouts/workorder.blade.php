
<!DOCTYPE html>
<html lang="en">
  @include('layouts.partials.header')
  <body>
    <!-- navbar -->
    @include('layouts.partials.navbar')

    <!-- content -->
    <div class="container">
      <div class="row">
        <div class="col-md-3">

          <h3>Work Order Filters <input type="checkbox" onchange="toggle_filters(this.checked)" id='filters-checkbox' checked></h3>
          <div id='workorder-filters'>
            <h3>Intervals</h3>
            <div class="list-group">

              <a href="{{ route('workorders.interval_view') }}" class="list-group-item">Total Intervals <span class="badge" id="interval-cnt" style="display:none"></span></a>
              <a href="{{ route('workorders.interval_view', ['interval_status' => 'okay']) }}" class="list-group-item">Okay Intervals <span class="badge" id="interval-okay" style="display:none"></span></a>
              <a href="{{ route('workorders.interval_view', ['interval_status' => 'upcoming']) }}" class="list-group-item">Upcoming Intervals <span class="badge" id="interval-upcoming" style="display:none"></span></a>
              <a href="{{ route('workorders.interval_view', ['interval_status' => 'current']) }}" class="list-group-item">Current Intervals <span class="badge" id="interval-current" style="display:none"></span></a>
              <a href="{{ route('workorders.interval_view', ['interval_status' => 'overdue']) }}" class="list-group-item">Overdue Intervals <span class="badge" id="interval-overdue" style="display:none"></span></a>

            </div>

            <h3>Type</h3>
            <div class="list-group">
            <?php
              $type_array = explode(",", app('request')->input('types'));?>
              <a class="list-group-item"><input type="checkbox" name="types[]" value="2" {{ in_array(2, $type_array) ? "checked" : ""}}> Complete <span class="badge">{{ Auth::user()->company()->first()->workorders()->where('status', 2)->count() }}</span></a>
              <a class="list-group-item"><input type="checkbox" name="types[]" value="1" {{ in_array(1, $type_array) ? "checked" : ""}}> Not Complete <span class="badge">{{ Auth::user()->company()->first()->workorders()->where('status', 1)->count() }}</span></a>
              <a class="list-group-item"><input type="checkbox" name="types[]" value="3" {{ in_array(3, $type_array) ? "checked" : ""}}> Void <span class="badge">{{ Auth::user()->company()->first()->workorders()->where('status', 3)->count() }}</span></a>
              <a href="{{ url('/workorders') }}" class="list-group-item">All <span class="badge">{{ Auth::user()->company()->first()->workorders()->count() }}</span></a>
            </div>

            <h3>Tags</h3>
            <div class="list-group">
            <?php
              $tag_array = explode(",", app('request')->input('tags'));?>
              @foreach (Auth::user()->company()->first()->tags()->orderBy('name')->get() as $tag)
                <a class="list-group-item"><input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $tag_array) ? "checked" : ""}}> {{ $tag->name }}</a>
              @endforeach
            </div>

            <h3>Assignment</h3>
            <div class="list-group">
            <?php
              $user_array = explode(",", app('request')->input('users'));?>
              @foreach (Auth::user()->company()->first()->mechanics()->orderBy('last_name')->get() as $user)
                <a class="list-group-item"><input type="checkbox" name="users[]" value="{{ $user->id }}" {{ in_array($user->id, $user_array) ? "checked" : ""}}> {{ $user->last_name }}, {{ $user->first_name }}</a>
              @endforeach
            </div>

            <h3>Equipment</h3>
            <div class="list-group">
              <input class="form-control" name="search" type="text" id="search" placeholder="Search">
              <select class="form-control" name="equipment_id" id="equipment_id" placeholder="Please select">
                <option value="0">Select Equipment</option>
                <?php $equipment_id = app('request')->input('equipment_id');?>
                @foreach (Auth::user()->company()->first()->equipment()->orderBy('name','asc')->get() as $piece)
                  <option value="{{ $piece->id }}"{{ !empty($equipment_id) ? $equipment_id==$piece->id ? "selected" : "" : '' }}>({{ $piece->unit_number }}) {{ $piece->name }}</option>
                @endforeach
              </select>

                <div id="searchable-equipment-container" style="display:none">
                  @foreach (Auth::user()->company()->first()->equipment()->orderBy('name','asc')->get() as $equipment_option)
                  <span name="MachineOptions" class="searchable-option" onclick="SelectEquipment({{ $equipment_option->id }})">({{ $equipment_option->unit_number }}) {{ $equipment_option->name }}</span>
                  @endforeach
              </div>
            </div>


            <button type="button" class="btn btn-primary btn-block" onclick="FilterByTags()">Filter</button>
          </div><!-- /.col-md-3 -->

        </div>
        <div class="col-md-9">
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

    $("#search").on('change keyup paste click', function() {
        SearchEquipment();
    });
    function toggle_filters(value){
      if(value){
        document.getElementById('workorder-filters').style.display="block";
      }else{
        document.getElementById('workorder-filters').style.display="none";
      }
    }
    function SearchEquipment()
    {
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
    }

    function FilterByTags(){
      var tags = "";
      var types = "";
      var users = "";
      $("input[name='tags[]']:checked").each( function () {
        // console.log($(this).val())
        tags = tags + $(this).val() + ",";
      });
      $("input[name='types[]']:checked").each( function () {
        // console.log($(this).val())
        types = types + $(this).val() + ",";
      });
      $("input[name='users[]']:checked").each( function () {
        // console.log($(this).val())
        users = users + $(this).val() + ",";
      });
      tags = tags.slice(0, -1);
      types = types.slice(0, -1);
      users = users.slice(0, -1);

      var url = "{{ url('/workorders') }}" + "?";
      var firstSet = false;
      if(tags != ""){
        url = url + "tags=" + tags;
        firstSet = true;
      }
      if(types != ""){
        if(firstSet){
          url = url + "&types=" + types;
        }else{
          url = url + "types=" + types;
        }
        firstSet = true;
      }
      if(users != ""){
        if(firstSet){
          url = url + "&users=" + users;
        }else{
          url = url + "users=" + users;
        }
        firstSet = true;
      }
      if($("#equipment_id").val() != 0){
        if(firstSet){
          url = url + "&equipment_id=" + $("#equipment_id").val();
        }else{
          url = url + "equipment_id=" + $("#equipment_id").val();
        }
      }
      window.location.href = url;

      console.log(url);
    }

    function SetSpanValue(id, value){
    	$(id).html(value);
    	$(id).show(500);
    }
    GetIntervalLegend();
      function GetIntervalLegend(){
        $.ajax({
          url: "{{ route("workorders.current_intervals") }}",
          method: 'get',
          data: {
            equipment_id: $("#equipment_id").val(),
            _token: $("input[equipment_id=_token]").val()
          },
          context: document.body,
          success: function(response){
    				console.log(response);
    				total = response.okay + response.upcoming + response.current + response.overdue;
            SetSpanValue('#interval-cnt', total);
    				SetSpanValue('#interval-okay', response.okay);
    				SetSpanValue('#interval-upcoming', response.upcoming);
    				SetSpanValue('#interval-current', response.current);
    				SetSpanValue('#interval-overdue', response.overdue);
          }
        });
      }
    </script>
    @endsection
    @include('layouts.partials.footer')
