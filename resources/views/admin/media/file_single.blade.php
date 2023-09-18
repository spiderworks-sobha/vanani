<div class="col-md-3 media-previe-wrap" >
				<div class="thumbnail text-center" id="single-file-item-{{$file->id}}">
					@if($file->media_type == "Image")
						<img src="{{ asset($file->file_path) }}" width="200px;" class="checkable @if(isset($is_new) && $is_new == 1) new_file @endif" id="{{encrypt($file->id)}}" data-original-src="{{ asset($file->file_path) }}" data-file-path="{{$file->file_path}}">
						
					@else
						<img src="{{ asset($file->thumb_file_path) }}" class="icon checkable @if(isset($is_new) && $is_new == 1) new_file @endif" id="{{encrypt($file->id)}}" data-original-src="{{ asset($file->file_path) }}" data-type="{{$file->file_type}}" data-file-path="{{$file->file_path}}">
						
					@endif
				</div>
			</div>