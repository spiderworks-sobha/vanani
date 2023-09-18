<form method="POST" action="{{ route('admin.photo-galleries.update-photo') }}" class="p-t-15" id="sliderModalFrm" data-validate=true>
                  @csrf

<input type="hidden" name="type" value="{{$type}}">
<input type="hidden" name="id" value="{{encrypt($photo->id)}}">

<div class="row box w-100 m-0">

	<div class="box-body m-0">

    <div class="row m-0">
        <div class="form-group col-md-12">

          <label class="control-label" for="inputLabelEn">Title</label>
          <input type="text" name="title" class="form-control" value="{{$photo->title}}" id="titleInput" >
        </div>
    </div>

    <div class="form-group required row nopadding">

      <div class="col-md-9 nopadding img-container-edit">

        <img src="{{ asset('public/'.$photo->media->file_path) }}">

      </div>

      <div class="col-md-3 img-details-edit">

        <div class="img-details ml-3">

          <p><label>File Name: </label> {{$photo->media->file_name}}</p>
          <p><label>Last Updated On: </label> <?php echo date('d M, Y h:i A', strtotime($photo->media->updated_at));?></p>
          <p><label>File Size: </label> {{BladeHelper::formatBytes($photo->media->file_size)}} </p>
          <p><label>File Type: </label> {{$photo->media->file_type}}</p>
          <p><label>File Dimensions: </label> {{$photo->media->dimensions}}</p>

        </div>

  </div>

    </div>

    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Alt Text</label>

      <input type="text" name="alt_text" class="form-control" value="{{$photo->alt_text}}" id="altInput" >

    </div>

    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Description</label>
      <textarea name="description" class="form-control richtext" id="bottom_description" >{{$photo->description}}</textarea>

    </div>


    <div class="form-group col-md-12 pull-right">

            <button type="submit" class="btn btn-primary">Save</button>

    </div>

  </div>

</div>

</form>