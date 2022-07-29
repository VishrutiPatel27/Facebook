@extends('layout.master')
@section('content')

<div class="container" style="padding-top:5%;">
    <div class="col-sm-6 offset-sm-3 row justify-content-center bg-white">


        <form action="{{ route('updateprofile', Auth::user()->id ) }}" method="POST" enctype="multipart/form-data">
            @csrf
         

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control"
                            placeholder="name">
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Age:</strong>
                        <input type="text" name="age" value="{{Auth::user()->age }}" class="form-control" placeholder="age">
                        @if ($errors->has('age'))
                        <span class="text-danger">{{ $errors->first('age') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Phone:</strong>
                        <input type="text" name="phone" value="{{ Auth::user()->phone}}" class="form-control"
                            placeholder="phone">
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gender:</strong>
                        <input type="text" name="gender" value="{{ Auth::user()->gender }}" class="form-control"
                            placeholder="gender">
                        @if ($errors->has('gender'))
                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control"
                            placeholder="email">
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Select Image:</strong>
                        <input type="file" name="image" class="form-control">
                        <span class="text-danger" id="imageval"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection