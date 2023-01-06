
    @foreach ($intervals as $interval)

    <td>
      <b>{{$interval->name}}</b>
    </td>
    <td>
      @if ($interval->meter_interval != 0)
      <input type="text" id="next-meter-interval-{{ $interval->id }}-{{ $interval->equipment_id }}" value="{{$interval->meter_due}}" size="6">
      <p class="help-block">Meter</p>
      @endif
    </td>
    <td>
      @if ($interval->date_interval != 0)
      <input type="date" id="next-date-interval-{{ $interval->id }}-{{ $interval->equipment_id }}" value="{{date('Y-m-d', strtotime($interval->date_due))}}" size="10">
      <p class="help-block">Date</p>
      @endif
    </td>
    @endforeach
    <td>
      <button type="button" class="btn btn-primary" onclick="ResetMultipleIntervals([@foreach ($intervals as $interval) {{ $interval->id }}, @endforeach], {{ $interval->equipment_id }})">Save</button>
    </td>
