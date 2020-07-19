@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header clearfix">

            <span>
                <h4 class="mt-4 mb-4">Create New Engineering Society</h4>
            </span>

            <div class="btn-group btn-group-md float-right" role="group">
                <a href="{{ route('eng_socs.eng_soc.index') }}" class="btn btn-primary" title="Show All Eng Soc">
                    Show all
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

            <form method="POST" action="{{ route('eng_socs.eng_soc.store') }}" accept-charset="UTF-8"
                  id="create_eng_soc_form" name="create_eng_soc_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('admin.eng_socs.form', [
                                            'engSoc' => null,
                                          ])

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Add">
                </div>

            </form>

        </div>
    </div>

@endsection


