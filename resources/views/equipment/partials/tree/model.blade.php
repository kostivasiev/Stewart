<ul>
@foreach($models as $model)
	<li>
	    <input type="checkbox" name="models[]" value="{{$model->id}}" {{ in_array($model->id, $interval->models()->get()->pluck('id')->toArray()) ? "checked" : "" }}> {{ $model->name }}
				@if(count($model->years))
            @include('equipment.partials.tree.year',['years' => $model->years])
        @endif
	</li>
@endforeach
</ul>
