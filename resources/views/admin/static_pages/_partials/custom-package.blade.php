<div id="form-vertical" class="form-horizontal form-wizard-wrapper">
    <h3>Section 1</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
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
    </fieldset><!--end fieldset-->
    <h3>Section 3</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section3_title]" class="form-control" @if($obj->content && isset($obj->content['section3_title'])) value="{{$obj->content['section3_title']}}" @endif >
        </div>    
    </fieldset><!--end fieldset-->                            
    <h3>Section 4</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Title 1</label>
            <input type="text" name="content[section4_title1]" class="form-control" @if($obj->content && isset($obj->content['section4_title1'])) value="{{$obj->content['section4_title1']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Title 2</label>
            <input type="text" name="content[section4_title2]" class="form-control" @if($obj->content && isset($obj->content['section4_title2'])) value="{{$obj->content['section4_title2']}}" @endif >
        </div>    
    </fieldset><!--end fieldset-->
    <h3>Section 5</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section5_title]" class="form-control" @if($obj->content && isset($obj->content['section5_title'])) value="{{$obj->content['section5_title']}}" @endif >
        </div>    
    </fieldset><!--end fieldset-->       
</div><!--end form-->