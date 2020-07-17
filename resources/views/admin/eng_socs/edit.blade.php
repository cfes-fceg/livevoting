@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">{{ !empty($engSoc->name) ? $engSoc->name : 'Eng Soc' }}</h4>
            </div>
            <div class="btn-group btn-group-sm pull-right" role="group">

                <a href="{{ route('eng_socs.eng_soc.index') }}" class="btn btn-primary" title="Show All Eng Soc">
                    Show All
                </a>

                <a href="{{ route('eng_socs.eng_soc.create') }}" class="btn btn-success" title="Create New Eng Soc">
                    New
                </a>

            </div>
        </div>

        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('eng_socs.eng_soc.update', $engSoc->id) }}" id="edit_eng_soc_form" name="edit_eng_soc_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('admin.eng_socs.form', [
                                        'engSoc' => $engSoc,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
