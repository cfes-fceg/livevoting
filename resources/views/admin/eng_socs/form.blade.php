
<div class="input-group mb-3">
    <div class="input-group-prepend col-2 col-lg-1  p-0">
        <label for="name" class="input-group-text w-100" id="basic-addon1">Name: </label>
    </div>
    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($engSoc)->name) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="input-group mb-3">
    <div class="input-group-prepend col-2 col-lg-1  p-0">
        <label for="location" class="input-group-text w-100" id="basic-addon1">Location: </label>
    </div>
    <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location" type="text" id="location" value="{{ old('location', optional($engSoc)->location) }}" minlength="1" placeholder="Enter location here...">
    {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
</div>

