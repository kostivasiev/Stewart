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
                  <div class="form-group">
                    <label for="name" class="control-label col-md-3">Name</label>
                    <div class="col-md-8">
                     {!! Form::text('name',null, ['class' => 'form-control']) !!}
                   </div>
                 </div>
                 <div class="form-group">
                  <label for="company" class="control-label col-md-3">MPN</label>
                  <div class="col-md-8">
                    {!! Form::text('manufacture_part_number',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">Description</label>
                  <div class="col-md-8">
                    {!! Form::text('description',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="company" class="control-label col-md-3">link</label>
                  <div class="col-md-8">
                    {!! Form::text('link',null, ['class' => 'form-control']) !!}
                  </div>
                </div>
            </div>
            </div>
            @if (!empty($interval))
            <div class="col-md-6">
	  					<h3>Assignment
              </h3>
              <input type="checkbox" name="equipment_assignment[]" value="{{ $equipment->id }}"> Assign to {{ $equipment->name }}
				        <ul id="tree1">
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
        </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <button type="submit" class="btn btn-primary" id="update-part-assignment-button">{{ ! empty($contact->id) ? "Update" : "Save" }}</button>
                <a href="#" class="btn btn-default">Cancel</a>
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




          $("#update-part-assignment-button").click(function() {
            var searchIDs = $("#assigned-part-checkboxes[] input:checkbox:checked").map(function(){
              return $(this).val();
            }).get(); // <----

            var checked = [];
          $("input[name='assigned-part-checkboxes[]']:checked").each(function ()
          {
          checked.push(parseInt($(this).val()));
          });

            console.log(checked);
            var unchecked = [];
            $("input[name='assigned-part-checkboxes[]']:not(:checked)").each(function ()
            {
                unchecked.push(parseInt($(this).val()));
            });

                  console.log(unchecked);

                  $.ajax({
                    url: "{{ route("years.assign_parts") }} ",
                    method: 'post',
                    data: {
                      name: "new_group",
                      checked: checked,
                      unchecked: unchecked,
                      part_id: 1,
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
