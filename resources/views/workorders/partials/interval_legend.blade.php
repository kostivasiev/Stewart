
  <div class="list-group">

    <a href="{{ route('workorders.interval_view') }}" class="list-group-item">Total Intervals <span class="badge">{{ $cnt }}</span></a>
    <a href="{{ route('workorders.interval_view', ['type' => 1]) }}" class="list-group-item">Upcoming Intervals <span class="badge">{{ $upcoming_status }}</span></a>
    <a href="{{ route('workorders.interval_view', ['type' => 2]) }}" class="list-group-item">Current Intervals <span class="badge">{{ $current_status }}</span></a>
    <a href="{{ route('workorders.interval_view', ['type' => 3]) }}" class="list-group-item">Overdue Intervals <span class="badge">{{ $overdue_status }}</span></a>

  </div>
