@foreach($files as $key=>$file)
                                  @include('admin.media.file_single', ['file'=>$file])
                                  @if(($key+1)%4 == 0)
                                  <div class="clearfix"></div>
                                  @endif
                                @endforeach
                                <div class="col-md-12 media-popup-nav text-right">
                                  <input type="hidden" id="currentPage" value="{{$page}}">
                                  {{ $files->appends(['req' => $req])->links('vendor.pagination.bootstrap-4') }}
                                </div>