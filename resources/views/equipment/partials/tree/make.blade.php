<ul>
@foreach($makes as $make)
	<li>
	    <input type="checkbox" name="makes[]" value="{{$make->id}}" {{ in_array($make->id, $interval->makes()->get()->pluck('id')->toArray()) ? "checked" : "" }}> {{ $make->name }}
				@if(count($make->models))
            @include('equipment.partials.tree.model',['models' => $make->models])
        @endif
	</li>
@endforeach
</ul>
