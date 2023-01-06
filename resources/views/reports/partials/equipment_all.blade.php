
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Unit Number</th>
        <th>Name</th>
        <th>VIN/Serial</th>
        <th>Plate Number</th>
        <th>Meter Type</th>
        <th>Current Meter</th>
        <th>Part</th>
        <th>MPN</th>
        <th>Desciption</th>
      </tr>
      @foreach ($equipment as $piece)
      @if ($piece->parts()->orderBy('name')->count()==0)
        <tr>
          <td>{{ $piece->unit_number }}</td>
          <td>{{ $piece->name }}</td>
          <td>{{ $piece->vin }}</td>
          <td>{{ $piece->plate_number }}</td>
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
          <td></td>
          <td></td>
          <td></td>
        </tr>
      @endif
        @foreach ($piece->parts()->orderBy('name')->get() as $part)
          <tr>
            <td>{{ $piece->unit_number }}</td>
            <td>{{ $piece->name }}</td>
            <td>{{ $piece->vin }}</td>
            <td>{{ $piece->plate_number }}</td>
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
            <td>{{ $part->name }}</td>
            <td>{{ $part->manufacture_part_number }}</td>
            <td>{{ $part->description }}</td>
          </tr>
        @endforeach
      @endforeach
    </table>
