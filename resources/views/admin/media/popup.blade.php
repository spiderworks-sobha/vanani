<div class="">
  <div class="col-md-12">
	   <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading media-popup-head">
                    <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                        <li class="nav-item">
                            <a @if(count($files)==0) class="active show" @endif data-toggle="tab" role="tab"
                               data-target="#tab1Media"
                            href="#" aria-selected="true">Upload Files</a>
                        </li>
                        <li class="nav-item">
                            <a @if(count($files)>0) class="active show" @endif data-toggle="tab" role="tab"
                               data-target="#tab2Media"
                            href="#" aria-selected="true">Media Library</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <input type="hidden" id="media-title" value="{{$title}}">
                        <input type="hidden" id="media-popupType" value="{{$popup_type}}">
                        <input type="hidden" id="media-holder_attr" value="{{$holder_attr}}">
                        <input type="hidden" id="media-related_type" value="{{$type}}">
                        <input type="hidden" id="media-related_id" value="{{$related_id}}">
                        <input type="hidden" id="media-id" value="{{$media_id}}">
                        <input type="hidden" id="media-display" value="{{$display}}">
                        @php
                          $data_url = route('admin.media.save');
                        @endphp
                        <div class="tab-pane @if(count($files)==0) active show @endif" id="tab1Media">
                          <div class="col-md-12">
                            <div class="upload-wrapper">
                              <div id="error_output"></div>
                                  <!-- file drop zone -->
                              <div id="dropzone" class="dropzone-wrapper">
                                      <i>Drop files here</i>
                                      <i class="sm-text">or</i>
                                      <!-- upload button -->
                                      <span class="button btn-soft-primary input-file">
                                          Browse Files <input type="file" id="fileupload" name="files[]" data-url="{{$data_url}}" multiple />
                                      </span>
                              </div>
                              <p class="warning"><b>Avoid multiple uploads of same files</b></p>
                                  <!-- The container for the uploaded files -->
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane @if(count($files)>0) active show @endif" id="tab2Media">
                          
                          <div class="row media-list-modal" >
                            <div class="col-md-8">
                              <div class="row mt-3">
                                <div class="col-md-6"></div>
                                    <div class="col-md-6 text-right">
                                        <label>
                                            <input class="form-control input-sm" placeholder="Search..." aria-controls="datatable" data-type="{{$type}}" type="search" id="mediaPopupSearchInput" data-url="{{route('admin.media.popup', ['popup_type'=>$popup_type])}}">
                                        </label>
                                    </div>
                              </div>
                              <div id="mediaList" class="row">
                                @include($views.'.ajax_index_popup', ['files'=>$files, 'holder_attr'=>$holder_attr, 'show_type'=>'popup'])
                              </div>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #e3ebf6">
                              <div id="show-media-item" class="m-3"></div>
                            </div>
                            
                          </div>
                          <div class="text-right">
                            @if($popup_type == 'slider')
                              <button class="btn btn-primary" id="set-gallery-btn" data-url="{{route('admin.sliders.update')}}"><i class="fas fa-plus-sign"></i> Set {{$title}}</button>
                            @else
                              <button class="btn btn-primary" id="set-media-btn"><i class="fas fa-plus-sign"></i> Set {{$title}}</button>
                            @endif
                          </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>