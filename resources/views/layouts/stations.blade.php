
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
          <div class="list-group" style="display:none">

            <h3>Station Types</h3>
            <?php
              $selected_group = Request::get('group_id') ;
              $listGroups = listEquipmentGroups(Auth::user()->id);
            ?>
            <a href="{{ route('equipment.index') }}" class="list-group-item {{ empty($selected_group) ? 'active' : ''}}">All Equipment <span class="badge">{{ collect($listGroups)->sum('total') }}</span></a>

            @foreach ( $listGroups as $group)
            <a href="{{ route('equipment.index', ['equipment_groups_id' => $group->id]) }}" class="list-group-item {{ $selected_group==$group->id ? 'active' : ''}}">{{ $group->name }} <span class="badge">{{ $group->total }}</span></a>
            @endforeach

          </div>

          <div class="list-group" >

            <h3>Gallons Calculator</h3>
            <span class="list-group-item"> <input type="number" class="form-control" id="diameter"><label for="diameter" class="control-label">Diameter</label></span>
            <span class="list-group-item"> <input type="number" class="form-control" id="depth"><label for="depth" class="control-label">Depth</label></span>
            <span class="list-group-item"> <input type="number" class="form-control" id="length"><label for="length" class="control-label">Length</label></span>
            <span class="list-group-item"> <input type="number" class="form-control" id="temperature" value="60"><label for="temperature" class="control-label">Temperature</label></span>
            <span class="list-group-item"> <span  id="gallons"></span><br><label for="gallons" class="control-label">Measured Gallons</label></span>
            <span class="list-group-item"> <span  id="gallons-at-60-degrees"></span><br><label for="gallons-at-60-degrees" class="control-label">Gallons at 60 Degrees</label></span>
            <span class="list-group-item"> <span  id="difference"></span><br><label for="difference" class="control-label">Difference</label></span>
          </div>

          <button type="button" class="btn btn-block btn-primary" onclick="Calculate()">Calculate</button>
        </div><!-- /.col-md-3 -->


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

    <script>
    /*
    * Gallons based on temperature calculation based on
    * research from the following website.
    *
    * https://desertfuels.com/industry-education/gross-vs-net-when-is-a-gallon-not-a-gallon/
    */
      function Calculate(){
        var l = $("#length").val();
        var d = $("#depth").val();
        var r = $("#diameter").val()/2;
        var t = $("#temperature").val();

        var v = l * ( Math.pow(r,2)*Math.acos((r-d)/r) - (r-d) * Math.sqrt(2*r*d-Math.pow(d,2)));
        var g = Math.round(v*0.004329);
        $("#gallons").html(g);
        var g_t = Math.round(g - (t-60) * (0.007/10) * g);
        $("#gallons-at-60-degrees").html(g_t);
        $("#difference").html(g_t - g);
      }
    </script>
    @include('layouts.partials.footer')
