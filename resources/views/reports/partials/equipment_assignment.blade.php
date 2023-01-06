
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Equipment Type</th>
        <th>Equipemnt</th>
        <th>Assignment</th>
      </tr>
      @foreach ($equipment_types as $equipment_type)
      <?php $equipments = $equipment_type->equipment()->wherein('equipment.id',$equipment_array)->orderBy('unit_number')->get(); ?>
      @if ($equipments->count() > 0)
        <tr><td colspan="3" style="text-align:center"><b>{{ $equipment_type->name }}</b></td></tr>
      @endif
        @foreach ($equipments as $equipment)
          <tr>
            <td><b>{{ $equipment_type->name }}</b></td>
            <td>({{ $equipment->unit_number }}) {{ $equipment->name }}</td>
            <td>
              @foreach ($equipment->users()->orderBy('last_name')->orderBy('first_name')->get() as $user)
              {{ $user->last_name }}, {{ $user->first_name }}<br>
              @endforeach
            </td>
          </tr>
        @endforeach
      @endforeach
    </table>
