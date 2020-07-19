<div class="form-row">
    <div class="col">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Title: </span>
            </div>
            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" type="text" id="title"
                   value="{{ old('title', optional($question)->title) }}" minlength="1" maxlength="255"
                   placeholder="Enter title here...">
        </div>
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col">
        <div class="input-group mb-3 is-invalid">
            <div class="input-group-prepend">
                <span class="input-group-text">Status: </span>
            </div>
            @if(old('is_active', optional($question)->is_active) == 1)
                <input type="hidden" value="1" name="is_active"/>
                <button class="btn btn-success" disabled>Active</button>
            @else
                <button class="btn btn-danger" disabled>Closed</button>
            @endif
        </div>
        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
