<form action="{{ route('post.index') }}" method="get" class="form-list-filter">


    <div class="row">
        @include('servers.includes.filterPerpage')

        <div class="col-lg-7">
            <div class="row">
                @include('servers.includes.filterPublish')

                <div class="col-lg-4">
                    {!! Form::select('post_catalogue_id', ['' => __('messages.post.table.postCatalogue')] + $dropdown,
                    request('post_catalogue_id'), ['class' => 'form-select filter']) !!}
                </div>

            </div>
        </div>
        @include('servers.includes.filterSearch')
    </div>
</form>