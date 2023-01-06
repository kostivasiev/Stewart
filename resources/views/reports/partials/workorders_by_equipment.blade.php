
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <td>
          User
        </td>
        <td>
          WO-Number
        </td>
        <td>
          Equipment
        </td>
        <td>
          Labor
        </td>
        <td>
          Date
        </td>
      </tr>
      <?php $equipment = "" ?>
      @foreach ($logs as $log)
      <?php
        if($equipment != "$log->unit_number $log->name"){
          $new_equipment_flag = true;
        }else{
          $new_equipment_flag = false;
        }
        $equipment = "$log->unit_number $log->name";

      ?>
      @if($new_equipment_flag)
      <tr>
        <td colspan="5" style="text-align:center">
          <b>({{ $log->unit_number }}) {{ $log->name }}</b>
        </td>
      </tr>
      @endif
      <tr>
        <td>
          {{ $log->last_name }}, {{ $log->first_name }}
        </td>
        <td>
          <a href="{{ route("workorders.edit", ['id' => $log->workorder_id]) }}" title="View" target="_blank">
            {{ $log->workorder_id }}
          </a>
        </td>
        <td>
          ({{ $log->unit_number }}) {{ $log->name }}
        </td>
        <td>
          {{ $log->labor }}
        </td>
        <td>
          {{ Carbon\Carbon::parse($log->updated_at)->format('M d, y')  }}
        </td>
      </tr>
      <!-- <tr>
        <td bgcolor="grey" colspan="4" height="2">
        </td>
      </tr> -->
      @endforeach
    </table>
