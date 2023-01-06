@if (!empty($workorder))
@if (count($workorder->intervallogs()->orderBy('created_at', 'desc')->get()))
<div class="alert alert-info">
Intervals Reset
<ul>
 @foreach ($workorder->intervallogs()->orderBy('created_at', 'desc')->get() as $logs)
 <li>{{ $logs->interval()->first()->name }} - {{ $logs->user()->first()->first_name }} {{ $logs->user()->first()->last_name }} - {{ $logs->created_at->format('m/d/y h:i') }}</li>
 @endforeach
</ul>
</div>
@endif
@endif
