    <!-- navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand text-uppercase" href="{{ url('/') }}">
            Stewart Tech
          </a>
        </div>
        <!-- /.navbar-header -->
        <div class="collapse navbar-collapse" id="navbar-collapse">

          @if ( !Auth::guest())
            <ul class="nav navbar-nav">
              <li class="{{ Request::segment(1) == "home" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Dashboard") ? "block" : "none" }}"><a href="{{ url('/home') }}">Home</a></li>
              <li class="{{ Request::segment(1) == "admin" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("Super Admin") ? "none" : "none" }}"><a href="{{ url('/admin') }}">Admin</a></li>

              <li class="dropdown {{ Request::segment(1) == "equipment" ? "active" : "" }}"  style="display:{{ Auth::user()->hasRole("View Stations") ? "block" : "none" }}">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      Equipment <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu" role="menu">
                    <li class="{{ (Request::segment(1)=="equipment" && Request::segment(2)!="table") ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Equipment") ? "block" : "none" }}"><a href="{{ url('/equipment?size=10&equipment-in-view=1') }}">Equipment</a></li>
                    <li class="{{ (Request::segment(1)=="equipment" && Request::segment(2)=="table") ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Equipment") ? "block" : "none" }}"><a href="{{ url('/equipment/table') }}">Table</a></li>
                    <li class="{{ Request::segment(1)=="intervals" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Equipment") ? "block" : "none" }}"><a href="{{ url('/intervals') }}">Intervals</a></li>
                    <li class="{{ Request::segment(1)=="tags" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Equipment") ? "block" : "none" }}"><a href="{{ url('/tags') }}">Tags</a></li>
                  </ul>
              </li>

              <li class="{{ Request::segment(1) == "users" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Users") ? "block" : "none" }}"><a href="{{ url('/users') }}">Users</a></li>
              <li class="{{ Request::segment(1) == "workorders" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Workorders") ? "block" : "none" }}"><a href="{{ url('/workorders') }}">Work Orders</a></li>
              <li class="dropdown {{ Request::segment(1) == "stations" ? "active" : "" }}"  style="display:{{ Auth::user()->hasRole("View Stations") ? "block" : "none" }}">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      Fueling <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a href="{{ url('/fuel_groups') }}">Fuel Groups</a>
                    </li>
                    <li>
                      <a href="{{ url('/stations') }}">Stations</a>
                    </li>
                  </ul>
              </li>
              <li class="{{ Request::segment(1) == "map" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Map") ? "block" : "none" }}"><a href="{{ url('/map') }}">Map</a></li>
              <li class="{{ Request::segment(1) == "reports" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("View Reports") ? "block" : "none" }}"><a href="{{ url('/reports') }}">Reports</a></li>
              <li class="{{ Request::segment(1) == "company" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("Super Admin") ? "block" : "none" }}"><a href="{{ url('/company') }}">Companies</a></li>

            </ul>
          @endif

          <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            @if( Auth::user()->company()->first()->onTrial() )
                              @if( Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->company()->first()->trial_ends_at)) < 2)
                                <li><a>Trial (1 day left)</a></li>
                              @endif
                              <li><a>Trial ({{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->company()->first()->trial_ends_at))+1 }} days left)</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->company()->first()->name }} - {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                  @if(Auth::user()->hasRole("Super Admin"))

                                  <li class="{{ Request::segment(1) == "company" ? "active" : "" }}" class="col-md-4"><a onclick="StartChat()">Start Chatting</a></li>
                                    @foreach(App\Company::orderBy('name')->get() as $company)
                                      <li>
                                          <a onclick="ChangeCompany({{ $company->id}})">
                                              {{ $company->name }}
                                          </a>
                                      </li>
                                    @endforeach
                                    <li role="separator" class="divider"></li>
                                  @endif
                                  <li class="{{ Request::segment(1) == "company" ? "active" : "" }}" class="col-md-4" style="display:none"><a href="{{ url('/forums') }}">Store</a></li>
                                  <li class="{{ Request::segment(1) == "company" ? "active" : "" }}" class="col-md-4" style="display:none"><a href="{{ url('/forums') }}">Tutorials</a></li>
                                  <li class="{{ Request::segment(1) == "company" ? "active" : "" }}" class="col-md-4" style="display:none"><a href="{{ url('/forums') }}">Forum</a></li>
                                  <li class="{{ Request::segment(1) == "company" ? "active" : "" }}" class="col-md-4" ><a href="{{ route("company_profile.edit", ['id' => Auth::user()->company->first()->id]) }}">Company Profile</a></li>
                                  <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    </ul>
        </div>
      </div>
    </nav>
