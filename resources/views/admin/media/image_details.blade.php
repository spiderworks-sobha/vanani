<div class="img-details">
            <p><b>File Path: </b> {{ asset('public/'.$file->file_path) }} </p>
            @if(!auth()->user()->can('media_editing'))
              <p><b>File Name: </b> {{$file->file_name}}</p>
            @endif
            <p><b>File Size: </b> {{BladeHelper::formatBytes($file->file_size)}} </p>
            <p><b>Last updated On: </b> <?php echo date('d M, Y h:i A', strtotime($file->updated_at));?></p>
            <p><b>File Type: </b> {{$file->file_type}}</p>
            @if($file->media_type == 'Image')
              <p><b>File Dimensions: </b> {{$file->dimensions}}</p>
            @endif
          </div>
          @if(auth()->user()->can('media_editing'))
          <form method="POST" action="{{ route('admin.media.store-extra', ['id'=>$file->id]) }}" id="mediaExtraFrm">
            @csrf
            <input type="hidden" name="show_type" @if(isset($show_type)) value="{{$show_type}}" @endif>
            <div class="image_details_edit">
              @php
                $file_parts = pathinfo($file->file_name);
                $file_ext = $file_parts['extension'];
                $file_name = $file_parts['filename'];
              @endphp
              <div class="input-group mb-3">                                            
                  <input type="text" name="file_name" class="form-control" value="{{$file_name}}" placeholder="File Name">
                  <div class="input-group-append">
                    <span class="input-group-text">.{{$file_ext}}</span>
                  </div>
                  <small class="text-mute">Because of some security reasons a unique code will automatically append to file name</small>
              </div>
              @if($file->media_type == 'Image')
                <div class="form-group required">
                  <input type="text" name="alt_text" class="form-control" value="{{$file->alt_text}}" placeholder="Alt Text" id="inputAlt">
                </div>
              @else
              <div class="form-group required">
                  <input type="text" name="title" class="form-control" value="{{$file->title}}" placeholder="Title">
              </div>
              @endif
              <div class="form-group required">
                  <textarea name="description" class="form-control" id="inputDescription" rows="3" placeholder="Description">{{$file->description}}</textarea>
              </div>
              <div class="form-group required">
                  <button type="button" class="btn btn-soft-primary" @if(isset($show_type)) id="extra-data-popup-submit-btn" @else id="extra-data-submit-btn" @endif data-force-open="true">Save</button> 
              </div>
              <div class="alert alert-success" style="display: none;" id="mediaExtraMsg" >
              </div>
            </div>
          </form>
          @endif