
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Location</th>
        <th>User</th>
        <th>Equipment</th>
        <th>Comment</th>
        <th>Gallons</th>
        <th>Meter</th>
        <th>Date</th>
      </tr>
      @foreach ($logs as $log)
        <tr>
          <td>{{ $log->pump()->first()->station()->first()->name }} - {{ $log->pump()->first()->name }}</td>

          <?php if(empty($log->user()->first())){
            if($log->user_id>0){
              $user_name = "**$log->user_id";
            }else{
              $user_name = "";
            }
          }else{
            $user_name = $log->user()->first()->first_name . " " . $log->user()->first()->last_name;
          }
          ?>
          <td>{{ $user_name }}</td>

          <?php if(empty($log->equipment()->first())){
            if($log->equipment_id>0){
              $equipment_name = "**$log->equipment_id";
            }else{
              $equipment_name = "";
            }
          }else{
            $equipment_name = '(' . $log->equipment()->first()->unit_number . ') ' . $log->equipment()->first()->name;
          }
          ?>
          <td>{{ $equipment_name }}</td>

          @if( $log->type == 3500 )
          <td> Approved</td>
          @elseif( $log->type == 3100 )
          <td>User Finished</td>
          @elseif( $log->type == 3042 )
          <td>Unauthorized for this pump</td>
          @elseif( $log->type == 3044 )
          <td>Wrong Fuel Type</td>
          @elseif( $log->type == 3101 )
          <td>Inactivity Time Reached</td>
          @elseif( $log->type == 3010 )
          <td>Invalid User: {{ $log->message}}</td>
          @elseif( $log->type == 3062 )
          <td>Text Message Failed to Send</td>
          @elseif( $log->type == 3102 )
          <td>Approved Gallons Reached</td>
          @elseif( $log->type == 3012 )
          <td>Unauthorized for this machine</td>
          @elseif( $log->type == 3507 )
          <td>Station Powered Up</td>
          @elseif( $log->type == 3509 )
          <td>Station Restarting</td>
          @elseif( $log->type == 3511 )
          <td>Sync Started</td>
          @elseif( $log->type == 3510 )
          <td>Sync Complete</td>
          @elseif( $log->type == 3020 )
          <td>Invalid Machine {{ $log->message}}</td>
          @else
          <td>If you see this message, contact Stewart Tech. Code:{{ $log->type}} {{ $log->message}}</td>
          @endif
          <td>{{ $log->consumed_gallons}}</td>
          <td>{{ $log->meter_log_id == 0 ? "" : !empty($log->meterLog()->first()->current) ? $log->meterLog()->first()->current : "" }}</td>
          <td>{{ $log->created_at->format('M j, Y g:i a') }}</td>
        </tr>
      @endforeach
    </table>
