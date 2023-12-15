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
    <h3>Section 2</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section2_title]" class="form-control" @if($obj->content && isset($obj->content['section2_title'])) value="{{$obj->content['section2_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="content[section2_description]" class="form-control">@if($obj->content && isset($obj->content['section2_description'])) {{$obj->content['section2_description']}} @endif</textarea>
        </div> 
    </fieldset><!--end fieldset-->
    <h3>Section 3</h3>
    <fieldset class="row">
        <div class="form-group col-md-6">
            <label>Tagline</label>
            <input type="text" name="content[section3_tagline]" class="form-control" @if($obj->content && isset($obj->content['section3_tagline'])) value="{{$obj->content['section3_tagline']}}" @endif >
        </div>                                                                              
        <div class="form-group col-md-6">
            <label>Title</label>
            <input type="text" name="content[section3_title]" class="form-control" @if($obj->content && isset($obj->content['section3_title'])) value="{{$obj->content['section3_title']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>No. of brands</label>
            <input type="text" name="content[section3_no_of_brands]" class="form-control" @if($obj->content && isset($obj->content['section3_no_of_brands'])) value="{{$obj->content['section3_no_of_brands']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Brand Text</label>
            <input type="text" name="content[section3_brand_text]" class="form-control" @if($obj->content && isset($obj->content['section3_brand_text'])) value="{{$obj->content['section3_brand_text']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="content[section3_description]" class="form-control">@if($obj->content && isset($obj->content['section3_description'])) {{$obj->content['section3_description']}} @endif</textarea>
        </div> 
    </fieldset><!--end fieldset-->
    <h3>Section 4</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section4_title]" class="form-control" @if($obj->content && isset($obj->content['section4_title'])) value="{{$obj->content['section4_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="content[section4_description]" class="form-control">@if($obj->content && isset($obj->content['section4_description'])) {{$obj->content['section4_description']}} @endif</textarea>
        </div> 
    </fieldset><!--end fieldset-->  
</div><!--end form-->