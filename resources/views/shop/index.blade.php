@extends('layouts.shop')


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
	<h1> List of Products</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>All Products and Services</h4>
	    		</div>


	    	</div>
            <table class="table">
            	@foreach ($pieces as $equipment)
	              <tr>
	                <td>
	                  <div class="media">
	                    <div class="media-left">
	                      <a href="#">
	                        <?php $photo = ! is_null($equipment->photo) ? $equipment->photo : 'default.png' ?>
	                        {!! Html::image('uploads/' . $photo, $equipment->name, ['class' => 'media-object', 'width'=>100, 'height'=>100]) !!}
	                      </a>
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">Fuel System</h4>
	                        Price: <strong>$500.00</strong><br>
	                        Qty: <span>1</span>
													<a href="{{ route("equipment.edit", ['id' => $equipment->id]) }}" class="btn btn-default btn-xs" title="Edit">
			                      <i class="glyphicon glyphicon-minus"></i>
			                    </a>
													<a href="{{ route("equipment.edit", ['id' => $equipment->id]) }}" class="btn btn-default btn-xs" title="Edit">
			                      <i class="glyphicon glyphicon-plus"></i>
			                    </a>
	                    </div>
	                  </div>
	                </td>
									<td>
										<div class="media">
	                    <div class="media-body">
	                      <h5 class="media-heading">Description</h5>
	                        This product comes with a two year warrenty. It allows you to better Controller
													your fuel consumption on your farm or dairy. A single fuel system comes with control of a single pump.
													To add control for another pump, add it as an addon item.
	                    </div>
	                  </div>
									</td>
	                <td width="100" class="middle">
	                  <div>
	                  	{!! Form::open(['method' => 'DELETE', 'route' => ['equipment.destroy', $equipment->id]]) !!}
		                    <a href="{{ route("equipment.edit", ['id' => $equipment->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
		                      <i class="glyphicon glyphicon-plus"></i>
		                    </a>
		                {!! Form::close() !!}
	                  </div>
	                </td>
	              </tr>
              @endforeach
            </table>
          </div>



@endsection
