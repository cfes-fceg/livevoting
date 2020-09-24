<div>
    <div class="input-group mb-3">
        <div class="input-group-prepend col-2 px-0">
            <span class="input-group-text w-100">Title: </span>
        </div>
        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" type="text" id="title"
               value="{{ old('title', optional($question)->title) ?: $title }}" minlength="1" maxlength="255"
               placeholder="Enter title here...">
    </div>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div>
    <div class="input-group mb-3">
        <div class="input-group-prepend col-2 px-0">
            <span class="input-group-text w-100">Status: </span>
        </div>
        @if(old('is_active', optional($question)->is_active) == 1)
            <input type="hidden" value="1" name="is_active"/>
            <button class="btn btn-success" style="border-bottom-left-radius: 0; border-top-left-radius: 0;" disabled>Active</button>
        @else
            <button class="btn btn-danger" style="border-bottom-left-radius: 0; border-top-left-radius: 0;" disabled>Closed</button>
        @endif
    </div>
    {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
</div>
