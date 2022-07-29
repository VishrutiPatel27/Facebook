<div class="row" style="padding: 70px 0px 10px 0px">
    <div class="card bg-dark text-white col-sm-5" style="margin-top:10px; margin-bottom:55px;">
        <img class="card-img" src=" {{ asset('profile_pic/' . $user->image)}}" alt="Card image" >
        <div class="card-img-overlay">
            <!-- <h4 class="card-title text-center" style="font-weight: 800;text-shadow: 0 0 5px rgba(0,0,0,0.5);">
                {{$user->name}}
            </h4> -->
        </div>
    </div>
    
    <div class="col-sm-7" style="padding-top: 10px">
        <ul class="list-group">
            <li class="list-group-item">
                Name : {{$user->name}}
            </li>
            <li class="list-group-item">
                Email : {{$user->email}}
            </li>
            <li class="list-group-item">
                Age : {{$user->age}}
            </li>
            <li class="list-group-item">
                Gender : {{$user->gender}}
            </li>
        </ul>
        <a type="submit" value="Edit" class="btn btn-info" href="{{ route('editprofile',$user->id) }}"style="margin: 10px 0px">Edit</a>
    </div>
</div>
