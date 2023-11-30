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
                $section1_banner_media_id = ($obj->content && isset($obj->content['section1_banner_media_id']))?$obj->content['section1_banner_media_id']:null;
            @endphp
            @include('admin.media.set_file', ['file'=>$section1_banner_media_id, 'title'=>'Banner Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[section1_banner_media_id]', 'id'=>'section1_banner_media_id', 'display'=> 'horizontal'])                                             
        </div>
        <div class="form-group col-md-6">
            <label>Banner button text</label>
            <input type="text" name="content[section1_banner_button_text]" class="form-control" @if($obj->content && isset($obj->content['section1_banner_button_text'])) value="{{$obj->content['section1_banner_button_text']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Banner video button text</label>
            <input type="text" name="content[section1_banner_video_button_text]" class="form-control" @if($obj->content && isset($obj->content['section1_banner_video_button_text'])) value="{{$obj->content['section1_banner_video_button_text']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            @php
                $section1_banner_video_media_id = ($obj->content && isset($obj->content['section1_banner_video_media_id']))?$obj->content['section1_banner_video_media_id']:null;
            @endphp
            @include('admin.media.set_file', ['file'=>$section1_banner_video_media_id, 'title'=>'Banner Video', 'popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'content[section1_banner_video_media_id]', 'id'=>'section1_banner_video_media_id', 'display'=> 'horizontal'])                                             
        </div>               
    </fieldset><!--end fieldset--> 
    <h3>Section 2</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Tag Line</label>
            <input type="text" name="content[section2_tagline]" class="form-control" @if($obj->content && isset($obj->content['section2_tagline'])) value="{{$obj->content['section2_tagline']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section2_title]" class="form-control" @if($obj->content && isset($obj->content['section2_title'])) value="{{$obj->content['section2_title']}}" @endif >
        </div>              
    </fieldset><!--end fieldset-->                                        
    <h3>Section 3</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Tag Line</label>
            <input type="text" name="content[section3_tagline]" class="form-control" @if($obj->content && isset($obj->content['section3_tagline'])) value="{{$obj->content['section3_tagline']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section3_title]" class="form-control" @if($obj->content && isset($obj->content['section3_title'])) value="{{$obj->content['section3_title']}}" @endif >
        </div>              
    </fieldset><!--end fieldset-->  
    <h3>Detail Page</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Review Listing Title</label>
            <input type="text" name="content[detail_page_review_listing_title]" class="form-control" @if($obj->content && isset($obj->content['detail_page_review_listing_title'])) value="{{$obj->content['detail_page_review_listing_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Other rentals listing title</label>
            <input type="text" name="content[detail_page_others_listing_title]" class="form-control" @if($obj->content && isset($obj->content['detail_page_others_listing_title'])) value="{{$obj->content['detail_page_others_listing_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Other rentals listing short description</label>
            <input type="text" name="content[detail_page_others_listing_short_description]" class="form-control" @if($obj->content && isset($obj->content['detail_page_others_listing_short_description'])) value="{{$obj->content['detail_page_others_listing_short_description']}}" @endif >
        </div>              
    </fieldset><!--end fieldset-->               
</div><!--end form-->