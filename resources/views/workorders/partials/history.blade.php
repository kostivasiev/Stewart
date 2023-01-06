
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">
          <strong>History</strong>
      </div>
      <div class="panel-body">
        <br>
        <strong>Fuel Log</strong>
        <table class="table table-striped table-hover" style="display:block">
          <thead>
            <tr>
              <th>User</th>
              <th>Meter</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fuel_logs as $log)
            <tr>
              <td class="middle">
                 {{ $log->user()->first()->first_name }} {{ $log->user()->first()->last_name }}
              </td>
              <td class="middle">
                 {{ $log->meterLog()->first()->current }}
              </td>
              <td class="middle">

                {{ $log->created_at!=NULL ? $log->created_at->format('m/d/y h:i') : $log->created_at }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <strong>Work Order Log</strong>
        <table class="table table-striped table-hover" style="display:block">
          <thead>
            <tr>
              <th>User</th>
              <th>Notes</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($workorder_logs as $logs)
            <tr>
              <?php $log = $logs->wologs()->orderby('created_at', 'desc')->first() ?>
              <td class="middle">
                {{ $log->user()->first()->last_name }}, {{ $log->user()->first()->first_name }}
              </td>
              <td class="middle">
                {{ $log->notes }}
                @foreach ($logs->tags()->get() as $tag)
                  <br><span class="badge primary">{{ $tag->name }}</span>
                @endforeach
              </td>
              <td class="middle">
                {{ $log->created_at!=NULL ? $log->created_at->format('m/d/y h:i') : $log->created_at }}
              </td>
              <td class="middle">
                {{ $logs->status==1 ? "Not Complete" : ($logs->status==2 ? "Complete" : "Void") }}
                
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <strong>Interval History</strong>
        <table class="table table-striped table-hover" style="display:block">
          <thead>
            <tr>
              <th>User</th>
              <th>Meter</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($intervals as $interval)
            <tr>
              <td class="middle" colspan="3">
                <b>{{ $interval->name }}</b>
              </td>
            </tr>
            @if (sizeof($interval->interval_log) == 0)
              <tr>
                <td colspan="3">
                  Not yet serviced
                </td>
              </tr>
            @else

            @foreach ($interval->interval_log as $log)
            <tr>
              <td class="middle">
                {{ $log->user()->first()->last_name }}, {{ $log->user()->first()->first_name }}
              </td>
              <td class="middle">
                {{ $log->current }}
              </td>
              <td>
                {{ Carbon\Carbon::parse($log->created_at)->format('M d, y') }}
              </td>



            </tr>
            @endforeach
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
