<nav class="navbar navbar-expand-lg navbar-light bg-light"
    style="background-color: #4267B2!important;position: fixed;width: 100%;z-index:1 !important">
    <a class="navbar-brand" href="/">
        <img src="https://cdn.worldvectorlogo.com/logos/facebook-3-2.svg" width="30" height="30"
            class="d-inline-block align-top" alt="">
        <span style="color:white;">facebook</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(auth()->user())
            <li class="nav-item active">
                <a class="nav-link" href="profile" style="color:white;">Profile</a>              
            </li>
            
            <li>
                <a class="nav-link" href="/requests" style="color:white;">Friends</a>
            </li>
            @endif
        </ul>
        @auth
                <div class="profile-pic" style="padding-right:8px; margin-top:3px;">
                    <img class="rounded-circle" alt="dp" src=" {{asset('profile_pic/'. Auth::user()->image)}}" width="35">
                        {{Auth::user()->name}}
                </div>
        <a href="logout" class="my-2 my-lg-0 nav-item loginBTN" style="color:white;">Logout</a>
        
        @else
        <a href="register" class="my-2 my-lg-0 nav-item registerBTN" style="color:white;">Register</a> |
        <a href="login" class="my-2 my-lg-0 nav-item loginBTN" style="color:white;">Login</a>
        @endauth
    </div>
</nav>