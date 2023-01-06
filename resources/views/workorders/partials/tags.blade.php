
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">
          <strong>Tags</strong>
      </div>
      <div class="panel-body">
        <div data-toggle="buttons">
          @foreach ($tags as $tag)
          <label class="btn btn-default btn-block {{ $tag->checked ? "active" : ""}}">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $tag->checked ? "checked" : ""}}> {{ $tag->name }}
          </label>
          @endforeach
        </div>
      </div>

    </div>
