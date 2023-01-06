<div class="panel-body">
  <div class="form-group">
    <div class="col-md-6">
      <select name="labor[]" class='form-control' placeholder='--'>
        @foreach($mechanics as $mechanic)
          <option value='{{ $mechanic->id }}' {{ !empty($labor) ? $labor->id==$mechanic->id ? "selected" : "" : "" }}>{{ $mechanic->last_name }}, {{ $mechanic->first_name }}</option>
        @endforeach
      </select>

   </div>
   <div class="col-md-4">

      <input type="text" class="form-control" placeholder="Hours" name="labor_hours[]" value="{{ !empty($labor) ? $labor->pivot->labor : "" }}">
   </div>
  </div>
</div>
