<div id="form-vertical" class="form-horizontal form-wizard-wrapper">
    <h3>Section 1</h3>
    <fieldset class="row">                                                                               
        <div class="form-group col-md-6">
            <label>Tag Line</label>
            <input type="text" name="content[section1_tagline]" class="form-control" @if($obj->content && isset($obj->content['section1_tagline'])) value="{{$obj->content['section1_tagline']}}" @endif >
        </div>
        <div class="form-group col-md-6">
            <label>Title</label>
            <input type="text" name="content[section1_title]" class="form-control" @if($obj->content && isset($obj->content['section1_title'])) value="{{$obj->content['section1_title']}}" @endif >
        </div>
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="content[section1_description]" class="form-control">@if($obj->content && isset($obj->content['section1_description'])) {{$obj->content['section1_description']}} @endif</textarea>
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
</div><!--end form-->