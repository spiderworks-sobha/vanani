@extends('admin._layouts.fileupload')

@section('content')
<!-- Top Bar Start -->
            <div class="topbar">            
                <!-- Navbar -->
                <nav class="navbar-custom">    
                    @include('admin._partials.profile_menu')
        
                    <ul class="list-unstyled topbar-nav mb-0">                        
                        <li>
                            <button class="nav-link button-menu-mobile">
                                <i data-feather="menu" class="align-self-center topbar-icon"></i>
                            </button>
                        </li>                           
                    </ul>
                </nav>
                <!-- end navbar-->
            </div>
            <!-- Top Bar End -->

            <!-- Page Content-->
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        
                                        <h4 class="page-title">Media Files</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item active">Media Files</li>
                                        </ol>
                                    </div><!--end col-->
                                    
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    
                    <div class="row">
                      @if(auth()->user()->can($permissions['create']))
                        <div class="card card-borderless padding-15 w-100">
                    <!-- Default box -->
                          <div class="box">
                            <div class="box-body with-border">
                              <div class="upload-wrapper">
                                <div id="error_output"></div>
                                    <!-- file drop zone -->
                                <div id="dropzone" class="dropzone-wrapper">
                                        <i>Drop files here</i>
                                        <i class="sm-text">or</i>
                                        <!-- upload button -->
                                        <span class="button btn-soft-primary input-file">
                                            Browse Files <input type="file" id="fileupload" name="files[]" data-url="{{ route('admin.media.save')}}" multiple />
                                        </span>
                                </div>
                                <input type="hidden" id="popupType" value="main">
                                    <!-- The container for the uploaded files -->
                              </div>
                            </div>
             
                          </div><!-- /.box -->
                        </div>
                      @endif
                        <div class="card card-borderless padding-15 w-100" {{-- @if(count($files)==0) style="display:none;" @endif --}}>
                          <div class="box">
                            <div class="box-body m-4">
                                <div id="files" class="files col-md-12"></div>
                                
                                <div class="media-list-head row">
                                  <div class="col-md-6">
                                    @if(auth()->user()->can($permissions['delete']))
                                      <a href="javascript:void(0);" class="btn btn-danger bulk-select">Bulk Select</a>
                                      <div class="bulk-delete-action" style="display: none;">
                                        <a href="javascript:void(0);" class="btn btn-danger bulk-select-delete">Delete Selected</a>
                                        <a href="javascript:void(0);" class="btn btn-default bulk-select-cancel">Cancel</a>
                                      </div>
                                    @endif
                                  </div>
                                  <div class="col-md-6 text-right row">
                                      <div class="col-md-6">
                                        <label>
                                          <select class="form-control input-sm" id="mediaSort">
                                            <option value="">Sort By</option>
                                            <option value="SHL">Size (High to Low)</option>
                                            <option value="SLH">Size (Low to High)</option>
                                          </select>
                                        </label>
                                      </div>
                                      <div class="col-md-6">
                                        <label>
                                          <input class="form-control input-sm" placeholder="Search..." aria-controls="datatable" type="search" id="mediaSearchInput">
                                        </label>
                                      </div>
                                  </div>
                                </div>
                                
                                <div class="row" id="mediaList">
                                  @include('admin.media.ajax_index', ['files'=>$files])
                                </div>
                            </div><!-- /.box-body -->
                          </div>
                      </div>
                    </div><!--end row-->

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')
    <script>
      var my_columns = [];
      var slno_i = 0;
      var order = [];

      $(function(){

        

        $(document).on('click', '.media-nav .pagination .page-link', function(e){
              e.preventDefault();
              var loadurl = $(this).attr('href');
              var targ = $('#mediaList');
              if(loadurl != 'undefined'){
                  targ.load(loadurl, function(){
                    $('#ajaxUrl').val(loadurl);
                    $('.bulk-select-delete').parent().hide();
                    $('.bulk-select').show();
                  });
              }
          });

        $(document).on('click', '#extra-data-submit-btn', function(){

          $(this).prop('disabled', true).text('Processing...');
          var url = $('#mediaExtraFrm').attr('action');
          var data = $('#mediaExtraFrm').serialize();
          $.post(url, data, function(result){
              if(result.success)
                {
                    var id = result.id;
                    var view_html = result.view_html;
                    var item_html = result.list_html;
                    $('#media-item-edit').html(view_html);
                    update_media();
                    if($('#media-item-list-'+id).length)
                    {
                        $('#media-item-list-'+id).replaceWith(item_html);
                    }
                }
                else{
                    $.alert('Oops, something wrong happend. Please check your file.');
                }
          })
        })

          $(document).on('keyup', '#mediaSearchInput', function(e){
            var req = $(this).val();
            var sort = $('#mediaSort').val();
            var loadurl = "{{route('admin.media.index')}}";
            $.ajax({
               url: loadurl,
               data: {req: req, sort: sort}, // serializes the form's elements.
               success: function(data)
               {
                  $('#mediaList').html(data);
                  $('.bulk-select-delete').parent().hide();
                  $('.bulk-select').show();
               }
             });
          });

          $(document).on('change', '#mediaSort', function(e){
            var sort = $(this).val();
            var req = $('#mediaSearchInput').val();
            var loadurl = "{{route('admin.media.index')}}";
            $.ajax({
               url: loadurl,
               data: {sort: sort, req: req}, // serializes the form's elements.
               success: function(data)
               {
                  $('#mediaList').html(data);
                  $('.bulk-select-delete').parent().hide();
                  $('.bulk-select').show();
               }
             });
          });

          $(document).on('click', '.media-delete', function(e){
              e.preventDefault();
              var id = $(this).attr('data-id');
              var req = $('#mediaSearchInput').val();
              var page = $('#currentPage').val();
              var loadurl = "{{route('admin.media.destroy')}}";
              $.confirm({
                title: 'Warning',
                content: "Are you sure?",
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'ok_button': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            var obj = this;
                            obj.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                            obj.buttons.ok_button.disable();
                            $.post(loadurl, {req: req, page: page, id: id, action: 'delete', '_token':'{{csrf_token()}}' }).done(function(data){
                              obj.$$close_button.trigger('click');
                              $('#mediaList').html(data);
                              $('.bulk-select-delete').parent().hide();
                              $('.bulk-select').show();
                            });
                            return false;
                        }
                    },
                    close_button: {
                          text: 'Cancel',
                          action: function () {
                        }
                    },
                }
            });
          });

          $(document).on('click', '.bulk-select', function(){
              $('.parent .bulk-selet-media').each(function(){
                $(this).show();
                $(this).siblings('.media-delete').hide();
              });
              $(this).hide();
              $('.bulk-delete-action').show();
          });

          $(document).on('click', '.bulk-select-cancel', function(){
              $('.parent .bulk-selet-media').each(function(){
                $(this).hide();
                $(this).siblings('.media-delete').show();
              });
              $(this).parent().hide();
              $('.bulk-select').show();
          });

          $(document).on('click', '.bulk-select-delete', function(){
              var req = $('#mediaSearchInput').val();
              var page = $('#currentPage').val();
              var loadurl = "{{route($route.'.destroy')}}";
              var ids = [];
              $("input:checked").each(function () {
                  var id = $(this).val();
                  ids.push(id);
              });
              if(ids != '')
              {

                $.confirm({
                    title: 'Warning',
                    content: "Are you sure?",
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'ok_button': {
                            text: 'Proceed',
                            btnClass: 'btn-blue',
                            action: function(){
                                var obj = this;
                                obj.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                                obj.buttons.ok_button.disable();
                                $.post(loadurl, {req: req, page: page, ids: ids, action: 'bulk_delete', '_token':'{{csrf_token()}}' }).done(function(data){
                                  obj.$$close_button.trigger('click');
                                  $('#mediaList').html(data);
                                  $('.bulk-select-delete').parent().hide();
                                  $('.bulk-select').show();
                                });
                                return false;
                            }
                        },
                        close_button: {
                              text: 'Cancel',
                              action: function () {
                            }
                        },
                    }
                });
              }
              else{
                $.alert("Select an item to delete");
              }
          });
    });
    </script>
@parent
@endsection