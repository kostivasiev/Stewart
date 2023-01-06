@extends('layouts.equipment')


@section('content')


			<h1> List of Equipment</h1>
			<div class="pull-right">Equipment per Page
				<select id="equipment-per-page" name="equipment-per-page" onchange="update_page(this.value)">
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div><br>
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<div class="pull-left">
					<h4>Equipment</h4>
				</div>

	    		<div class="pull-right">

					<a href="{{ route("equipment.create") }}" class="btn btn-success">
		              <i class="glyphicon glyphicon-plus"></i>
		              Add Equipment
		            </a>
	    		</div>

	    	</div>
            <table class="table">
            	@foreach ($pieces as $equipment)
	              <tr>
	                <td class="middle">
	                  <div class="media">
	                    <div class="media-left">
	                      <a href="#">
	                        <?php $photo = ! is_null($equipment->photo) ? $equipment->photo : 'default.png' ?>
	                        {!! Html::image('uploads/' . $photo, $equipment->name, ['class' => 'media-object', 'width'=>100, 'height'=>'auto']) !!}
	                      </a>
	                    </div>
	                    <div class="media-body">
	                      <h4 class="media-heading">{{ $equipment->name }}</h4>
	                      <address>
	                        Unit ID: <strong>{{ $equipment->unit_number }}</strong><br>
	                        Meter: {{ !empty($equipment->meter()->orderBy('created_at', 'desc')->first()) ? $equipment->meter()->orderBy('created_at', 'desc')->first()->current : "" }}<br>
													<b>Intervals</b>

													@foreach ($equipment->get_intervals() as $interval)

														<br>{{ $interval->name }}: <i>
														@if (!empty($interval->logs_for_equipment($equipment->id)->orderBy('id', 'desc')->limit(1)->first()))
															Last Serviced on {{Carbon\Carbon::parse($interval->last_service($equipment->id)->created_at)->format('M d, y') }}
															@else
										            Not Yet Serviced
										          @endif
														</i>
													@endforeach
	                      </address>
	                    </div>
	                  </div>
	                </td>
	                <td width="100" class="middle">
	                  <div>
	                  	{!! Form::open(['method' => 'DELETE', 'route' => ['equipment.destroy', $equipment->id]]) !!}
		                    <a href="{{ route("equipment.edit", ['id' => $equipment->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
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
              {!! $pieces->appends( Request::query() )->render() !!}
            </nav>
          </div>
					@section('form-script')
					<script>

					function getParameterByName(name, url) {
					    if (!url) url = window.location.href;
					    name = name.replace(/[\[\]]/g, "\\$&");
					    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
					        results = regex.exec(url);
					    if (!results) return null;
					    if (!results[2]) return '';
					    return decodeURIComponent(results[2].replace(/\+/g, " "));
					}

					$(document).ready(function() {
						var size = getParameterByName('size');
						$("#equipment-per-page option[value='" + size +"']").prop('selected', true);

						var meter_type = getParameterByName('meter_type');
						if(meter_type != null && meter_type.includes("0,")){
							$('input:checkbox[name=fueler][value=0]').prop('checked', true);
						} else {
							$('input:checkbox[name=fueler][value=0]').prop('checked', false);
						}

						var equipment_in_view = getParameterByName('equipment-in-view');
						if(!equipment_in_view){
							equipment_in_view = -1;
						}
						$('input:radio[name=equipment-in-view][value='+equipment_in_view+']').prop('checked', true);
					});

					function update_page(){
						var size = $('#equipment-per-page').val();

						var group_id = '';
						$("input[name='group']:checked").each( function () {
							group_id = group_id + $(this).val() + ",";
						});

						var meter_type = '';
						$("input[name='fueler']:checked").each( function () {
							meter_type = meter_type + $(this).val() + ",";
						});

						group_id   = group_id.slice(0, -1);
						meter_type = meter_type.slice(0, -1);

						var equipment_in_view = $('input[name=equipment-in-view]:checked').val();

						var str = "?";

						if(size>0){
							str = str + "size="+size;
							if(group_id !== ''){
								str = str + "&group_id="+group_id;
							}
						}else{
							if(group_id !== ''){
								str = str + "group_id="+group_id;
							}
						}
						if(meter_type !== ''){
							str = str + "&meter_type="+meter_type;
						}
						if(equipment_in_view>0){
							str = str + "&equipment-in-view="+equipment_in_view;
						}

						window.location.href = "equipment" + str;
					}


			      $(function() {
			        $("input[name=term]").autocomplete({
			          source: "{{ route("equipment.autocomplete") }}",
			          minLength: 3,
			          select: function(event, ui){
			            window.location.href = "equipment/" + ui.item.id + "/edit";
			            $(this).val(ui.item.value);
			          }
			        });
			      });
			    </script>
					@endsection


@endsection
