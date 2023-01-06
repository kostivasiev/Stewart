@extends('layouts.equipment')

@section('title', 'Parts')

@section('content')

          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Equipment Parts</strong>
            </div>
            @include("equipment.partials.navbar")

          <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading clearfix">
                <div class="pull-left">
                  <h4>Parts</h4>
                </div>

                <div class="pull-right">
                  <a href="{{ route("equipment.parts", ['id' => $equipment->id, 'edit' => true]) }}" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i>
                      Edit List
                  </a>
                  <a href="{{ route("parts.create", ['equipment_id' => $equipment->id]) }}" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i>
                      Add Part
                  </a>
                </div>
              </div>

              <!-- Table -->
              <table class="table table-striped table-hover">
              <thead>
              <tr>
                <?php
                if(!empty($showAll)){
                  $editAssignmentDisplay = $showAll ? "" : "style='display:none'";
                  $defaultPartsDisplay = $showAll ? "style='display:none'" : "";
                }else{
                  $editAssignmentDisplay = "style='display:none'";
                  $defaultPartsDisplay = "";
                }
                 ?>
                <th <?php echo $editAssignmentDisplay ?>>Assigned</th>
                <th>Part</th>
                <th>MFP</th>
                <th>Description</th>
                <th>Link</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              @foreach ($parts as $part)
                <tr>
                  <td class="middle" <?php echo $editAssignmentDisplay ?>>
                    <input type="checkbox" {{ in_array($part->id, $equipment->parts()->pluck('part_id')->toArray()) ? "checked" : ""}} name="assigned-part-checkboxes" value="{{ $part->id }}">
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
                  <td class="middle">
                    <a href="{{ route("parts.edit", ['id' => $part->id,'equipment_id' => $equipment->id]) }}" class="btn btn-default btn-circle btn-xs" title="Edit">
                      <i class="glyphicon glyphicon-edit"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </table>
               <div class="panel-footer" <?php echo $editAssignmentDisplay ?>>
                 <div class="row">
                   <div class="col-md-8">
                     <div class="row">
                       <div class="col-md-offset-3 col-md-6">
                         <button type="button" class="btn btn-primary" id="update-part-assignment-button">Update</button>
                         <a href="{{ route("equipment.parts", ['id' => $equipment->id]) }}" class="btn btn-default">Cancel</a>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
            </div>
          </div>



@endsection

@section('form-script')
<script>
  $("#update-part-assignment-button").click(function() {
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
            url: "{{ route("equipment.parts.assign_equipment") }}",
            method: 'post',
            data: {
              name: "new_group",
              checked: checked,
              unchecked: unchecked,
              equipment_id: {{ $equipment->id}},
              _token: $("input[name=_token]").val()
            },
            success: function (group){
              console.log(group);
              window.location = "{{ route("equipment.parts", ['id' => "$equipment->id"]) }}"
            },
            error: function (xhr){
                console.log(xhr);
            }
          });
  });
</script>
@endsection
