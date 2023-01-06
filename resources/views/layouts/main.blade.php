
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

            
            <h3>Login Accounts</h3>
            <?php 
              $selected_group = Request::get('group_id') ;
              $listGroups = listGroups(Auth::user()->id);
            ?>
            <a href="{{ route('contacts.index') }}" class="list-group-item {{ empty($selected_group) ? 'active' : ''}}">Accounts <span class="badge">{{ collect($listGroups)->sum('total') }}</span></a>

            @foreach ( $listGroups as $group)
            <a href="{{ route('contacts.index', ['group_id' => $group->id]) }}" class="list-group-item {{ $selected_group==$group->id ? 'active' : ''}}">{{ $group->name }} access <span class="badge">{{ $group->total }}</span></a>
            @endforeach

            <h3>Fuel Groups</h3>
            <?php 
              $selected_group = Request::get('group_id') ;
              $listGroups = listGroups(Auth::user()->id);
            ?>
            <a href="{{ route('contacts.index') }}" class="list-group-item {{ empty($selected_group) ? 'active' : ''}}">All Contact <span class="badge">{{ collect($listGroups)->sum('total') }}</span></a>

            @foreach ( $listGroups as $group)
            <a href="{{ route('contacts.index', ['group_id' => $group->id]) }}" class="list-group-item {{ $selected_group==$group->id ? 'active' : ''}}">{{ $group->name }} access <span class="badge">{{ $group->total }}</span></a>
            @endforeach
          </div>
          
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
    @include('layouts.partials.footer')
