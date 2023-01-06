            <div class="panel-body">
              <div class="form-horizontal">
                <div class="row">
                  <div class="col-md-8">
                  	@if (count($errors))
                    <div class="alert alert-danger">
                     <ul>
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif
                  @if (!empty($equipment))
                  <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
                  @endif
                  @if (!empty($interval))
                  <div class="form-group">
                    <label for="name" class="control-label col-md-3">ID</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" value="{{ Auth::user()->company()->first()->id }}-{{ $interval->id }}" disabled>
                   </div>
                 </div>
                 @endif
                  <div class="form-group">
                    <label for="name" class="control-label col-md-3">Name</label>
                    <div class="col-md-8">
                     {!! Form::text('name',null, ['class' => 'form-control']) !!}
                   </div>
                 </div>
                 <div class="form-group">
                  <label for="company" class="control-label col-md-3">Notes</label>
                  <div class="col-md-8">
                    {!! Form::textarea('notes',null, ['class' => 'form-control', 'rows' => '4']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Meter Interval</label>
                  <div class="col-md-8">
                    {!! Form::text('meter_interval',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Meter Alert</label>
                  <div class="col-md-8">
                    {!! Form::text('meter_alert',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                @if (!empty($equipment))
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Due At</label>
                  <div class="col-md-8">
                    {!! Form::text('meter_due',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                @endif
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Date Interval</label>
                  <div class="col-md-8">
                    {!! Form::text('date_interval',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Date Alert</label>
                  <div class="col-md-8">
                    {!! Form::text('date_alert',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                @if (!empty($equipment))
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Due On</label>
                  <div class="col-md-8">
                    {!! Form::text('date_due',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                @endif
                @if (!empty($interval))
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <strong>Assignment</strong>
                  </div>
                  <div class='alert alert-warning '>
                    Intervals will only be assigned once per machine.
                  </div>
                  <ul class="tree1">
                    @foreach($equipment_types as $category)
                          <li>
                              <input type="checkbox" name="equipment_types[]" value="{{ $category->id }}" {{ in_array($category->id, $interval->equipment_types()->get()->pluck('id')->toArray()) ? "checked" : "" }}> {{ $category->name }}
                              @if(count($category->makes))
                                  @include('equipment.partials.tree.make',['makes' => $category->makes])
                              @endif
                          </li>
                      @endforeach
                  </ul>
                </div>
                @endif
                <div class="col-md-12">
                  @if (session('message'))
                    <div class='alert alert-success'>
                      {{ session('message') }}
                    </div>
                  @endif


                <div class="panel panel-default" style="display:none">
                  <div class="panel-heading">
                    <strong>Parts</strong>
                    <div class="pull-right">
                      <a href="" class="btn btn-default btn-xs" title="Edit">
                        <i class="glyphicon glyphicon-edit"></i>
                      </a>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <!-- Default panel contents -->
                </div>

                <!-- Table -->
                <table class="table table-striped table-hover">
                  <thead>
                <tr>
                  <th>Assigned</th>
                  <th>Part</th>
                  <th>MFP</th>
                  <th>Description</th>
                  <th>Link</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($parts as $part)
                  <tr >
                    <td class="middle">
                      <input type="checkbox" {{ $part->assigned ? "checked" : ""}} name="assigned-part-checkboxes" value="{{ $part->id }}">
                    </td>
                    <td class="middle">
                      {{ $part->name }}
                    </td>
                    <td class="middle">
                      {{ $part->manufacture_part_number }}
                    </td>
                    <td class="middle">
                      {{ $part->description }}
                    </td>
                    <td class="middle">
                      <a href="{{ $part->link }}" target="_blank">link</a>
                    </td>
                    <td>
                      <a href="{{ route("parts.edit", ['id' => $part->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
                        <i class="glyphicon glyphicon-edit"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <button type="submit" class="btn btn-primary" id="update-part-assignment-button">{{ ! empty($interval->id) ? "Update" : "Save" }}</button>
                <a href="{{ route("intervals.index") }}" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      @section('form-script')

      <script>
      $("#add-new-group").hide();
      $('#add-group-btn').click(function () {
        $("#add-new-group").slideToggle(function() {
          $('#new_group').focus();
        });
        return false;
      });

      $("#add-new-btn").click(function() {

        var newGroup = $("#new_group");
        var inputGroup = newGroup.closest('.input-group');

        $.ajax({
          url: "{{ route("groups.store") }} ",
          method: 'post',
          data: {
            name: $("#new_group").val(),
            _token: $("input[name=_token]").val()
          },
          success: function (group){
            if(group.id != null){
              inputGroup.removeClass('has-error');
              inputGroup.next('.text-danger').remove();

              var newOption = $('<option></option>')
              .attr('value', group.id)
              .attr('selected', true)
              .text(group.name);


              $("select[name=group_id]")
              .append( newOption );

              newGroup.val("");
            }
          },
          error: function (xhr){
            var errors = xhr.responseJSON;
            var error = errors.name[0];
            if(error){

              inputGroup.next('.text-danger').remove();

              inputGroup
              .addClass('has-error')
              .after('<p class="text-danger">' + error + '</p>');
            }
          }
        });
          });
            </script>

            <script>
              $("#update-part-assignment-button").click(function() {
                return;
                var searchIDs = $("#assigned-part-checkboxes input:checkbox:checked").map(function(){
                  return $(this).val();
                }).get(); // <----

                var checked = [];
              $("input[name='assigned-part-checkboxes']:checked").each(function ()
              {
              checked.push(parseInt($(this).val()));
              });

                console.log(checked);
                var unchecked = [];
                $("input[name='assigned-part-checkboxes']:not(:checked)").each(function ()
                {
                    unchecked.push(parseInt($(this).val()));
                });

                      console.log(unchecked);

                      $.ajax({
                        url: "{{ route("parts.assign_intervals") }} ",
                        method: 'post',
                        data: {
                          name: "new_group",
                          checked: checked,
                          unchecked: unchecked,
                          interval_id: {{ !empty($interval) ? $interval->id : 0 }},
                          _token: $("input[name=_token]").val()
                        },
                        success: function (group){
                          console.log(group);
                        },
                        error: function (xhr){
                            console.log(xhr);
                        }
                      });
              });
            </script>
            @endsection
