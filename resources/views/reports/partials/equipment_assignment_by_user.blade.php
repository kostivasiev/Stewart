
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Cell Number</th>
        <th>Assigned Equipment</th>
      </tr>
      @foreach ($users as $user)
        <tr>

          <td>{{ $user->last_name }}</td>
          <td>{{ $user->first_name }}</td>
          <td>{{ $user->cell_number }}</td>
          <td>
            @foreach ($user->equipment as $equipment)
            ({{ $equipment->unit_number }}) {{ $equipment->name }}<br>
            @endforeach
          </td>
        </tr>
      @endforeach
    </table>
