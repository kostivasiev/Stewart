
<br><br><br><br>
END<br>
@foreach ($equipments as $equipment)

  @foreach ($equipment->intervals as $interval)
  @if($equipment->upcoming)
    {{ $equipment->name }} has an upcoming
  @endif
  @if($equipment->current)
    {{ $equipment->name }} has an current
  @endif
  ...{{ $equipment->overdue }}...
  @if($equipment->overdue)
    {{ $equipment->name }} has an overdue
  @endif
    {{ $interval->name }}<br>
      @if ($interval->meter_interval != 0)
        <td>
        @if ($equipment->current_meter < $interval->meter_due)
        @elseif ($equipment->current_meter < $interval->meter_due + $interval->meter_alert)
        <span class="label label-warning">Current</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})
        @else
        <span class="label label-danger">Overdue</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})
        @endif
      @else
      @endif
      @if ($interval->date_interval != 0)
        @if ($interval->date_status == "Okay")
        <td><span class="label label-success">Okay</span>  Due in {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }})</td>
        @elseif ($interval->date_status == "Upcomming")
        <td><span class="label label-primary">Upcomming</span>  Due in {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }}) </td>
        @elseif ($interval->date_status == "Current")
        <td><span class="label label-warning">Current</span>  Overdue by {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }}) </td>
        @else
        <td><span class="label label-danger">Overdue</span>  Overdue by {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }}) </td>
        @endif
        @else
        <td></td>
      @endif
      @if (!empty($interval->interval_log))
        <td>Last Service: {{ Carbon\Carbon::parse($interval->interval_log->created_at)->format('M d, y') }} at meter {{ $interval->interval_log->current }}</td>
      @else
        <td>Not Yet Serviced</td>
      @endif
      @if ($interval->delta_meter!=999999)
        <td>{{ $interval->delta_meter }}</td>
      @else
        <td></td>
      @endif
    </tr>
  @endforeach
@endforeach
