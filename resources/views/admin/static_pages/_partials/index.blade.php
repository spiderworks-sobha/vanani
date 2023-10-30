<div id="form-vertical" class="form-horizontal form-wizard-wrapper">
<h3>Section 1</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Banner Text</label>
                                                                <input type="text" name="content[section1_banner_text]" class="form-control" @if($obj->content && isset($obj->content['section1_banner_text'])) value="{{$obj->content['section1_banner_text']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Text (Left bottom corner)</label>
                                                                <input type="text" name="content[section1_left_bottom_text]" class="form-control" @if($obj->content && isset($obj->content['section1_left_bottom_text'])) value="{{$obj->content['section1_left_bottom_text']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Text (Button Left)</label>
                                                                <input type="text" name="content[section1_button_left_text]" class="form-control" @if($obj->content && isset($obj->content['section1_button_left_text'])) value="{{$obj->content['section1_button_left_text']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Link Text</label>
                                                                <input type="text" name="content[section1_link_text]" class="form-control" @if($obj->content && isset($obj->content['section1_link_text'])) value="{{$obj->content['section1_link_text']}}" @endif >
                                                            </div>  
                                                            <div class="form-group col-md-4">
                                                                <label>Link Url</label>
                                                                <input type="text" name="content[section1_link_url]" class="form-control" @if($obj->content && isset($obj->content['section1_link_url'])) value="{{$obj->content['section1_link_url']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Link Target</label>
                                                                <select name="content[section1_link_target]" class="form-control" id="inputStatus">
                                                                    <option value="" @if($obj->content && isset($obj->content['section1_link_target']) && $obj->content['section1_link_target'] == "") selected="selected" @endif></option>
                                                                    <option value="_blank" @if($obj->content && isset($obj->content['section1_link_target']) && $obj->content['section1_link_target'] == "_blank") selected="selected" @endif>_blank</option>
                                                                </select>
                                                            </div>                                                                           
                                                        </fieldset><!--end fieldset-->                                        
                                                        <h3>Section 2</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line</label>
                                                                <input type="text" name="content[tag_line1]" class="form-control" @if($obj->content && isset($obj->content['tag_line1'])) value="{{$obj->content['tag_line1']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_1]" class="form-control" @if($obj->content && isset($obj->content['title_1'])) value="{{$obj->content['title_1']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_1]" class="form-control">@if($obj->content && isset($obj->content['description_1'])) {{$obj->content['description_1']}} @endif</textarea>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Category Link Text</label>
                                                                <input type="text" name="content[category_link_text]" class="form-control" @if($obj->content && isset($obj->content['category_link_text'])) value="{{$obj->content['category_link_text']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Enquiry Text</label>
                                                                <input type="text" name="content[enquiry_text]" class="form-control" @if($obj->content && isset($obj->content['enquiry_text'])) value="{{$obj->content['enquiry_text']}}" @endif >
                                                            </div>                                                                           
                                                        </fieldset><!--end fieldset--> 

                                                        <h3>Section 3 (Right)</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line</label>
                                                                <input type="text" name="content[tag_line2]" class="form-control" @if($obj->content && isset($obj->content['tag_line2'])) value="{{$obj->content['tag_line2']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_2]" class="form-control" @if($obj->content && isset($obj->content['title_2'])) value="{{$obj->content['title_2']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Content</label>
                                                                <textarea name="content[description_2]" class="form-control">@if($obj->content && isset($obj->content['description_2'])) {{$obj->content['description_2']}} @endif</textarea>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Link Text</label>
                                                                <input type="text" name="content[link_text_2]" class="form-control" @if($obj->content && isset($obj->content['link_text_2'])) value="{{$obj->content['link_text_2']}}" @endif >
                                                            </div>  
                                                            <div class="form-group col-md-4">
                                                                <label>Link Url</label>
                                                                <input type="text" name="content[link_url_2]" class="form-control" @if($obj->content && isset($obj->content['link_url_2'])) value="{{$obj->content['link_url_2']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Link Target</label>
                                                                <select name="content[link_target_2]" class="form-control" id="inputStatus">
                                                                    <option value="" @if($obj->content && isset($obj->content['link_target_2']) && $obj->content['link_target_2'] == "") selected="selected" @endif></option>
                                                                    <option value="_blank" @if($obj->content && isset($obj->content['link_target_2']) && $obj->content['link_target_2'] == "_blank") selected="selected" @endif>_blank</option>
                                                                </select>
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
                                                        <h3>Section 3 (Left)</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-12">
                                                                @php
                                                                    $media_id_2_left = ($obj->content && isset($obj->content['media_id_2_left']))?$obj->content['media_id_2_left']:null;
                                                                @endphp
                                                                @include('admin.media.set_file', ['file'=>$media_id_2_left, 'title'=>'Video', 'popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'content[media_id_2_left]', 'id'=>'content_image_2_left', 'display'=> 'horizontal'])                                             
                                                            </div><!--end form-group-->
                                                            <div class="form-group col-md-6">
                                                                <label>Bottom Tag Line</label>
                                                                <input type="text" name="content[tag_line2_left]" class="form-control" @if($obj->content && isset($obj->content['tag_line2_left'])) value="{{$obj->content['tag_line2_left']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Bottom Text</label>
                                                                <input type="text" name="content[bottom_text2_left]" class="form-control" @if($obj->content && isset($obj->content['bottom_text2_left'])) value="{{$obj->content['bottom_text2_left']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Bottom Link Text</label>
                                                                <input type="text" name="content[bottom_link_text_2_left]" class="form-control" @if($obj->content && isset($obj->content['bottom_link_text_2_left'])) value="{{$obj->content['bottom_link_text_2_left']}}" @endif >
                                                            </div>  
                                                            <div class="form-group col-md-4">
                                                                <label>Bottom Link Url</label>
                                                                <input type="text" name="content[bottom_link_url_2_left]" class="form-control" @if($obj->content && isset($obj->content['bottom_link_url_2_left'])) value="{{$obj->content['bottom_link_url_2_left']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Bottom Link Target</label>
                                                                <select name="content[bottom_link_target_2_left]" class="form-control" id="inputStatus">
                                                                    <option value="" @if($obj->content && isset($obj->content['bottom_link_target_2_left']) && $obj->content['bottom_link_target_2_left'] == "") selected="selected" @endif></option>
                                                                    <option value="_blank" @if($obj->content && isset($obj->content['bottom_link_target_2_left']) && $obj->content['bottom_link_target_2_left'] == "_blank") selected="selected" @endif>_blank</option>
                                                                </select>
                                                            </div>
                                                        </fieldset><!--end fieldset-->
                                                        <h3>Section 4</h3>
                                                        <fieldset class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line</label>
                                                                <input type="text" name="content[tag_line3]" class="form-control" @if($obj->content && isset($obj->content['tag_line3'])) value="{{$obj->content['tag_line3']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title</label>
                                                                <input type="text" name="content[title_3]" class="form-control" @if($obj->content && isset($obj->content['title_3'])) value="{{$obj->content['title_3']}}" @endif >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Tag Line 2</label>
                                                                <input type="text" name="content[tag_line3_2]" class="form-control" @if($obj->content && isset($obj->content['tag_line3_2'])) value="{{$obj->content['tag_line3_2']}}" @endif >
                                                            </div>                                                                                       
                                                            <div class="form-group col-md-6">
                                                                <label>Title 2</label>
                                                                <input type="text" name="content[title_3_2]" class="form-control" @if($obj->content && isset($obj->content['title_3_2'])) value="{{$obj->content['title_3_2']}}" @endif >
                                                            </div>                                                                         
                                                        </fieldset><!--end fieldset-->                                
                                                    </div><!--end form-->