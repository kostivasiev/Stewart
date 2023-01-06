@extends('layouts.users')


@section('content')

				<div class="pull-right">
	    			<form action="{{ route("users.index") }}" class="navbar-form navbar-right" role="search">
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
	<h1> List of Users</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>All users</h4>
	    		</div>

	    		<div class="pull-right">

					<a href="{{ route("users.create") }}" class="btn btn-success">
		              <i class="glyphicon glyphicon-plus"></i>
		              Add users
		            </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($users as $user)
	              <tr>
	                <td class="middle">
	                  <div class="media">
	                    <div class="media-left">
	                      <a href="#">
	                        <?php $photo = ! is_null($user->photo) ? $user->photo : 'default-user.png' ?>
	                        {!! Html::image('uploads/' . $photo, $user->first_name, ['class' => 'media-object', 'max-width'=>100, 'height'=>100]) !!}
	                      </a>
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">{{ $user->last_name }}, {{ $user->first_name }}</h4>
	                      <address>
	                        <strong>{{ $user->email }}</strong><br>
													{{ starts_with($user->cell_number, "**") ? "" : $user->cell_number }}
	                      </address>
	                    </div>
	                  </div>
	                </td>
	                <td width="100" class="middle">
	                  <div>
	                  	{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
		                    <a href="{{ route("users.edit", ['id' => $user->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
		                      <i class="glyphicon glyphicon-edit"></i>
		                    </a>
		                {!! Form::close() !!}
	                  </div>
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

					@section('form-script')
					<script>
			      $(function() {
			        $("input[name=term]").autocomplete({
			          source: "{{ route("users.autocomplete") }}",
			          minLength: 3,
			          select: function(event, ui){
			            window.location.href = "users/" + ui.item.id + "/edit";
			            $(this).val(ui.item.value);
			          }
			        });
			      });
			    </script>
					@endsection
@endsection
