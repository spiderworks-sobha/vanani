<div class="settings-item w-100 confirm-wrap" id="media-item-edit">
    <form method="POST" action="{{ route('admin.sliders.update-photo') }}" id="sliderModalFrm">
        @csrf
        <input type="hidden" name="type" value="{{$type}}">
        <input type="hidden" name="id" value="{{encrypt($photo->id)}}">
        <div class="row m-0">
            <div class="col-md-6">
                @if($photo->media)
                    @include('admin.media.set_file_simple', ['file'=>$photo->media, 'title'=>'Update Slider', 'type'=>'Image-Video'])
                @endif
            </div>
            <div class="col-md-6 img-details-edit">
                <div class="row m-0">
                  <div class="form-group col-md-6">
                      <label>Title</label>
                      <input type="text" name="content[title]" class="form-control" @if($photo->meta_data && $photo->meta_data->title) value="{{$photo->meta_data->title}}" @endif >
                  </div>
                  <div class="form-group col-md-6">
                      <label>Subtitle</label>
                      <input type="text" name="content[sub_title]" class="form-control" @if($photo->meta_data && $photo->meta_data->sub_title) value="{{$photo->meta_data->sub_title}}" @endif >
                  </div>
                </div>
            </div>
            <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>