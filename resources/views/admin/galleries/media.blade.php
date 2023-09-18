@if($item->upload_type == 'Upload')
    <div class="col-md-4 mb-2 gallery-item" id="gallery-item-{{$item->id}}">
        <div class="thumbnail text-center" >
			<div class="card">
                @if($item->media->media_type == 'Image')
                    <a href="{{route('admin.media.show', [encrypt($item->media->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" 
                    data-popup-size="large"><img src="{{ asset($item->media->file_path) }}?ver={{time()}}" width="200px"></a>
                @else
                    <a href="{{route('admin.media.show', [encrypt($item->media->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Vide Details" 
                    data-popup-size="large"><img src="{{ asset($item->media->thumb_file_path) }}"></a>
                @endif
                <div class="card-body">
                    <p class="card-text">File: {{$item->media->file_name}}</p>
                    <p class="card-text">Size: {{BladeHelper::formatBytes($item->media->file_size)}}</p>
                    <hr/>
                    <div class="text-center">
                        <a href="{{route('admin.galleries.media.edit', [encrypt($item->id), $type])}}" class="webadmin-open-ajax-popup item-meida" title="Update Media Details" 
                    data-popup-size="large"><i class="fas fa-pencil-alt"></i></a>
                        <a href="{{route('admin.galleries.media.destroy', [encrypt($item->id)])}}" class="gallery-item-remove ml-2" ><i class="fas fa-trash"></i></a>
                    </div>
                    
                </div>
		    </div>
		</div>
    </div>
@else
    <div class="col-md-4 mb-2 gallery-item" id="gallery-item-{{$item->id}}">
            <div class="thumbnail text-center">
                <div class="card">
                    @if($item->media)
                        <a href="{{route('admin.media.show', [encrypt($item->media->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" 
                    data-popup-size="large"><img src="{{ asset($item->media->file_path) }}?ver={{time()}}" width="200px"></a>
                    @else
                        <img src="{{$item->youtube_preview}}" class="w-100">
                    @endif
                    <div class="card-body">
                        <p class="card-text">Embed Url: {{$item->youtube_url}}</p>
                            <hr>
                            <div class="text-center">
                                <a href="{{route('admin.galleries.media.edit', [encrypt($item->id), 'Image'])}}" class="webadmin-open-ajax-popup item-meida" title="Update Media Details" 
                    data-popup-size="large"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{route('admin.galleries.media.destroy', [encrypt($item->id)])}}" class="gallery-item-remove ml-2" ><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
@endif