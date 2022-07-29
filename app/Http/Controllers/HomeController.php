<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use App\PusherOps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()

    {
        $this->middleware('auth');
    }
    use PusherOps;
    public function index()
    {
        //  $user = User::join('friends', 'users.id','=','friends.user_requested')->where('status', 0)->get('users.*')->except(Auth::id());
         
        //  dd($user);
         $user = User::get()->except(Auth::id());
        // $posts = Post::join('friends', 'requester','=','user_id')->where('friends.status', 1)->get();
        // dd($posts);
        $posts = Post::with('comments.user','user','likes')
                ->orderByDesc('created_at')->get();
       
             $uid = auth()->user()->id;
            $Friend = DB::table('friends')
                        ->rightJoin('users', 'users.id', '=', 'friends.requester')
                        ->where('status', '=', 1)
                        ->where('friends.user_requested', '=',$uid)->get();
           
        return view('home',compact('posts','user','Friend'));
    }

    public function createPost(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'text'=>'sometimes',
            'image'=>'sometimes|image'
        ]);

        if ($validator->fails()) return response()->json([
            'status'=>400,
            'error'=>$validator->errors()->first()
        ]);

        if (!$request->image && !$request->text)return response()->json([
            'status'=>400,
            'error'=>'Must Select Image Or Write Text First'
        ]);

        $inputs = $request->all();
        if ($request->image){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('post_pic'), $imageName);
    
            $user=$request->all();
    
            $inputs['image'] = $imageName;
        }
        $post = auth()->user()->posts()->create($inputs);
        $html = view('post',compact('post'))->render();
        $this->push('post',['data'=>$html,'user_id'=>auth()->id()]);
        return response()->json([
            'status'=>200
        ]);
    }
    public function postComment(Request $request)
    {
        $data = $request->only('text');
        $data['user_id'] = auth()->id();
        $comment = Post::find($request->post_id)->comments()->create($data);
        $pusherData['html'] = view('comment',compact('comment'))->render();
        $pusherData['user_id'] = $comment->post->user_id;
        $pusherData['post_id'] = $comment->post_id;
        $this->push('comment',$pusherData);
        return response()->json(['status'=>true]);
    }

    public function pressLike(Request $request)
    {
        $post = Post::find($request->post_id);
        if($post->likes->contains('user_id',auth()->id())){

            $post->likes()->where('user_id',auth()->id())->delete();
        }else{
            $post->likes()->create(['user_id'=>auth()->id()]);
        }
        $count = $post->likes()->count();
        $pusherData['post_id'] = $post->id;
        $pusherData['count'] = $count;
        $this->push('likes',$pusherData);
        return response()->json(['likes'=>$count]);
    }

    public function profile($id = null)
    {
        $posts = auth()->user()->posts()->with('likes','comments.user')
            ->orderByDesc('created_at')->get();
        if ($id)
        $user = User::find($id);
        else $user = auth()->user();
        return view('profile',compact('posts','user'));
    }

    public function postdel($id)
    {
        // dd($id);
        Post::find($id)->delete();
         return redirect('home');
    }
}