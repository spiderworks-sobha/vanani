<div id="form-vertical" class="form-horizontal form-wizard-wrapper">
                                                        <h3>Section 1 (Slider)</h3>
                                                        <fieldset class="row">                                                                               
                                                            <div class="form-group col-md-12">
                                                                <label>Tag Line 1</label>
                                                                <input type="text" name="content[slider_tagline_1]" class="form-control" @if($obj->content && isset($obj->content['slider_tagline_1'])) value="{{$obj->content['slider_tagline_1']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Title 1</label>
                                                                <input type="text" name="content[slider_title_1]" class="form-control" @if($obj->content && isset($obj->content['slider_title_1'])) value="{{$obj->content['slider_title_1']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Tag Line 2</label>
                                                                <input type="text" name="content[slider_tagline_2]" class="form-control" @if($obj->content && isset($obj->content['slider_tagline_2'])) value="{{$obj->content['slider_tagline_2']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Title 2</label>
                                                                <input type="text" name="content[slider_title_2]" class="form-control" @if($obj->content && isset($obj->content['slider_title_2'])) value="{{$obj->content['slider_title_2']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Tag Line 3</label>
                                                                <input type="text" name="content[slider_tagline_3]" class="form-control" @if($obj->content && isset($obj->content['slider_tagline_3'])) value="{{$obj->content['slider_tagline_3']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Title 3</label>
                                                                <input type="text" name="content[slider_title_3]" class="form-control" @if($obj->content && isset($obj->content['slider_title_3'])) value="{{$obj->content['slider_title_3']}}" @endif >
                                                            </div>                                                          
                                                        </fieldset><!--end fieldset-->                                       
                                                        <h3>Section 1 (Banner)</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-12">
                                                                @php
                                                                    $media_id_1 = ($obj->content && isset($obj->content['media_id_1']))?$obj->content['media_id_1']:null;
                                                                @endphp
                                                                @include('admin.media.set_file', ['file'=>$media_id_1, 'title'=>'Badge', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[media_id_1]', 'id'=>'media_id_1', 'display'=> 'horizontal'])                                             
                                                            </div><!--end form-group-->                                                                                 
                                                            <div class="form-group col-md-12">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_1]" class="form-control" @if($obj->content && isset($obj->content['title_1'])) value="{{$obj->content['title_1']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_1]" class="form-control">@if($obj->content && isset($obj->content['description_1'])) {{$obj->content['description_1']}} @endif</textarea>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                @php
                                                                    $video_media_id_1 = ($obj->content && isset($obj->content['video_media_id_1']))?$obj->content['video_media_id_1']:null;
                                                                @endphp
                                                                @include('admin.media.set_file', ['file'=>$video_media_id_1, 'title'=>'Video', 'popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'content[video_media_id_1]', 'id'=>'video_media_id_1', 'display'=> 'horizontal'])                                             
                                                            </div><!--end form-group-->                                                                       
                                                        </fieldset><!--end fieldset--> 

                                                        <h3>Section 2 (Foundation)</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line</label>
                                                                <input type="text" name="content[tag_line2_foundation]" class="form-control" @if($obj->content && isset($obj->content['tag_line2_foundation'])) value="{{$obj->content['tag_line2_foundation']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_2_foundation]" class="form-control" @if($obj->content && isset($obj->content['title_2_foundation'])) value="{{$obj->content['title_2_foundation']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_2_foundation]" class="form-control">@if($obj->content && isset($obj->content['description_2_foundation'])) {{$obj->content['description_2_foundation']}} @endif</textarea>
                                                            </div>
                                                        </fieldset><!--end fieldset--> 
                                                        <h3>Section 2 (Vision)</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line</label>
                                                                <input type="text" name="content[tag_line2_vision]" class="form-control" @if($obj->content && isset($obj->content['tag_line2_vision'])) value="{{$obj->content['tag_line2_vision']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_2_vision]" class="form-control" @if($obj->content && isset($obj->content['title_2_vision'])) value="{{$obj->content['title_2_vision']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_2_vision]" class="form-control">@if($obj->content && isset($obj->content['description_2_vision'])) {{$obj->content['description_2_vision']}} @endif</textarea>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                @php
                                                                    $media_id_2 = ($obj->content && isset($obj->content['media_id_2']))?$obj->content['media_id_2']:null;
                                                                @endphp
                                                                @include('admin.media.set_file', ['file'=>$media_id_2, 'title'=>'Logo', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[media_id_2]', 'id'=>'content_image_2', 'display'=> 'horizontal'])                                             
                                                            </div><!--end form-group-->
                                                            <div class="form-group col-md-4">
                                                                <label>Bottom Link Text</label>
                                                                <input type="text" name="content[bottom_link_text_2]" class="form-control" @if($obj->content && isset($obj->content['bottom_link_text_2'])) value="{{$obj->content['bottom_link_text_2']}}" @endif >
                                                            </div>  
                                                            <div class="form-group col-md-4">
                                                                <label>Bottom Link Url</label>
                                                                <input type="text" name="content[bottom_link_url_2]" class="form-control" @if($obj->content && isset($obj->content['bottom_link_url_2'])) value="{{$obj->content['bottom_link_url_2']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Bottom Link Target</label>
                                                                <select name="content[bottom_link_target_2]" class="form-control" id="inputStatus">
                                                                    <option value="" @if($obj->content && isset($obj->content['bottom_link_target_2']) && $obj->content['bottom_link_target_2'] == "") selected="selected" @endif></option>
                                                                    <option value="_blank" @if($obj->content && isset($obj->content['bottom_link_target_2']) && $obj->content['bottom_link_target_2'] == "_blank") selected="selected" @endif>_blank</option>
                                                                </select>
                                                            </div>
                                                        </fieldset><!--end fieldset-->
                                                        <h3>Section 2 (Mission)</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line</label>
                                                                <input type="text" name="content[tag_line2_mission]" class="form-control" @if($obj->content && isset($obj->content['tag_line2_mission'])) value="{{$obj->content['tag_line2_mission']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_2_mission]" class="form-control" @if($obj->content && isset($obj->content['title_2_mission'])) value="{{$obj->content['title_2_mission']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_2_mission]" class="form-control">@if($obj->content && isset($obj->content['description_2_mission'])) {{$obj->content['description_2_mission']}} @endif</textarea>
                                                            </div>                                                                         
                                                        </fieldset><!--end fieldset-->
                                                        <h3>Section 3</h3>
                                                        <fieldset class="row">                                                                                     
                                                            <div class="form-group col-md-12">
                                                                <label>Heading</label>
                                                                <input type="text" name="content[heading_3]" class="form-control" @if($obj->content && isset($obj->content['heading_3'])) value="{{$obj->content['heading_3']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_3]" class="form-control" @if($obj->content && isset($obj->content['title_3'])) value="{{$obj->content['title_3']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Message Title</label>
                                                                <input type="text" name="content[title_3_message]" class="form-control" @if($obj->content && isset($obj->content['title_3_message'])) value="{{$obj->content['title_3_message']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_3_message]" class="form-control">@if($obj->content && isset($obj->content['description_3_message'])) {{$obj->content['description_3_message']}} @endif</textarea>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Founder Name</label>
                                                                <input type="text" name="content[founder_name]" class="form-control" @if($obj->content && isset($obj->content['founder_name'])) value="{{$obj->content['founder_name']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Bottom Line</label>
                                                                <input type="text" name="content[bottom_line]" class="form-control" @if($obj->content && isset($obj->content['bottom_line'])) value="{{$obj->content['bottom_line']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                @php
                                                                    $media_id_3 = ($obj->content && isset($obj->content['media_id_3']))?$obj->content['media_id_3']:null;
                                                                @endphp
                                                                @include('admin.media.set_file', ['file'=>$media_id_3, 'title'=>'Founder Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[media_id_3]', 'id'=>'media_id_3', 'display'=> 'horizontal'])                                             
                                                            </div><!--end form-group-->                                                                    
                                                        </fieldset><!--end fieldset-->                          
                                                    </div><!--end form-->