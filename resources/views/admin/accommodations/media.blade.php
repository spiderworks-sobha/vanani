    <div class="col-md-4 mb-2 gallery-item" id="gallery-item-{{$accommodation_media_id}}">
        <div class="thumbnail text-center" >
			<div class="card">
                @if($item->media_type == 'Image')
                    <a href="{{route('admin.media.show', [encrypt($item->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Image Details" 
                    data-popup-size="large"><img src="{{ asset($item->file_path) }}?ver={{time()}}" width="200px"></a>
                @else
                    <a href="{{route('admin.media.show', [encrypt($item->id)])}}" class="webadmin-open-ajax-popup item-meida" title="View Vide Details" 
                    data-popup-size="large"><img src="{{ asset($item->thumb_file_path) }}"></a>
                @endif
                <div class="card-body">
                    <p class="card-text">File: {{$item->file_name}}</p>
                    <p class="card-text">Size: {{BladeHelper::formatBytes($item->file_size)}}</p>
                    <hr/>
                    <div class="text-center">
                        <a href="{{route('admin.accommodations.media.edit', [encrypt($accommodation_media_id)])}}" class="webadmin-open-ajax-popup item-meida" title="Update Media Details" 
                    data-popup-size="large"><i class="fas fa-pencil-alt"></i></a>
                        <a href="{{route('admin.accommodations.media.destroy', [encrypt($accommodation_media_id)])}}" class="gallery-item-remove ml-2" ><i class="fas fa-trash"></i></a>
                    </div>
                    
                </div>
		    </div>
		</div>
    </div>