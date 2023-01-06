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

            <h3>Hardware Pricing</h3>
            <a class="list-group-item">Fuel Box<span class="badge">$3000</span></a>
            <a class="list-group-item">Additional Pump<span class="badge">$500</span></a>
            <a class="list-group-item">Flow Meter<span class="badge">$750</span></a>

            <h3>Software Pricing/month</h3>
            <a class="list-group-item">Fuel Box Connect<span class="badge">$10</span></a>
            <a class="list-group-item">Additional Pump Connect<span class="badge">$15</span></a>
            <a class="list-group-item">Maintenance (50 machines)<span class="badge">$10</span></a>

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
