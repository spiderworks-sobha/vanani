<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{$common_settings['site_name']}}</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
   </head>
   <body>
      <div style="max-width:700px; margin:0px auto; position: relative; font-family: 'Roboto', sans-serif;  background-color: #f5f5f5;">
         <div>
            <div style="width:100%; text-align:center;">
               <img src="{{asset($common_settings['logo'])}}" style="width: auto;">
            </div>
            @section('content')
            @show
            <div style=" padding: 25px; margin: 30px 30px 0; background-color: #333; color: #fff; text-align: center; ">
               <div>
                  <a href="{{config('app.url')}}" style="display: inline-block; border: 1px dashed #fff; padding:5px 10px ; color:#fff; font-size: 14px;  text-decoration: none;">
                  {{$common_settings['site_name']}}
                  </a>
               </div>
               <div style="text-align: center; margin-top: 20px;">

                    @if(!empty($common_settings['facebook-link']))
                                       <a href="{{$common_settings['facebook-link']}}" target="_blank"><img src="{{asset('assets/client/img/Facebook.png')}}" alt=""></a>
                                    @endif
                                    @if(!empty($common_settings['intagram-link']))
                                       <a href="{{$common_settings['intagram-link']}}" target="_blank"><img src="{{asset('assets/client/img/Instagram.png')}}" alt=""></a>
                                    @endif
                                    @if(!empty($common_settings['youtube-link']))
                                       <a href="{{$common_settings['youtube-link']}}" target="_blank"><img src="{{asset('assets/client/img/Youtube.png')}}" alt=""></a>
                                    @endif
                                    @if(!empty($common_settings['linkedin-link']))
                                       <a href="{{$common_settings['linkedin-link']}}" target="_blank"><img src="{{asset('assets/client/img/Linkedin.png')}}" alt=""></a>
                                    @endif
                                    @if(!empty($common_settings['whatsapp_link']))
                                       <a href="{{$common_settings['whatsapp_link']}}" target="_blank"><img src="{{asset('assets/client/img/Whatsapp.png')}}" alt=""></a>
                                    @endif
                                    @if(!empty($common_settings['pinterest-link']))
                                       <a href="{{$common_settings['pinterest-link']}}" target="_blank"><img src="{{asset('assets/client/img/Pinterest.png')}}" alt=""></a>
                                    @endif
                                    @if(!empty($common_settings['twitter-link']))
                                       <a href="{{$common_settings['twitter-link']}}" target="_blank"><img src="{{asset('assets/client/img/twitter.png')}}" alt=""></a>
                                    @endif
               </div>
            </div>
         </div>
      </div>
   </body>
</html>