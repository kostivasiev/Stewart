
<!DOCTYPE html>
<html lang="en">
  @include('layouts.partials.header')
  <body>
    <!-- navbar -->
    @include('layouts.partials.navbar')

    <!-- content -->
    <div class="container">

      <div class="row">
        <div class="alert alert-warning" role="alert">This page is under construction. You are currently viewing what will be available on this page. <br><br>
          <i>Here at Stewart Tech, we are constantly working to improve our system to make it work better for you. Please submit your suggestions to your Stewart Tec Representative.</i>

        </div>
        <div class="col-md-3">
          <div class="list-group">
            <h3>Categories</h3>
            <?php
              $selected_group = Request::get('group_id') ;
              $listGroups = listEquipmentGroups(Auth::user()->id);
            ?>
            @foreach (Auth::user()->company()->first()->fuel_groups()->get() as $group)
            <a href="{{ route('equipment.index', ['equipment_groups_id' => $group->id]) }}" class="list-group-item {{ $selected_group==$group->id ? 'active' : ''}}">{{ $group->name }}
            </a>
            @endforeach
            <a href="" class="list-group-item ">Services - {{ $name }}
            </a>
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
