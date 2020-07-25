<div class="text-center">
    @if(in_array(env('APP_ENV'), ['staging', 'local']))
        <h4 class="alert alert-warning">
            <span class="font-weight-bold">
                Warning:
            </span>
            Data modified in this environment may be deleted at any time.
        </h4>
    @endif
</div>
