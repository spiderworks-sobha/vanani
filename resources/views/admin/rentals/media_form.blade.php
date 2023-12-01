<div class="settings-item w-100 confirm-wrap" id="media-item-edit">
    <form method="POST" action="{{ route('admin.rentals.media.update') }}" id="galleryMediaUpdateForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="rental_media_id" value="{{encrypt($file->id)}}" />
        <div class="row m-0">
            <div class="col-md-7">
                @include('admin.media.set_file_simple', ['file'=>$file->media, 'title'=>'Update Gallery', 'type'=>'Image'])
            </div>
            <div class="col-md-5 img-details-edit">
                <div class="form-group required">
                    <label>Title</label>
                    <input type="text" name="media_title" class="form-control" value="{{$file->title}}" >
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="media_description" class="form-control" rows="3" >{{$file->description}}</textarea>
                </div>
                <div class="custom-control custom-switch switch-primary">
                    <input type="checkbox" class="custom-control-input" value="1" id="media_is_featured" name="is_featured" @if($file->is_featured == 1) checked="" @endif>
                    <label class="custom-control-label" for="media_is_featured">Is featured?</label>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-soft-primary" id="gallery-media-update-form">Save</button> 
            </div>
        </div>
    </form>
</div>