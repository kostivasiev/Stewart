<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <strong>Parts/Supplies</strong>
  </div>
  <div class="panel-body">
<!-- Table -->
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Part</th>
      <th>MFP</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($parts as $part)
    <tr>
      <td class="middle">
        {{ $part->name }}
      </td>
      <td class="middle">
        {{ $part->manufacture_part_number }}
      </td>
      <td class="middle">
        {{ $part->description }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
