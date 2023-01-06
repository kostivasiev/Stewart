@extends('layouts.generic')


@section('content')

	<h1> List of Tags</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    		</div>

	    		<div class="pull-right">

					<a href="{{ route("tags.create") }}" class="btn btn-success">
		              <i class="glyphicon glyphicon-plus"></i>
		              Add Tag
		            </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($tags as $tag)
	              <tr>
	                <td class="middle">
	                  <div class="media">
	                    <div class="media-left">
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">{{ $tag->name }}</h4>
	                    </div>
	                  </div>
	                </td>
	                <td width="100" class="middle">
	                  <div>
	                  	{!! Form::open(['method' => 'DELETE', 'route' => ['tags.destroy', $tag->id]]) !!}
		                    <a href="{{ route("tags.edit", ['id' => $tag->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
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
              {!! $tags->appends( Request::query() )->render() !!}
            </nav>
          </div>
@endsection
