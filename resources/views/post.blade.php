<div class="card" style="width: 100%" data-post="{{$post->id}}">
    <div class="card-header">
        <a href="{{auth()->check() && $post->user_id == auth()->id() ? 'profile' : 'profile/'.$post->user_id}}">
            <img width="50" height="50" src="{{asset('profile_pic/'. $post->user->image)}} " alt="">
            {{$post->user->name}}
        </a>
        @if(auth()->user()->id == $post->user->id)
        <div style="float:right;padding-top:5px">

            <form method="post" action="{{ route('friends.postdel',$post->id) }}">
                @csrf
                <input type="submit" value="Delete" class="btn btn-danger btn-sm">
            </form>

        </div>
        @endif
    </div>
    @if($post->image)
    <img class="card-img-top" src=" {{ asset('post_pic/' . $post->image)}}" alt="Card image cap">
    @endif
    <div class="card-body">
        <blockquote class="blockquote mb-0">
            <p>
                {{$post->text}}
            </p>
            <footer class="blockquote-footer">
                <span>
                    {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}
                </span>
                @auth
                <i
                    class="fas fa-thumbs-up pressLove {{$post->likes->contains('user_id',auth()->id()) ? 'redHeart' : ''}} float-right">{{$post->likes->count()}}</i>
                @else
                <i class="fas fa-thumbs-up pressLove float-right">{{$post->likes->count()}}</i>
                @endauth
            </footer>
        </blockquote>
    </div>
    <div class="card-footer">
        <div class="comments">
            @foreach($post->comments as $comment)
            @include('comment',compact('comment'))
            @endforeach
        </div>
        <div class="form-group" data-id="{{$post->id}}">
            <textarea name="comment" id="commentText" class="form-control" rows="3"></textarea>
            <input type="button" value="Comment" class="btn btn-success float-right postComment">
        </div>
    </div>
</div>