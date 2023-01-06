
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Unit Number</th>
        <th>Name</th>
        <th>Meter Type</th>
        <th>Current Meter</th>
        <th>Fuel Group</th>
      </tr>
      @foreach ($equipment as $piece)
        <tr>

          <td>{{ $piece->unit_number }}</td>
          <td>{{ $piece->name }}</td>
          @if($piece->meter_type==2)
          <td>No Meter</td>
          @elseif($piece->meter_type==1)
          <td>Odometer</td>
          @elseif($piece->meter_type==0)
          <td>Hour Meter</td>
          @elseif($piece->meter_type==3)
          <td>Non Fueler</td>
          @else
          <td></td>
          @endif


          <td>{{ !empty($piece->meter()->orderBy('created_at', 'desc')->first()) ? $piece->meter()->orderBy('created_at', 'desc')->first()->current : "" }}</td>
          <td>
          @foreach ($piece->fuel_groups()->orderBy('name')->get() as $fuel_group)
            {{ $fuel_group->name }} <br>
          @endforeach
          </td>
        </tr>
      @endforeach
    </table>
