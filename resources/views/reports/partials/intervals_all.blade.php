
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <!-- <th>Name</th>
        <th>First Name</th>
        <th>Email</th>
        <th>PIN</th>
        <th>Cell Number</th>
        <th>Cell Provider</th>
        <th>Login Account</th>
        <th>Fuel Group</th>
        <th>Send Text</th>
        <th>Send Email</th> -->
      </tr>
      @foreach ($equipments as $equipment)
        <tr>
          <td colspan="5"><b>({{ $equipment->unit_number }}) {{ $equipment->name }}</b><br>
            <span align="right">
              Current Meter: {{ $equipment->current_meter }}
              @if ($equipment->current_meter_old_value)
              <span class="label label-default">Adjusted</span>
              Original: {{ $equipment->current_meter_old_value }}
              @endif
            </span>
          </td>
        </tr>
        @foreach ($equipment->intervals as $interval)
        <tr>
          <td>{{ $interval->name }}</td>


          @if ($interval->meter_interval != 0)
            <td>
            @if ($equipment->current_meter + $interval->meter_alert < $interval->meter_due)
            <span class="label label-success">Okay</span>  Due in {{ $interval->meter_due - $equipment->current_meter }} machine hours ({{ $interval->meter_due }})
            @elseif ($equipment->current_meter < $interval->meter_due)
            <span class="label label-primary">Upcomming</span>  Due in {{ $interval->meter_due - $equipment->current_meter }} machine hours ({{ $interval->meter_due }})
            @elseif ($equipment->current_meter < $interval->meter_due + $interval->meter_alert)
            <span class="label label-warning">Current</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})
            @else
            <span class="label label-danger">Overdue</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})
            @endif
            </td>
            @else
            <td></td>
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
    </table>
