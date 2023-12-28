@extends('email._layouts.base')

@section('content')
<h1>Greenpire Contact Request</h1>

    <p>You have received a contact request. Please check below link for more details. 👍</p>
    @php
        $extra_data = json_decode($data->extra_data);
    @endphp
    <table class="email-table">
        <thead >
            
            <tr> <td>Name:</td><td > {{$data->name}}</td> </tr>               
            <tr> <td>Phone:</td><td > {{$data->phone_number}}</td> </tr>
            @if($data->message)             
            <tr> <td>Message:</td><td > {{$data->message}}</td> </tr> 
            @endif
            @if($data->location)             
            <tr> <td>Location:</td><td > {{$data->location}}</td> </tr> 
            @endif  

        </thead>
        
                
    </table>

@endsection