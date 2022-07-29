<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Friend;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notifications;

class ProfileController extends Controller
{
    // public function findFriends() {

    //     $user = Auth::user()->id;
    //     $allUsers = DB::table('profiles')
    //     ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
    //     ->where('users.id', '!=', $uid)->get();

    //     return view('profile.findFriends', compact('allUsers'));
    // }

    public function sendRequest(Request $request , $id) {
        $user = auth()->user();
        $data = [
            'requester'=>$user->id,
            'user_requested'=>$id,
        ];

        Friend::create($data);
        return back();
    }

    public function requests() {
        $uid = auth()->user()->id;
        // echo $uid;
        // exit;
        $FriendRequests = DB::table('friends')
                            ->rightJoin('users', 'users.id', '=', 'friends.requester')
                            ->where('status', '=', 0)
                            ->where('friends.user_requested', '=', $uid)->get();
                    
        return view('profile.friends', compact('FriendRequests'));
    }

    public function accept($id) {

        $uid = Auth::user()->id;
        $checkRequest = Friend::where('requester', $id)
                ->where('user_requested', $uid)
                ->first();
        if ($checkRequest) {
            // echo "yes, update here";

            $checkRequest->update(['status' => 1]);
            // $notifications = new notifications;
            // $notifications->note = 'accepted your friend request';
            // $notifications->user_hero = $id; // who is accepting my request
            // $notifications->user_logged = Auth::user()->id; // me
            // $notifications->status = '1'; // unread notifications
            // $notifications->save();

            return redirect('home')->with('msg', 'You are now Friend with this user');
            // if ($notifications) {

            //     return back()->with('msg', 'You are now Friend with ' . $name);
            // }
          
        } 
        // else {
        //     return back()->with('msg', 'You are now Friend with this user');
        // }
    }

    // public function friends() {
    //     $uid = Auth::user('id');

    //     $friends1 = DB::table('friends')
    //             ->leftJoin('users', 'users.id', 'friends.user_requested') // who is not loggedin but send request to
    //             ->where('status', 1)
    //             ->where('requester', $uid) // who is loggedin
    //             ->get();

    //     //dd($friends1);

    //     $friends2 = DB::table('friends')
    //             ->leftJoin('users', 'users.id', 'friends.requester')
    //             ->where('status', 1)
    //             ->where('user_requested', $uid)
    //             ->get();

    //     $friends = array_merge($friends1->toArray(), $friends2->toArray());

    //     return view('profile.friends', compact('friends'));
    // }

    // public function requestRemove($id) {

    //     DB::table('friends')
    //             ->where('user_requested', Auth::user()->id)
    //             ->where('requester', $id)
    //             ->delete();
    
    //     return back()->with('msg', 'Request has been deleted');
    // }


    public function remove($id)
    {

        // echo "khbhjbh";
        // echo $id;
        // $res =Friend::where('id',$id)->first();
        // echo $res;
        // die();
        // $res->delete();

        
        $uid = Auth::user()->id;
        Friend::where('user_requested', $uid)
        ->where('status',0)
        ->where('requester', $id)->delete();
        
        // $res = Friend::find($id)->delete();
        // echo $res;
        // die($res);
        // exit;
        // $res->delete();
     
         return back();  }
    
    public function unfriend($id)
    {
        // dd($id);
        $uid = Auth::user()->id;
        Friend::where('user_requested', $uid)
        ->where('requester', $id)
        ->where('status',1)->delete();
         return redirect('home');
    }
}
