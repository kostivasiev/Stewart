@extends('layouts.intervals')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading clearfix">
              <strong>Intervals Table</strong>

            <div class="pull-right">

  					<a href="{{ route("intervals.create") }}" class="btn btn-success">
  		              <i class="glyphicon glyphicon-plus"></i>
  		              Add Interval
  		            </a>
  	    		</div>
            </div>
            <div class="form-group" id="setup-alerts-fields">
              <div class="panel-body">
                <table style="border:1" class="table table-striped table-hover table-bordered">
                  <tr>
                    <th>Interval ID</th>
                    <th>Name</th>
                    <th>Assignment</th>
                    <th>Edit</th>
                  </tr>
                  @foreach( $intervals as $interval)
                  <tr class="showhims">
                    <td>
                      {{ Auth::user()->company()->first()->id }}-{{ $interval->id }}
                    </td>
                    <td>
                      {{ $interval->name }}
                    </td>
                    <td class="tip">
                      Equipment Types
                          <span>
                            <b>Equipment Types</b><br>
                            @foreach ($interval->equipment_types()->pluck('name') as $name)
                              {{ $name }}<br>
                            @endforeach
                            <b>Makes</b><br>
                            @foreach ($interval->makes()->pluck('name') as $name)
                              {{ $name }}<br>
                            @endforeach
                            <b>Models</b><br>
                            @foreach ($interval->models()->pluck('name') as $name)
                              {{ $name }}<br>
                            @endforeach
                          </span>

                    </td>
                    <td>
                      {!! Form::open(['method' => 'DELETE', 'route' => ['intervals.destroy', $interval->id]]) !!}
		                    <a href="{{ route("intervals.edit", ['id' => $interval->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
		                      <i class="glyphicon glyphicon-edit"></i>
		                    </a>
		                {!! Form::close() !!}
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>

            </div>
          </div>

          <script>

          function ShowTree(id){
            document.getElementById("tree-"+id).style.display="block";
            // document.getElementById("tree-"+id).treed();
          }
          </script>

@endsection
