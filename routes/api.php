<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// USERS SERVICES
Route::get('users/{user}', function (User $user) {
    return $user;
});


// POSTS SERVICES
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function () {
    return Post::with('user:id,name,usertag,avatar')->orderBy('id', 'desc')->latest()->paginate(10);
});

Route::get('posts/{post}', function (Post $post) {
    return $post->load('user:id,name,usertag,avatar');
});

Route::post('posts', function (Request $request) {
    sleep(2);
    $attributes = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'location' => 'required',
        'date' => 'required',
    ]);
    ;
    $attributes['date'] = Carbon::createFromFormat('d/m/Y', $request->date);
    $attributes['user_id'] = 1;

    return Post::create($attributes);
});

Route::get('users/{user}/posts', function (User $user) {
    return $user->posts()->with('user:id,name,usertag,avatar')->orderBy('id', 'desc')->latest()->paginate(10);
});