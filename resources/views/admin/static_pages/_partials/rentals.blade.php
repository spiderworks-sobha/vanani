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
            <label>Banner Link Url</label>
            <input type="text" name="content[section1_banner_link_url]" class="form-control" @if($obj->content && isset($obj->content['section1_banner_link_url'])) value="{{$obj->content['section1_banner_link_url']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Bottom Link Target</label>
            <select name="content[section1_banner_link_target]" class="form-control" id="inputStatus">
                <option value="" @if($obj->content && isset($obj->content['section1_banner_link_target']) && $obj->content['section1_banner_link_target'] == "") selected="selected" @endif></option>
                <option value="_blank" @if($obj->content && isset($obj->content['section1_banner_link_target']) && $obj->content['section1_banner_link_target'] == "_blank") selected="selected" @endif>_blank</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label>Right Bottom Listing Title</label>
            <input type="text" name="content[section1_right_bottom_listing_title]" class="form-control" @if($obj->content && isset($obj->content['section1_right_bottom_listing_title'])) value="{{$obj->content['section1_right_bottom_listing_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>List 1</label>
            @if($obj->content && isset($obj->content['section1_right_bottom_listing_id']))
                <br/>
                <input type="hidden" name="content[section1_right_bottom_listing_id]" value="{{$obj->content['section1_right_bottom_listing_id']->id}}" />
                <a href="{{url('sw-admin/listing-items', [$obj->content['section1_right_bottom_listing_id']->id])}}" class="btn btn-sm btn-success" target="_blank">Update Listing</a>
            @else
                <select name="content[section1_right_bottom_listing_id]" class="w-100 webadmin-select2-input form-control" data-select2-url="{{route('admin.select2.list')}}">
                </select>
            @endif
        </div>
        <div class="form-group col-md-12">
            <label>Offer Title</label>
            <input type="text" name="content[section1_offer_title]" class="form-control" @if($obj->content && isset($obj->content['section1_offer_title'])) value="{{$obj->content['section1_offer_title']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Button Text</label>
            <input type="text" name="content[section1_offer_button_text]" class="form-control" @if($obj->content && isset($obj->content['section1_offer_button_text'])) value="{{$obj->content['section1_offer_button_text']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Link Url</label>
            <input type="text" name="content[section1_offer_link_url]" class="form-control" @if($obj->content && isset($obj->content['section1_offer_link_url'])) value="{{$obj->content['section1_offer_link_url']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Link Target</label>
            <select name="content[section1_offer_link_target]" class="form-control" >
                <option value="" @if($obj->content && isset($obj->content['section1_offer_link_target']) && $obj->content['section1_offer_link_target'] == "") selected="selected" @endif></option>
                <option value="_blank" @if($obj->content && isset($obj->content['section1_offer_link_target']) && $obj->content['section1_offer_link_target'] == "_blank") selected="selected" @endif>_blank</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Listing Tag Line</label>
            <input type="text" name="content[section1_listing_tag_line]" class="form-control" @if($obj->content && isset($obj->content['section1_listing_tag_line'])) value="{{$obj->content['section1_listing_tag_line']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Listing Title</label>
            <input type="text" name="content[section1_listing_title]" class="form-control" @if($obj->content && isset($obj->content['section1_listing_title'])) value="{{$obj->content['section1_listing_title']}}" @endif >
        </div>                     
    </fieldset><!--end fieldset--> 
    <h3>Section 2</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-12">
            <label>Review Listing Title</label>
            <input type="text" name="content[section2_review_listing_title]" class="form-control" @if($obj->content && isset($obj->content['section2_review_listing_title'])) value="{{$obj->content['section2_review_listing_title']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Offer Tag Line</label>
            <input type="text" name="content[section2_offer_tag_line]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_tag_line'])) value="{{$obj->content['section2_offer_tag_line']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Offer Title</label>
            <input type="text" name="content[section2_offer_title]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_title'])) value="{{$obj->content['section2_offer_title']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Button Text</label>
            <input type="text" name="content[section2_offer_button_text]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_button_text'])) value="{{$obj->content['section2_offer_button_text']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Link Url</label>
            <input type="text" name="content[section2_offer_link_url]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_link_url'])) value="{{$obj->content['section2_offer_link_url']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Link Target</label>
            <select name="content[section2_offer_link_target]" class="form-control" >
                <option value="" @if($obj->content && isset($obj->content['section2_offer_link_target']) && $obj->content['section2_offer_link_target'] == "") selected="selected" @endif></option>
                <option value="_blank" @if($obj->content && isset($obj->content['section2_offer_link_target']) && $obj->content['section2_offer_link_target'] == "_blank") selected="selected" @endif>_blank</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label>Offer Bottom Text</label>
            <input type="text" name="content[section2_offer_bottom_text]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_bottom_text'])) value="{{$obj->content['section2_offer_bottom_text']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Bottom Button Text</label>
            <input type="text" name="content[section2_offer_bottom_button_text]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_bottom_button_text'])) value="{{$obj->content['section2_offer_bottom_button_text']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Bottom Link Url</label>
            <input type="text" name="content[section2_offer_bottom_link_url]" class="form-control" @if($obj->content && isset($obj->content['section2_offer_bottom_link_url'])) value="{{$obj->content['section2_offer_bottom_link_url']}}" @endif >
        </div>
        <div class="form-group col-md-4">
            <label>Offer Bottom Link Target</label>
            <select name="content[section2_offer_bottom_link_target]" class="form-control" >
                <option value="" @if($obj->content && isset($obj->content['section2_offer_bottom_link_target']) && $obj->content['section2_offer_bottom_link_target'] == "") selected="selected" @endif></option>
                <option value="_blank" @if($obj->content && isset($obj->content['section2_offer_bottom_link_target']) && $obj->content['section2_offer_bottom_link_target'] == "_blank") selected="selected" @endif>_blank</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Package Listing Tag Line</label>
            <input type="text" name="content[section2_package_listing_tag_line]" class="form-control" @if($obj->content && isset($obj->content['section2_package_listing_tag_line'])) value="{{$obj->content['section2_package_listing_tag_line']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Package Listing Title</label>
            <input type="text" name="content[section2_package_listing_title]" class="form-control" @if($obj->content && isset($obj->content['section2_package_listing_title'])) value="{{$obj->content['section2_package_listing_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Bottom Content (Right)</label>
            <textarea name="content[section2_bottom_content_right]" class="form-control editor">@if($obj->content && isset($obj->content['section2_bottom_content_right'])) {{$obj->content['section2_bottom_content_right']}} @endif</textarea>
        </div>
        <div class="form-group col-md-12">
            <label>Bottom Content (Left)</label>
            <textarea name="content[section2_bottom_content_left]" class="form-control editor">@if($obj->content && isset($obj->content['section2_bottom_content_left'])) {{$obj->content['section2_bottom_content_left']}} @endif</textarea>
        </div>                
    </fieldset><!--end fieldset-->                                        
                     
</div><!--end form-->