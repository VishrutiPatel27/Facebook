@extends('layout.master')
@section('content')


<div class="center" style="width:800px; margin:0 auto; height:80%; padding-top:100px ;width:190px !important;">

    @foreach($FriendRequests as $value)
    <div class="profile-card row">
        <div class="profile-pic" style="padding-right:20px; margin-top:10px;">
            <img class="rounded-circle" alt="dp" src=" {{ asset('profile_pic/' . $value->image)}}" width="45">
        </div>

        <div class="row">
            <p class="username" style="padding-right:60px; margin-top:20px;">{{ $value->name }}</p>
            <!-- <p class="sub-text">followed by user</p> -->
        </div>
        <form method="get" action="{{route('profile.accept',$value->id) }}" style="margin-top:10px; margin-right:25px;">
            @csrf
            <input type="submit" value="Accept" class="btn btn-info btn-sm">

           
        </form>
        <form method="post" action="{{ route('friends.remove', $value->id) }}" style="margin-top:10px;margin-right:20px;">              
              @csrf
         
                <input type="submit" value="Reject" class="btn btn-info btn-sm">
            </form>
    </div>
    @endforeach
</div>
@endsection

