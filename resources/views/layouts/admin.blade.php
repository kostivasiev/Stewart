
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
            <a href="{{ route('admin.index') }}" class="list-group-item active">Roles <span class="badge">3</span></a>
            <a href="{{ route('admintypes.index') }}" class="list-group-item">Type/Make/Model/Year <span class="badge">3</span></a>
            <a href="{{ route('adminparts.index') }}" class="list-group-item">Parts <span class="badge">3</span></a>
            <a href="{{ route('adminintervals.index') }}" class="list-group-item">Intervals <span class="badge">3</span></a>


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
