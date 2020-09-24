@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header clearfix">

            <div>
                <h4 class="mt-4 mb-4">{{ !empty($engSoc->name) ? $engSoc->name : 'Eng Soc' }}</h4>
            </div>
            <div class="btn-group btn-group-md float-right" role="group">

                <a href="{{ route('admin.engsocs') }}" class="btn btn-primary" title="Show All Eng Soc">
                    Show All
                </a>

                <a href="{{ route('admin.engsocs.new') }}" class="btn btn-success" title="Create New Eng Soc">
                    New
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('admin.engsocs.update', $engSoc->id) }}" id="edit_eng_soc_form"
                  name="edit_eng_soc_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('admin.eng_socs.form', [
                                            'engSoc' => $engSoc,
                                          ])

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
