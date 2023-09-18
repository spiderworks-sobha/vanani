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
                                        @if($obj->id)
                                            <h4 class="page-title">Edit Menu</h4>
                                        @else
                                            <h4 class="page-title">Create new Menu</h4>
                                        @endif
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route($route.'.index') }}">All Menus</a></li>
                                            <li class="breadcrumb-item active">@if($obj->id)Edit @else Create new @endif Menu</li>
                                        </ol>
                                    </div><!--end col-->
                                    @if(auth()->user()->can($permissions['create']))
                                    <div class="col-auto align-self-center">
                                        <a class=" btn btn-sm btn-primary" href="{{route($route.'.create')}}" role="button"><i class="fas fa-plus mr-2"></i>Create New</a>
                                    </div>
                                    @endif
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin._partials.notifications')
                            <div class="card">
                                <div class="card-body">
                                    @if($obj->id)
                                        <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="MenuFrm" data-validate=true>
                                    @else
                                        <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="MenuFrm" data-validate=true>
                                    @endif
                                    @csrf
                                    <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-6">
                                                                    <label for="name">Menu Name</label>
                                                                    <input type="text" class="form-control" id="name" name="name" value="{{$obj->name}}">
                                                                    <span class="error"></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="email">Position</label>
                                                                    <select id="position" class="form-control webadmin-select2-input" name="position">
                                                                        @php
                                                                            $postions = Config('admin.menu.positions');
                                                                        @endphp
                                                                        @foreach($postions as $position)
                                                                            <option value="{{$position}}" @if($obj->position == $position) selected="selected" @endif>{{$position}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="password">Menu Title</label>
                                                                    <input type="text" class="form-control" id="title" name="title" value="{{$obj->title}}">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-5"> 
                                              <div class="custom-accordion" style="background-color: #fff !important">
                                                @php
                                                    $menu = Config('admin.menu.items');
                                                    $i = 0;
                                                @endphp
                                                @foreach($menu as $item)
                                                    @if(method_exists($item['model'], 'create_admin_menu'))
                                                        @php
                                                            $model = new $item['model'];
                                                            $i++;
                                                        @endphp
                                                        <div class="accord-header">{{$item['title']}}<span class="float-right fa fa-angle-down toggle-arraow"></span></div>
                                                        <div class="accord-content @if($i == 1) accord-on @endif">
                                                          @if($list = $model->create_admin_menu())
                                                              {!! $list !!}
                                                            <p class="text-right">
                                                              <button type="button" class="btn btn-primary btn-sm add-links" data-identifier="{{$item['identifier']}}">Add to Menu</button>
                                                            </p>
                                                          @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="accord-header">Custom Links<span class="float-right fa fa-angle-down toggle-arraow"></span></div>
                                                <div class="accord-content">
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Link Text</label>
                                                    <input type="text" name="custom_link_text" class="form-control" id="inputCustomLinkText">
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Image Link</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{asset('/')}}</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="custom_link_image_url" id="inputCustomLinkImageUrl">
                                                        <a href="{{route('admin.media.popup', ['popup_type'=>'set_url', 'type'=>'Image', 'holder_attr'=>'inputCustomLinkImageUrl', 'title'=>'Image Link', 'related_id'=>''])}}" class="webadmin-open-ajax-popup w-100 text-right" title="Media Images" data-popup-size="xlarge">Get from media</a>
                                                    </div>
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Icon Class</label>
                                                    <input type="text" name="custom_link_icon" class="form-control" id="inputCustomIcon">
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Url</label>
                                                    <input type="text" name="custom_url" class="form-control" id="inputCustomUrl">
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <div class="checkbox">
                                                      <input type="checkbox" id="inputTarget"><label for="inputTarget"> New Window</label>
                                                    </div>
                                                  </div>
                                                  <div class="form-group mb-2">
                                                      <button type="button" id="add-custom-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                                  </div>
                                                </div>
                                              </div> 
                                            </div>
                                            <div class="col-md-7">
                                              <div class="dd">
                                                  <ol class="dd-list custom-accordion-menu">
                                                    @if($obj->id && $obj->menu_items)
                                                      @include('admin._partials.menu_items', ['items'=>$obj->menu_items])
                                                    @endif
                                                  </ol>
                                              </div>
                                              <input type="hidden" name="menu_settings" id="inputMenuSettings">
                                              <span class="error"></span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <a href="{{ route($route.'.index') }}" class="btn btn-soft-primary">Back to List</a>
                                                <button type="button" id="save-btn" class="btn btn-primary px-4">Submit</button>
                                            </div>
                                        </div>
                                    </form>                                                                   
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->

                </div><!-- container -->

                @include('admin._partials.footer')
            </div>
            <!-- end page content -->
@endsection
@section('footer')
    <script src="{{ asset('admin/assets/js/jquery.nestable.js')}}"></script> 
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dd').nestable({ 
                expandBtnHTML: '',
                collapseBtnHTML: ''
              });
            var validator = $("#MenuFrm").validate({
                ignore: [],
                errorPlacement: function(error, element){
                    $(element).each(function (){
                        $(this).parent('div').find('span.error').html(error);
                    });
                },
                rules: {
                  name: "required",
                  menu_settings: "required",
                },
                messages: {
                  name: "Enter menu name",
                  menu_settings: "Setup a menu using menu settings",
                },
              });

            $(document).on('click', '#save-btn', function(){
              if($('.dd').nestable('serialize') != '')
                $('#inputMenuSettings').val(JSON.stringify($('.dd').nestable('serialize')));
              if($("#MenuFrm").valid())
              {
                $('#MenuFrm').submit();
              }
            })

            $(document).on('click', '#add-custom-links', function(){
                var name = $('#inputCustomLinkText').val();
                var url = $('#inputCustomUrl').val();
                var url = $('#inputCustomUrl').val();
                var image_url = $('#inputCustomLinkImageUrl').val();
                var icon = $('#inputCustomIcon').val();
                if(name != '' && url != '')
                {
                    $('#inputCustomLinkText').removeClass('errorBox');
                    $('#inputCustomUrl').removeClass('errorBox');
                    var id = 'custom_link-'+name;
                    var target_blank = 0;
                    var checked = "";
                    if($("#inputTarget").is(":checked"))
                    {
                      target_blank = 1
                      checked = "checked";
                    }
                    var popup_url = "{{route('admin.media.popup')}}/set_url/Image/inputCustomLinkImageUrl"+id;

                    var asset_link = "{{asset('/')}}";
                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="float-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group mb-2"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/></div><div class="form-group mb-2"><label for="exampleInputPassword1">Image Link</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'+asset_link+'</span></div><input type="text" class="form-control" name="menu['+id+'][image_url]" value="'+image_url+'" id="inputCustomLinkImageUrl'+id+'"><a href="'+popup_url+'" class="webadmin-open-ajax-popup w-100 text-right" title="Media Images" data-popup-size="xlarge">Get from media</a></div></div><div class="form-group mb-2"><label for="exampleInputPassword1">Icon class</label><input type="text" name="menu['+id+'][icon]" class="form-control" value="'+icon+'"></div><div class="form-group mb-2"><label class="control-label" for="inputCode">Url</label><input type="text" name="menu['+id+'][url]" class="form-control" value="'+url+'"/></div><div class="form-group mb-2"><div class="checkbox"><input type="checkbox" name="menu['+id+'][target_blank]" '+checked+' id="target-'+id+'"/><label for="target-'+id+'"> New Window</label></div></div><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/><input type="hidden" name="menu['+id+'][original_title]" value="'+name+'"/><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('.dd').nestable();
                    $('#inputCustomLinkText').val('');
                    $('#inputCustomUrl').val('');
                }
                else{
                  if(name == "")
                    $('#inputCustomLinkText').addClass('errorBox');
                  else
                    $('#inputCustomLinkText').removeClass('errorBox');

                  if(url == "")
                    $('#inputCustomUrl').addClass('errorBox');
                  else
                    $('#inputCustomUrl').removeClass('errorBox');
                }
            });

            $(document).on('click', '.add-links', function(){
                var identifier = $(this).data('identifier');
                var link_class = identifier+'_links';
                var asset_link = "{{asset('/')}}";


                $("."+link_class+":checked").each(function () {
                    var id = $(this).val();
                    var name = $(this).attr('data-name');
                    var popup_url = "{{route('admin.media.popup')}}/set_url/Image/inputCustomLinkImageUrl"+id;

                   
                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="float-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/><input type="hidden" name="menu['+id+'][id]" value="'+$(this).attr('data-id')+'"/><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/></div><p class="menu-original-text"> Original: '+name+'</p><div class="form-group mb-2"><label for="exampleInputPassword1">Image Link</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'+asset_link+'</span></div><input type="text" class="form-control" name="menu['+id+'][image_url]"  id="inputCustomLinkImageUrl'+id+'"><a href="'+popup_url+'" class="webadmin-open-ajax-popup w-100 text-right" title="Media Images" data-popup-size="xlarge">Get from media</a></div></div><div class="form-group mb-2"><label for="exampleInputPassword1">Icon Class</label><input type="text" name="menu['+id+'][icon]" class="form-control"></div><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('.dd').nestable();
                    $(this).prop('checked', false);
                });
            });

            $(document).on('click', '.custom-accordion .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.custom-accordion-menu .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion-menu .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.remove-menu', function(){
              $(this).parents('.accord-content').parent().remove();
              $('.dd').nestable();
            });

            $(document).on('keyup', '.menu-title-input', function(){
              $(this).parents('.accord-content').siblings('.accord-header').find('.menu-title').html($(this).val());
            })
        
          });
    </script>
@parent
@endsection