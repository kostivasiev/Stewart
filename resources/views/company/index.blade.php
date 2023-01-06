@extends('layouts.company')


@section('content')

				<div class="pull-right">
	    			<form action="{{ route("company.index") }}" class="navbar-form navbar-right" role="search">
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
	<h1> List of Companies</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>All companies</h4>
	    		</div>

	    		<div class="pull-right">

					<a href="{{ route("company.create") }}" class="btn btn-success">
		              <i class="glyphicon glyphicon-plus"></i>
		              Add company
		            </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($companies as $company)
	              <tr>
	                <td class="middle">
	                  <div class="media">
	                    <div class="media-left">
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">{{ $company->name }}</h4>
	                      <address>
	                        <strong>{{ $company->email }}</strong><br>
	                        {{ $company->cell_number }}
	                      </address>
	                    </div>
	                  </div>
	                </td>
	                <td width="100" class="middle">
	                  <div>
	                  	{!! Form::open(['method' => 'DELETE', 'route' => ['company.destroy', $company->id]]) !!}
		                    <a href="{{ route("company.edit", ['id' => $company->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
		                      <i class="glyphicon glyphicon-edit"></i>
		                    </a>
		                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-circle btn-danger btn-xs" title="Edit">
		                      <i class="glyphicon glyphicon-remove"></i>
		                    </button>
		                {!! Form::close() !!}
	                  </div>
	                </td>
	              </tr>
              @endforeach
            </table>
          </div>

					@section('form-script')
					<script>
			      $(function() {
			        $("input[name=term]").autocomplete({
			          source: "{{ route("company.autocomplete") }}",
			          minLength: 3,
			          select: function(event, ui){
			            window.location.href = "company/" + ui.item.id + "/edit";
			            $(this).val(ui.item.value);
			          }
			        });
			      });
			    </script>
					@endsection
@endsection
