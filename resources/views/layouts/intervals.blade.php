
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
          <h3>Interval Filters</h3>

          <div class="list-group">
            <!--
              <a href="{{ route('equipment.index') }}" class="list-group-item ">All Equipment<input class="pull-right" type="radio" name="equipment-in-view" onchange="update_page()" value="1"></a>
              <a href="{{ route('equipment.index') }}" class="list-group-item">My Equipment<input class="pull-right" type="radio" name="equipment-in-view" onchange="update_page()" value="-1"></a>
            -->
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
