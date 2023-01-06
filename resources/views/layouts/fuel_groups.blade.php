
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
          <div class="list-group">


            <h3>Fuel Groups</h3>
            <div style="display:none">
            <?php
              $selected_group = Request::get('group_id') ;
              $listGroups = listEquipmentGroups(Auth::user()->id);
            ?>

            @foreach (Auth::user()->company()->first()->fuel_groups()->get() as $group)
            <a href="{{ route('equipment.index', ['equipment_groups_id' => $group->id]) }}" class="list-group-item {{ $selected_group==$group->id ? 'active' : ''}}">{{ $group->name }}
              <div class="pull-right">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-success active">
                  <input type="radio" name="options" id="option1" autocomplete="off" checked> On
                </label>
                <label class="btn btn-default">
                  <input type="radio" name="options" id="option2" autocomplete="off"> Off
                </label>
              </div>
            </div><br><br>
            </a>
            @endforeach
            </div>
            <button class="btn btn-primary btn-block" id="edit-groups-btn" onclick="EditGroups()">Edit Groups</button>
          </div>
          <div class="panel panel-default" style="display:none">
            <div class="panel-heading">
              <h3 class="panel-title">Filters</h3>
            </div>
            <div class="panel-body">


            <ul id="tree1">
                    <li id="equipment-filter">
                        <input type="checkbox" onChange="ToggleEquipmentCheckboxes(this.checked)" checked> Equipment Types
                        <ul>
                          <li>
                              <input type="checkbox" name="equipment[]" value="0" checked> Invalid Equipment
                          </li>
                          @foreach( Auth::user()->company()->first()->equipment()->orderBy("unit_number")->get() as $equipment)
                          <li>
                              <input type="checkbox" name="equipment[]" value="{{ $equipment->id }}" checked> ({{ $equipment->unit_number }}) {{ $equipment->name }}
                          </li>
                          @endforeach
                        </ul>
                    </li>
              </ul>
            </div>
          </div>
          <div class="panel panel-default" id="edit-groups-container" style="display:none">
            <div class="panel-heading">
              <h3 class="panel-title">Edit</h3>
            </div>
            <div class="panel-body">

              <div id="fuel-groups-for-edit">
              @foreach (Auth::user()->company()->first()->fuel_groups()->get() as $group)
                @include('fuel_groups.partials.edit_group')
              @endforeach
              </div>

            <input type="text" id="edit-group-name" class="form-control" style="display:none">
            <button class="btn btn-primary btn-block" onclick="UpdateGroupName()" id="edit-group-save-btn" style="display:none">Save</button>
            <button class="btn btn-default btn-block" onclick="CancelGroupEdit()" id="edit-group-cancel-btn" style="display:none">Cancel</button>
            <button class="btn btn-danger btn-block"  onclick="DeleteGroup()"     id="edit-group-delete-btn" style="display:none">Delete</button>
            <button class="btn btn-primary btn-block" onclick="ShowAddGroup()"    id="edit-group-show-add-btn">Add New Group</button>
            <button class="btn btn-primary btn-block" onclick="AddGroup()"        id="edit-group-add-btn" style="display:none">Add</button>
            </div>
          </div>
          <div class='alert alert-success' id='edit-groups-message' style="display:none">
            Groups Updated. You will need to refresh the page to edit group assignments.
          </div>

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
    @include('layouts.partials.footer')
