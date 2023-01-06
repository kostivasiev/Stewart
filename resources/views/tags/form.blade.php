<div class="panel-body">
  <div class="form-horizontal">
    <div class="row">
      <div class="col-md-8">
        @if (count($errors))
        <div class="alert alert-danger">
         <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
        </div>
      @endif
      <div class="form-group">
        <label for="name" class="control-label col-md-3">Name</label>
        <div class="col-md-8">
         {!! Form::text('name',null, ['class' => 'form-control']) !!}
       </div>
     </div>
   </div>
</div>
</div>
</div>
<div class="panel-footer">
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <button type="submit" class="btn btn-primary">{{ ! empty($tag->id) ? "Update" : "Save" }}</button>
          <a href="{{ url('/tags') }}" class="btn btn-default">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>

@section('form-script')

<script>

</script>

@endsection
