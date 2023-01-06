
<!DOCTYPE html>
<html lang="en">
  <!-- include('layouts.partials.header') -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/jasny-bootstrap.min.css" rel="stylesheet">
  @yield('css')
  <body>
    <!-- navbar -->

    <!-- <nav class="navbar navbar-default navbar-fixed-top">
      <div class="list-group">
         <a href="" class="list-group-item">Last Updated <span class="badge" id="clock-since-update"></span></a>
         <a href="" class="list-group-item">Next Update <span class="badge" id="clock-till-update"></span></a>
      </div>
    </nav> -->
    <!-- <div class="list-group">
       <a href="" class="list-group-item">Last Updated <span class="badge" id="clock-since-update"></span></a>
       <a href="" class="list-group-item">Next Update <span class="badge" id="clock-till-update"></span></a>
    </div> -->



    <!-- content -->
    <div class="map-container">
      <div class="row">

        <div class="container-fluid" align="center">
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
