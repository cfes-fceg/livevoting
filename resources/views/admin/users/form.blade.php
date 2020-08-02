<div class="input-group mb-3">
    <div class="input-group-prepend col-2 col-lg-1  p-0">
        <label for="name" class="input-group-text w-100" id="basic-addon1">Name: </label>
    </div>
    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name"
           value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="255">
</div>
<div class="input-group mb-3">
    <div class="input-group-prepend col-2 col-lg-1  p-0">
        <label for="email" class="input-group-text w-100" id="basic-addon1">Email: </label>
    </div>
    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="email" id="email"
           value="{{ old('email', optional($user)->email) }}" minlength="1">
</div>
<div class="input-group mb-3">
    <div class="input-group-prepend col-2 col-lg-1  p-0">
        <label for="role" class="input-group-text w-100">Role: </label>
    </div>
    <select class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role" id="role">
        @foreach(\App\Role\UserRole::getRoleList() as $role => $name)
            <option value="{{ $role }}" @if($user->hasRole($role)) selected @endif>{{ $name }}</option>
        @endforeach
    </select>
</div>
