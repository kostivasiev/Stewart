@extends('layouts.admin')

@section('content')


	<h1> List of Users Admin</h1>
	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>All Users</h4>
	    		</div>
	    	</div>
            <table class="table">
							<tr>
								<th>User</th>
								<th>Super Admin</th>
								<th>Admin</th>
								<th>Mechanic</th>
							</tr>
            	@foreach ($users as $user)
	              <tr>
	                <td>
	                    <h4>{{ $user->last_name }}, {{ $user->first_name }}</h4>
	                </td>
	                <td>
	                  <input type="checkbox" {{ $user->hasRole('Super Admin') ? 'checked' : '' }}>
	                </td>
	                <td>
	                  <input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : '' }}>
	                </td>
	                <td>
	                  <input type="checkbox" {{ $user->hasRole('Mechanic') ? 'checked' : '' }}>
	                </td>
	              </tr>
              @endforeach
            </table>
          </div>

          <div class="text-center">
            <nav>
              {!! $users->appends( Request::query() )->render() !!}
            </nav>
          </div>
@endsection
