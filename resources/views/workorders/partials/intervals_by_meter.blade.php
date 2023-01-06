
    @foreach ($intervals as $interval)
    @if($interval->hour_meter_intervals_flag==0)
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">
          <strong>{{ $interval->meter_interval }} hours</strong>
      </div>
      <div class="panel-body">
        <div id="interval-overview-{{ $interval->id }}">
          @foreach ($interval->hour_meter_intervals as $hour_meter_interval)
            <strong>{{ $hour_meter_interval->name }}</strong><br>
            @if ($hour_meter_interval->meter_interval != 0)
              @if ($current_meter + $hour_meter_interval->meter_alert < $hour_meter_interval->meter_due)
              <span class="label label-success">Okay</span>  Due in {{ $hour_meter_interval->meter_due - $current_meter }} machine hours ({{ $hour_meter_interval->meter_due }})<br>
              @elseif ($current_meter < $hour_meter_interval->meter_due)
              <span class="label label-primary">Upcomming</span>  Due in {{ $hour_meter_interval->meter_due - $current_meter }} machine hours ({{ $hour_meter_interval->meter_due }})<br>
              @elseif ($current_meter < $hour_meter_interval->meter_due + $hour_meter_interval->meter_alert)
              <span class="label label-warning">Current</span>  Overdue by {{ $current_meter - $hour_meter_interval->meter_due }} machine hours ({{ $hour_meter_interval->meter_due }})<br>
              @else
              <span class="label label-danger">Overdue</span>  Overdue by {{ $current_meter - $hour_meter_interval->meter_due }} machine hours ({{ $hour_meter_interval->meter_due }})<br>
              @endif
            @endif
            @if ($hour_meter_interval->date_interval != 0)
              @if ($hour_meter_interval->date_status == "Okay")
              <span class="label label-success">Okay</span>  Due in {{ $hour_meter_interval->date_due_in_days }} days ({{ $hour_meter_interval->date_due_formatted }})<br>
              @elseif ($hour_meter_interval->date_status == "Upcomming")
              <span class="label label-primary">Upcomming</span>  Due in {{ $hour_meter_interval->date_due_in_days }} days ({{ $hour_meter_interval->date_due_formatted }}) <br>
              @elseif ($hour_meter_interval->date_status == "Current")
              <span class="label label-warning">Current</span>  Overdue by {{ $hour_meter_interval->date_due_in_days }} days ({{ $hour_meter_interval->date_due_formatted }}) <br>
              @else
              <span class="label label-danger">Overdue</span>  Overdue by {{ $hour_meter_interval->date_due_in_days }} days ({{ $hour_meter_interval->date_due_formatted }}) <br>
              @endif
            @endif
          @endforeach
        </div>
        <div id="interval-reset-{{ $interval->id }}" style="display:none">
          <div class="panel-body">
            <div data-toggle="buttons">
              @foreach ($interval->hour_meter_intervals as $hour_meter_interval)
              <label class="btn btn-default btn-block active">
                <input type="checkbox" name="interval_ids[]" id="reset-interval-checkbox-{{$hour_meter_interval->id}}" value="" checked> {{ $hour_meter_interval->name }}
              </label>
              @endforeach
            </div>
          </div>
          @foreach ($interval->hour_meter_intervals as $hour_meter_interval)
          <div class="form-group" style="display:{{$hour_meter_interval->hour_meter_intervals_flag>0 ? "none" : ""}}">
           <label for="company" class="control-label col-md-3">Current Meter</label>
           <div class="col-md-8">
             {!! Form::number('current_meter',$current_meter, ['class' => 'form-control', 'id' => "current_meter_interval_$hour_meter_interval->id", 'onchange' => "update_all_current_meter_fields_and_next_meter_fields(this.value, $hour_meter_interval->meter_interval, $hour_meter_interval->id)"]) !!}
           </div>
         </div>

         @if ($interval->meter_interval != 0)
         <div class="form-group" style="display:{{$hour_meter_interval->hour_meter_intervals_flag>0 ? "none" : ""}}">
          <label for="company" class="control-label col-md-3">Next Meter</label>
          <div class="col-md-8">
            {!! Form::number("interval_next_meter_$interval->id",$hour_meter_interval->meter_next, ['class' => 'form-control', 'id' => "next_meter_interval_$hour_meter_interval->id", 'onchange' => "update_next_meter_fields(this.value,$interval->id)" , 'interval_id' => "$interval->id" ]) !!}
            <span class="help-block">Repeats every {{ $hour_meter_interval->meter_interval }} hours</span>
          </div>
        </div>
        @endif

          @if ($hour_meter_interval->date_interval != 0)
          <div class="form-group">
           <label for="company" class="control-label col-md-3">Next Date</label>
           <div class="col-md-8">
             {!! Form::date('interval_next_date', date('Y-m-d', strtotime($hour_meter_interval->date_next)) , ['class' => 'form-control', 'id' => "next_date_interval_$hour_meter_interval->id"]) !!}

             <span class="help-block">
               @if($interval->hour_meter_intervals->count()>1)
               {{ $hour_meter_interval->name }}<br>
               @endif
               Repeats every {{ $hour_meter_interval->date_interval }} days</span>
           </div>
          </div>
          @endif
        @endforeach
       <div class="form-group">
        <div class="col-md-11">
          <div class="pull-right">
            <button type="button" class="btn btn-primary" onclick="SaveInterval([@foreach ($interval->hour_meter_intervals as $hour_meter_interval) {{ $hour_meter_interval->id }}, @endforeach])">Save</button>
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
    @endif
    @endforeach
