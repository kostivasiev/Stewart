
    @foreach ($equipment->intervals as $interval)
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">
          <strong>{{ $interval->name}}</strong>
      </div>
      <div class="panel-body">
        <div id="interval-overview-{{ $interval->id }}">
          @if ($interval->meter_interval != 0)
            @if ($equipment->current_meter + $interval->meter_alert < $interval->meter_due)
            <span class="label label-success">Okay</span>  Due in {{ $interval->meter_due - $equipment->current_meter }} machine hours ({{ $interval->meter_due }})<br>
            @elseif ($equipment->current_meter < $interval->meter_due)
            <span class="label label-primary">Upcomming</span>  Due in {{ $interval->meter_due - $equipment->current_meter }} machine hours ({{ $interval->meter_due }})<br>
            @elseif ($equipment->current_meter < $interval->meter_due + $interval->meter_alert)
            <span class="label label-warning">Current</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})<br>
            @else
            <span class="label label-danger">Overdue</span>  Overdue by {{ $equipment->current_meter - $interval->meter_due }} machine hours ({{ $interval->meter_due }})<br>
            @endif
          @endif
          @if ($interval->date_interval != 0)
            @if ($interval->date_status == "Okay")
            <span class="label label-success">Okay</span>  Due in {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }})<br>
            @elseif ($interval->date_status == "Upcomming")
            <span class="label label-primary">Upcomming</span>  Due in {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }}) <br>
            @elseif ($interval->date_status == "Current")
            <span class="label label-warning">Current</span>  Overdue by {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }}) <br>
            @else
            <span class="label label-danger">Overdue</span>  Overdue by {{ $interval->date_due_in_days }} days ({{ $interval->date_due_formatted }}) <br>
            @endif
          @endif
          @if (!empty($interval->interval_log))
            Last Service: {{ Carbon\Carbon::parse($interval->interval_log->created_at)->format('M d, y') }} at meter {{ $interval->interval_log->current }}
          @else
            Not Yet Serviced
          @endif
          @if ($equipment->current_meter_old_value)
            <br><span class="label label-default">Adjusted Meter</span><br>
            Original: {{ $equipment->current_meter_old_value }}<br>
            New: {{ $equipment->current_meter }}
          @endif
        </div>
        <input type="checkbox" name="interval_ids[]" id="reset-interval-checkbox-{{ $interval->id }}" style="display:none" checked>
        <div id="interval-reset-{{ $interval->id }}" style="display:none">
          <div class="form-group">
           <label for="company" class="control-label col-md-3">Current Meter</label>
           <div class="col-md-8">
             {!! Form::number('current_meter',$equipment->current_meter, ['class' => 'form-control', 'id' => "current_meter_interval_$interval->id", 'onchange' => "update_all_current_meter_fields_and_next_meter_fields(this.value, $interval->meter_interval, $interval->id)"]) !!}
           </div>
         </div>
         @if ($interval->meter_interval != 0)
         <div class="form-group">
          <label for="company" class="control-label col-md-3">Next Meter</label>
          <div class="col-md-8">
            {!! Form::number('interval_next_meter',$interval->meter_next, ['class' => 'form-control', 'id' => "next_meter_interval_$interval->id"]) !!}
            <span class="help-block">Repeats every {{ $interval->meter_interval }} hours</span>
          </div>
        </div>
        @endif
        @if ($interval->date_interval != 0)
        <div class="form-group">
         <label for="company" class="control-label col-md-3">Next Date</label>
         <div class="col-md-8">
           {!! Form::date('interval_next_date', date('Y-m-d', strtotime($interval->date_next)) , ['class' => 'form-control', 'id' => "next_date_interval_$interval->id"]) !!}
           <span class="help-block">Repeats every {{ $interval->date_interval }} days</span>
         </div>
       </div>
       @endif
       <div class="form-group">
        <div class="col-md-11">
          <div class="pull-right">
            <button type="button" class="btn btn-primary" onclick="SaveInterval([{{ $interval->id }}])">Save</button>
          </div>
        </div>
      </div>
        </div>
        <div style="display:none" id="interval-contents-{{ $interval->id }}">
        <table class="table table-striped table-hover" style="display:none">
          <thead>
            <tr>
              <th>Status</th>
              <th>Due In</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="middle">
                <span class="label label-success">Okay</span>
              </td>
              <td class="middle">
                 hours
              </td>
            </tr>
            <tr>
              <td class="middle">
                <span class="label label-danger">Overdue</span>
              </td>
              <td class="middle">
                 days
              </td>
            </tr>
          </tbody>
        </table>
        <h4>NOTE:</h4>
        {{ $interval->notes }}
        <!-- Table -->
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Part</th>
              <th>MFP</th>
              <th>Description</th>
              <th>Qty</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($interval->parts as $part)
            <tr>
              <td class="middle">
                {{ $part->name }}
              </td>
              <td class="middle">
                {{ $part->manufacture_part_number }}
              </td>
              <td class="middle">
                {{ $part->description }}
              </td>
              <td class="middle">
                {{ $part->quantity }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </div>
      <div class="panel-footer clearfix">
        <div class="pull-right">
        <a onclick="ToggleIntervalView({{ $interval->id }})" class="btn btn-default">
          <i class="glyphicon glyphicon-eye-open"></i>
          View
        </a>
          <a onclick="ToggleResetView({{ $interval->id }})" class="btn btn-default">
            <i class="glyphicon glyphicon-retweet"></i>
            Reset
          </a>
        </div>
      </div>
    </div>
    @endforeach
