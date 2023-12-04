<div id="form-vertical" class="form-horizontal form-wizard-wrapper">
    <h3>Section 1</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-6">
            <label>Tag Line (Left)</label>
            <input type="text" name="content[section1_tag_line_left]" class="form-control" @if($obj->content && isset($obj->content['section1_tag_line_left'])) value="{{$obj->content['section1_tag_line_left']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Title (Left)</label>
            <input type="text" name="content[section1_title_left]" class="form-control" @if($obj->content && isset($obj->content['section1_title_left'])) value="{{$obj->content['section1_title_left']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Tagline (Right)</label>
            <input type="text" name="content[section1_tag_line_right]" class="form-control" @if($obj->content && isset($obj->content['section1_tag_line_right'])) value="{{$obj->content['section1_tag_line_right']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Title (Right)</label>
            <input type="text" name="content[section1_title_right]" class="form-control" @if($obj->content && isset($obj->content['section1_title_right'])) value="{{$obj->content['section1_title_right']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            @php
                $section1_banner_media_id = ($obj->content && isset($obj->content['section1_banner_media_id']))?$obj->content['section1_banner_media_id']:null;
            @endphp
            @include('admin.media.set_file', ['file'=>$section1_banner_media_id, 'title'=>'Banner Image', 'popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'content[section1_banner_media_id]', 'id'=>'section1_banner_media_id', 'display'=> 'horizontal'])                                             
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
            <label>Tag Line</label>
            <input type="text" name="content[section3_tagline]" class="form-control" @if($obj->content && isset($obj->content['section3_tagline'])) value="{{$obj->content['section3_tagline']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section3_title]" class="form-control" @if($obj->content && isset($obj->content['section3_title'])) value="{{$obj->content['section3_title']}}" @endif >
        </div>              
    </fieldset><!--end fieldset-->    
    <h3>Section 4</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Tag Line</label>
            <input type="text" name="content[section4_tagline]" class="form-control" @if($obj->content && isset($obj->content['section4_tagline'])) value="{{$obj->content['section4_tagline']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Title</label>
            <input type="text" name="content[section4_title]" class="form-control" @if($obj->content && isset($obj->content['section4_title'])) value="{{$obj->content['section4_title']}}" @endif >
        </div>              
    </fieldset><!--end fieldset-->                
</div><!--end form-->