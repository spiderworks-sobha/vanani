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
        <div class="form-group col-md-12">
            <label>Banner button text</label>
            <input type="text" name="content[section1_banner_button_text]" class="form-control" @if($obj->content && isset($obj->content['section1_banner_button_text'])) value="{{$obj->content['section1_banner_button_text']}}" @endif >
        </div>           
    </fieldset><!--end fieldset--> 
    <h3>Section 3 & Detail page</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Reviews Title</label>
            <input type="text" name="content[section3_reviews_title]" class="form-control" @if($obj->content && isset($obj->content['section3_reviews_title'])) value="{{$obj->content['section3_reviews_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Reviews statistics top</label>
            <input type="text" name="content[section3_reviews_statistics_top]" class="form-control" @if($obj->content && isset($obj->content['section3_reviews_statistics_top'])) value="{{$obj->content['section3_reviews_statistics_top']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Reviews statistics bottom</label>
            <input type="text" name="content[section3_reviews_statistics_bottom]" class="form-control" @if($obj->content && isset($obj->content['section3_reviews_statistics_bottom'])) value="{{$obj->content['section3_reviews_statistics_bottom']}}" @endif >
        </div>      
    </fieldset><!--end fieldset-->                                        
    <h3>Section 4</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Tag Line</label>
            <input type="text" name="content[section4_tagline]" class="form-control" @if($obj->content && isset($obj->content['section4_tagline'])) value="{{$obj->content['section4_tagline']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="content[section4_description]" class="form-control editor">@if($obj->content && isset($obj->content['section4_description'])) {{$obj->content['section4_description']}} @endif</textarea>
        </div>           
    </fieldset><!--end fieldset-->  
    <h3>Detail Page</h3>
    <fieldset class="row">                                                                               
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