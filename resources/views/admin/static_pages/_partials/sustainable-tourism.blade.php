<div id="form-vertical" class="form-horizontal form-wizard-wrapper">
    <h3>Section 1</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-6">
            <label>Tag Line</label>
            <input type="text" name="content[section1_tag_line]" class="form-control" @if($obj->content && isset($obj->content['section1_tag_line'])) value="{{$obj->content['section1_tag_line']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Title</label>
            <input type="text" name="content[section1_title]" class="form-control" @if($obj->content && isset($obj->content['section1_title'])) value="{{$obj->content['section1_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="content[section1_description]" class="form-control">@if($obj->content && isset($obj->content['section1_description'])) {{$obj->content['section1_description']}} @endif</textarea>
        </div>
        <div class="form-group col-md-12">
            @php
                $media_id_section1 = ($obj->content && isset($obj->content['media_id_section1']))?$obj->content['media_id_section1']:null;
            @endphp
            @include('admin.media.set_file', ['file'=>$media_id_section1, 'title'=>'Image Banner', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[media_id_section1]', 'id'=>'media_id_section1', 'display'=> 'horizontal'])                                             
        </div><!--end form-group-->
        <div class="form-group col-md-4">
            <label>Bottom Link Text</label>
            <input type="text" name="content[section1_button_text]" class="form-control" @if($obj->content && isset($obj->content['section1_button_text'])) value="{{$obj->content['section1_button_text']}}" @endif >
        </div>  
        <div class="form-group col-md-4">
            <label>Bottom Link Url</label>
            <input type="text" name="content[section1_button_url]" class="form-control" @if($obj->content && isset($obj->content['section1_button_url'])) value="{{$obj->content['section1_button_url']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Bottom Link Target</label>
            <select name="content[section1_button_target]" class="form-control" id="inputStatus">
                <option value="" @if($obj->content && isset($obj->content['section1_button_target']) && $obj->content['section1_button_target'] == "") selected="selected" @endif></option>
                <option value="_blank" @if($obj->content && isset($obj->content['section1_button_target']) && $obj->content['section1_button_target'] == "_blank") selected="selected" @endif>_blank</option>
            </select>
        </div>           
    </fieldset><!--end fieldset-->
    <h3>Section 2</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Title (Left)</label>
            <input type="text" name="content[section2_left_title]" class="form-control" @if($obj->content && isset($obj->content['section2_left_title'])) value="{{$obj->content['section2_left_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description (Left)</label>
            <textarea name="content[section2_left_description]" class="form-control">@if($obj->content && isset($obj->content['section2_left_description'])) {{$obj->content['section2_left_description']}} @endif</textarea>
        </div>
        <div class="form-group col-md-12">
            @php
                $media_id_section2_left = ($obj->content && isset($obj->content['media_id_section2_left']))?$obj->content['media_id_section2_left']:null;
            @endphp
            @include('admin.media.set_file', ['file'=>$media_id_section2_left, 'title'=>'Image Left', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[media_id_section2_left]', 'id'=>'media_id_section2_left', 'display'=> 'horizontal'])                                             
        </div><!--end form-group-->
        <div class="form-group col-md-4">
            <label>Bottom Link Text (Left)</label>
            <input type="text" name="content[section2_left_button_text]" class="form-control" @if($obj->content && isset($obj->content['section2_left_button_text'])) value="{{$obj->content['section2_left_button_text']}}" @endif >
        </div>  
        <div class="form-group col-md-4">
            <label>Bottom Link Url (Left)</label>
            <input type="text" name="content[section2_left_button_url]" class="form-control" @if($obj->content && isset($obj->content['section2_left_button_url'])) value="{{$obj->content['section2_left_button_url']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Bottom Link Target (Left)</label>
            <select name="content[section2_left_button_target]" class="form-control" id="inputStatus">
                <option value="" @if($obj->content && isset($obj->content['section2_left_button_target']) && $obj->content['section2_left_button_target'] == "") selected="selected" @endif></option>
                <option value="_blank" @if($obj->content && isset($obj->content['section2_left_button_target']) && $obj->content['section2_left_button_target'] == "_blank") selected="selected" @endif>_blank</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label>Title (Right)</label>
            <input type="text" name="content[section2_right_title]" class="form-control" @if($obj->content && isset($obj->content['section2_right_title'])) value="{{$obj->content['section2_right_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description (Right)</label>
            <textarea name="content[section2_right_description]" class="form-control">@if($obj->content && isset($obj->content['section2_right_description'])) {{$obj->content['section2_right_description']}} @endif</textarea>
        </div>
        <div class="form-group col-md-12">
            @php
                $media_id_section2_right = ($obj->content && isset($obj->content['media_id_section2_right']))?$obj->content['media_id_section2_right']:null;
            @endphp
            @include('admin.media.set_file', ['file'=>$media_id_section2_right, 'title'=>'Image Right', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[media_id_section2_right]', 'id'=>'media_id_section2_right', 'display'=> 'horizontal'])                                             
        </div><!--end form-group-->     
    </fieldset><!--end fieldset-->
    <h3>Section 3</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-6">
            <label>Tag Line</label>
            <input type="text" name="content[section3_tag_line]" class="form-control" @if($obj->content && isset($obj->content['section3_tag_line'])) value="{{$obj->content['section3_tag_line']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Title</label>
            <input type="text" name="content[section3_title]" class="form-control" @if($obj->content && isset($obj->content['section3_title'])) value="{{$obj->content['section3_title']}}" @endif >
        </div>       
    </fieldset><!--end fieldset-->
    <h3>Detail Page</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Other process listing title</label>
            <input type="text" name="content[detail_page_other_process_listing_title]" class="form-control" @if($obj->content && isset($obj->content['detail_page_other_process_listing_title'])) value="{{$obj->content['detail_page_other_process_listing_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Other process listing short description</label>
            <textarea name="content[detail_page_other_process_listing_short_description]" class="form-control">@if($obj->content && isset($obj->content['detail_page_other_process_listing_short_description'])) {{$obj->content['detail_page_other_process_listing_short_description']}} @endif</textarea>
        </div>       
    </fieldset><!--end fieldset-->                                
</div><!--end form-->