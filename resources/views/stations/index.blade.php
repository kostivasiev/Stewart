@extends('layouts.stations')


@section('content')

				<div class="pull-right">
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
	<h1> List of Stations</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>All Stations</h4>
	    		</div>

	    		<div class="pull-right">

					<a href="{{ route("stations.create") }}" class="btn btn-success" style="display:none">
		              <i class="glyphicon glyphicon-plus"></i>
		              Add Station
		            </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($stations as $station)
	              <tr>
	                <td class="middle">
	                  <div class="media">
	                    <div class="media-left">
	                      <a href="#">
	                        <?php $photo = ! is_null($station->photo) ? $station->photo : 'default-station.png' ?>
	                        {!! Html::image('uploads/' . $photo, $station->name, ['class' => 'media-object', 'width'=>100, 'height'=>100]) !!}
	                      </a>
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">{{ $station->name }}</h4>
												{{ $station->mac_address }}
	                    </div>
	                  </div>
	                </td>
	                <td width="100" class="middle">
	                  <div>
	                    <a href="{{ route("stations.edit", ['id' => $station->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
	                      <i class="glyphicon glyphicon-edit"></i>
	                    </a>
	                  </div>
	                </td>
	              </tr>
              @endforeach
            </table>
          </div>

          <div class="text-center">
            <nav>
              {!! $stations->appends( Request::query() )->render() !!}
            </nav>
          </div>
@endsection
