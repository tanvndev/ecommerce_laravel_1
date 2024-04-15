<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <div class="d-flex justify-content-between align-content-center ">
            <div>
                <h6 class="mb-0 fw-bold ">Album</h6>
                <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                    {{__('messages.noteNotice')[1]}}</small>
            </div>
            <a href="" class="form-label link-primary upload-picture" data-target="album">{{__('messages.album')}}</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row click-to-upload-area px-3 {{(old('album', $albums ?? '') ? 'd-none' : '')}}">
            <div class="click-to-upload upload-picture">
                <i class="icofont-upload-alt"></i>
                <p class="mb-0 mt-2">{{__('messages.albumNotice')}}</p>
            </div>
        </div>


        <div
            class="row g-4 align-items-center sortable upload-image-list {{ (empty(old('album', $albums ?? '')) ? 'd-none' : '') }}">

            @if (!empty($albums) || !empty(old('album')))
            @foreach (($albums ?? old('album')) as $album)

            <div class="col-lg-2 album-item">
                <div class="position-relative ">
                    <img class="img-thumbnail image-album" src="{{ $album }}" alt="{{ $album }}">
                    <span class="position-absolute icon-delete-album">
                        <i class="icofont-ui-close"></i>
                    </span>
                    <input type="hidden" name="album[]" value="{{ $album }}">
                </div>
            </div>
            @endforeach
            @endif
        </div>

    </div>
</div>