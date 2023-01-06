
<!DOCTYPE html>
<html lang="en">
  @include('layouts.partials.header')
  <body>
    <!-- navbar -->
    @include('layouts.partials.navbar')

    <!-- content -->
    <div class="container">
      <div class="row">
        <div class="pull-right">
          <div class="col-md-12">
    			<form action="{{ route("equipment.index") }}" class="navbar-form navbar-right" role="search">
    	        <div class="input-group">
    	          <input type="text" name="term" value="{{ Request::get("term") }}" class="form-control" placeholder="Search...">
    	          <span class="input-group-btn">
    	            <button class="btn btn-default" type="submit">
    	              <i class="glyphicon glyphicon-search"></i>
    	            </button>
    	          </span>
    	        </div>
    	      </form>
      		</div>
        </div>
        <div class="col-md-3">
          <h3>Equipment Filters <input type="checkbox" onchange="toggle_filters(this.checked)" id='filters-checkbox' checked></h3>
          <div id='equipment-filters'>
          <div class="list-group">
            <a href="{{ route('equipment.index') }}" class="list-group-item ">All Equipment<input class="pull-right" type="radio" name="equipment-in-view" onchange="update_page()" value="1"></a>
            <a href="{{ route('equipment.index') }}" class="list-group-item">My Equipment<input class="pull-right" type="radio" name="equipment-in-view" onchange="update_page()" value="-1"></a>
          </div>
          <div class="list-group">


            <?php
              $selected_group = Request::get('group_id') ;
              $listGroups = listEquipmentGroups(Auth::user()->id);
            ?>

            <?php $group_array = explode(",", app('request')->input('group_id'));?>
            <?php $meter_array = explode(",", app('request')->input('meter_type'));?>
            @foreach ( $listGroups as $group)
            <a href="{{ route('equipment.index', ['equipment_groups_id' => $group->id]) }}" class="list-group-item" {{ in_array($group->id, $group_array) ? 'checked' : ''}}>{{ $group->name }}<input class="pull-right" type="checkbox" name="group" onchange="update_page()" value="{{ $group->id }}" {{ in_array($group->id, $group_array) ? 'checked' : ''}}></a>
            @endforeach

          </div>
          <div class="list-group">
            <a href="{{ route('equipment.index', ['fueler' => 1]) }}" class="list-group-item " {{ in_array(1, $meter_array) ? 'checked' : ''}}>Odometer<input class="pull-right" type="checkbox" name="fueler" onchange="update_page()" value="1" {{ in_array(1, $meter_array) ? 'checked' : ''}}></a>
            <a href="{{ route('equipment.index', ['fueler' => 0]) }}" class="list-group-item " {{ in_array(0, $meter_array) ? 'checked' : ''}}>Hour Meter<input class="pull-right" type="checkbox" name="fueler" onchange="update_page()" value="0" {{ in_array(0, $meter_array) ? 'checked' : ''}}></a>
            <a href="{{ route('equipment.index', ['fueler' => 2]) }}" class="list-group-item " {{ in_array(2, $meter_array) ? 'checked' : ''}}>No Meter<input class="pull-right" type="checkbox" name="fueler" onchange="update_page()" value="2" {{ in_array(2, $meter_array) ? 'checked' : ''}}></a>
            <a href="{{ route('equipment.index', ['fueler' => 3]) }}" class="list-group-item " {{ in_array(3, $meter_array) ? 'checked' : ''}}>Non Fueler<input class="pull-right" type="checkbox" name="fueler" onchange="update_page()" value="3" {{ in_array(3, $meter_array) ? 'checked' : ''}}></a>
          </div>

          </div>
        </div><!-- /.col-md-3 -->

        <script>

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
         document.getElementById('equipment-filters').style.display="none";
         document.getElementById('filters-checkbox').checked=false;
        }
        function toggle_filters(value){
          if(value){
            document.getElementById('equipment-filters').style.display="block";
          }else{
            document.getElementById('equipment-filters').style.display="none";
          }
        }
        </script>

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
    @include('layouts.partials.footer')
