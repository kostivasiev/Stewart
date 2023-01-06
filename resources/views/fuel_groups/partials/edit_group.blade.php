<div style="padding:2" id="edit-group-container-{{ $group->id }}">
  <span id="edit-group-text-{{ $group->id }}">{{ $group->name }}</span>
<a class="btn btn-circle btn-default btn-xs" title="Edit" style="float: right;" onclick="EditGroup({{ $group->id }}, '{{ $group->name }}')">
  <i class="glyphicon glyphicon-edit"></i>
</a>
<br><br>
</div>
