
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Equipment</th>
        <th>Fuel Group</th>
      </tr>
      @foreach ($equipment as $piece)
        <tr>

          <td>({{ $piece->unit_number }}) {{ $piece->name }}</td>
          <td>
          @foreach ($piece->fuel_groups()->orderBy('name')->get() as $fuel_group)
            {{ $fuel_group->name }} <br>
          @endforeach
          </td>
        </tr>
      @endforeach
    </table>
