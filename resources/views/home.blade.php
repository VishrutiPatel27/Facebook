@extends('layout.master')
@section('content')
<style>
      ::-webkit-scrollbar {
  display: none;
}
</style>
<div class="container" style="float:left; padding-right:20%;">
    <div class="col-sm-3 offset-sm-3 row" style="float:left; width:150px;padding-top:15%;height: 80%;margin-right:30%;">

        <!-- left col element -->
        <p class="suggestion-text" style="position: fixed;"><b>Suggestions</b></p>
        <br><br>

        <div class="right-col-row"
            style="float:left; position: fixed; overflow-y: scroll; height: 80%; padding-top:40px ;width:200px; padding-left:20px;">

            @foreach($user as $key => $value)
            <div class="profile-card row">
                <div class="profile-pic" style="padding-right:10px; margin-top:10px;">
                    <img class="rounded-circle" alt="dp" src=" {{ asset('profile_pic/' . $value->image)}}" width="45">
                </div>

                <div>
                    <p class="username" style="padding-right:50px; margin-top:20px;">{{ $value->name }}</p>
                    <!-- <p class="sub-text">followed by user</p> -->
                </div>
                <form method="post" action="">
                    @csrf
                    <a href="{{url('/')}}/addFriend/{{$value->id}}" class="btn btn-info btn-sm">Add To Friend</a>
                </form>
            </div>
            @endforeach
        </div>



        <br> <br> <br>

        <div class="d-flex justify-content-center row"
            style="height:50px ; position:absolute ;z-index:-1;padding-left: 400px; width:250px !important;">



            <div class="col-md-5">



                <div class="feed p-2" style="float:left; width: 600px;">
                    <!-- @include('writeSomething') -->
                    <div class="posts">



                        @foreach($posts as $post)
                        @include('post',compact('post'))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-9 offset-sm-3 row" style="float:left; width:150px; padding-left:55%; height: 80%;">
    <p class="suggestion-text" style="position: fixed;"><b>Friends</b></p>
    <br><br>

    <div class="right-col"
        style="float:left;position: fixed; overflow:auto:scroll; height:80%; padding-top:40px ;width:190px !important;">

        @foreach($Friend as $key => $value)
        <div class="profile-card row">
            <div class="profile-pic" style="padding-right:10px;">
                <img class="rounded-circle" alt="dp" src=" {{ asset('profile_pic/' . $value->image)}}" width="45">
            </div>

            <div>
                <span class="username" style="padding-right:20px; margin-top:30px;">{{ $value->name }}</span>
                <!-- <p class="sub-text">followed by user</p> -->

                <span style="float:right">
                    <form method="post" action="{{ route('friends.unfriend', $value->id) }}">
                        @csrf
                        <input type="submit" value="Unfriend" class="btn btn-danger btn-sm">
                    </form>
                </span>
            </div>

        </div>
        @endforeach
    </div>
</div>
@endsection