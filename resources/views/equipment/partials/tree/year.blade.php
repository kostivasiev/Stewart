<ul>
@foreach($years as $year)
	<li>
	    <input type="checkbox" name="years[]" value="{{$year->id}}" {{ in_array($year->id, $interval->years()->get()->pluck('id')->toArray()) ? "checked" : "" }}> {{ $year->year }}
	</li>
@endforeach
</ul>
