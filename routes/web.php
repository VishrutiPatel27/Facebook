<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;


    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
Route::redirect('home','/');
Route::get('profile/{id?}',[\App\Http\Controllers\HomeController::class,'profile'])->middleware('auth');
Route::view('register','register_login')->middleware('guest');
Route::post('register',[\App\Http\Controllers\AuthController::class,'register'])->name('registerPost');
Route::post('login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');
Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::post('post',[\App\Http\Controllers\HomeController::class,'createPost'])->name('createPost');
Route::post('comment',[\App\Http\Controllers\HomeController::class,'postComment'])->name('postComment');
Route::get('like',[\App\Http\Controllers\HomeController::class,'pressLike'])->name('pressLike');
Route::view('login','register_login')->middleware('guest');
Route::get('logout',[\App\Http\Controllers\AuthController::class,'logout'])->name('logout');



Route::get('/findFriends', [ProfileController::class,'findFriends']);
Route::get('/addFriend/{id}', [ProfileController::class,'sendRequest']);
Route::get('/requests', [ProfileController::class,'requests']);
Route::get('friends', [ProfileController::class,'friends']);
//Route::get('requestRemove/{id}', [ProfileController::class,'requestRemove']);
Route::get('/notifications/{id}', [ProfileController::class,'notifications']);



Route::get('/editprofile/{id}',[AuthController::class,'editProfile'])->name('editprofile');
Route::post('/updateprofile/{id}',[AuthController::class,'updateProfile'])->name('updateprofile');
// Route::post('friends/unfriend/{id}',[ProfileController::class,'unfriend'])->name('friends.unfriend');

Route::post('friends/remove/{id}',[ProfileController::class,'remove'])->name('friends.remove');
Route::get('/accept/{id}',[ProfileController::class,'accept'])->name('profile.accept');

Route::post('friends/unfriend/{id}',[ProfileController::class,'unfriend'])->name('friends.unfriend');
Route::post('friends/postdel/{id}',[HomeController::class,'postdel'])->name('friends.postdel');



// Route::get('/unfriend/{id}', function($id){
//          $loggedUser = Auth::user()->id;
//           DB::table('friendships')
//           ->where('requester', $loggedUser)
//           ->where('user_requested', $id)
//           ->delete();
//           DB::table('friendships')
//           ->where('user_requested', $loggedUser)
//           ->where('requester', $id)
//           ->delete();
//            return back()->with('msg', 'You are not friend with this person');
//     });