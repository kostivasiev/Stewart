<div class="navbar navbar-default">
	<ul class="nav navbar-nav">
		<li class="{{ Request::segment(3) == "edit" ? "active" : "" }}"><a href="{{ route("equipment.edit", ['id' => $equipment->id]) }}">General</a></li>
		<li class="{{ Request::segment(3) == "parts" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("Edit Parts") ? "block" : "none" }}"><a href="{{ route("equipment.parts", ['id' => $equipment->id]) }}">Parts</a></li>
		<li class="{{ Request::segment(3) == "intervals" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("Edit Intervals") ? "block" : "none" }}"><a href="{{ route("equipment.intervals", ['id' => $equipment->id]) }}">Intervals</a></li>
		<li class="{{ Request::segment(3) == "history" ? "active" : "" }}" style="display:{{ Auth::user()->hasRole("Edit Intervals") ? "block" : "none" }}"><a href="{{ route("equipment.history", ['id' => $equipment->id]) }}">History</a></li>
	</ul>
</div>
