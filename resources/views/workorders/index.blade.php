@extends('layouts.workorder')


@section('content')

				<div class="pull-right" style="display:none">
	    			<form action="{{ route("equipment.index") }}" class="navbar-form navbar-right" role="search">
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
	<h1> List of Work Orders</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>Work Orders</h4>
	    		</div>

	    		<div class="pull-right">

					<a href="{{ route("workorders.create") }}" class="btn btn-success">
		              <i class="glyphicon glyphicon-plus"></i>
		              Add Work Order
		            </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($workorders as $workorder)
	              <tr>
	                <td class="middle">
	                  <div class="media">
	                    <div class="media-left">
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">({{ $workorder->equipment->unit_number }}) {{ $workorder->equipment->name }}</h4>
												<h4 class="media-heading">{{ $workorder->status==1 ? "Not Complete" : ($workorder->status==2 ? "Complete" : "Void") }}</h4>
												@if(!empty($workorder->wologs()->orderBy('created_at', 'desc')->first()))
												<strong>
												@if(!empty($workorder->user))
												Assignment: {{ $workorder->user->first_name }} {{ $workorder->user->last_name }}<br>
												@endif
												@if($workorder->due_date!=0)
												Due: {{ date('m/d/y', strtotime($workorder->due_date)) }}<br>
												@endif
													Last Updated: {{ $workorder->wologs()->orderBy('created_at', 'desc')->first()->user()->first()->first_name }} {{ $workorder->wologs()->orderBy('created_at', 'desc')->first()->user()->first()->last_name }}<br>
													<u>Labor</u><br>
													@foreach ($workorder->labor()->get() as $labor)
															{{ $labor->last_name }}, {{ $labor->first_name }}<br>
													@endforeach
												</strong>

													WO No.: {{ $workorder->id }}<br>
													Time
													:
													{{ $workorder->wologs()->orderBy('created_at', 'desc')->first()->created_at->format('m/d/y h:i') }}
	                        <p class="help-block">{{ $workorder->wologs()->orderBy('created_at', 'desc')->first()->notes }}</p>
													@endif
											</div>
											<div class="media-right">
												@foreach($workorder->tags as $tag)
												<span class="badge primary">{{ $tag->name }}</span>
												@endforeach
	                    </div>
	                  </div>
	                </td>
	                <td width="100" class="middle">
	                  <div>
	                  	{!! Form::open(['method' => 'DELETE', 'route' => ['equipment.destroy', $workorder->id]]) !!}
												<?php 
													$get_params = ['id' => $workorder->id];
													// $tag_array = explode(",", app('request')->input('tags'));
													// echo "tags: " . app('request')->input('tags');
													$get_params['types'] = app('request')->get('types');
													$get_params['tags'] = app('request')->get('tags');
													$get_params['users'] = app('request')->get('users');
													$get_params['equipment_id'] = app('request')->get('equipment_id');
													// $get_params['tags'] = str_replace('%2C', ',', $get_params['tags']);
													// echo "tags: " . $get_params['tags'];
													// die();
													 ?>
		                    <a href="{{ route("workorders.edit", $get_params) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
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
              {!! $workorders->appends( Request::query() )->render() !!}
            </nav>
          </div>
@endsection
