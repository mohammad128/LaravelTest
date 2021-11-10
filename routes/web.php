<?php

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\Profile;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// })->name("home");

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('user')->group(function () {
    Route::resource('/profile', Profile::class)->only(['index', 'store']);
});

Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('Post/Trash', [PostController::class, 'trash'])->name("Post.trash");
    Route::get('Post/Draft', [PostController::class, 'draft'])->name("Post.draft");
    Route::get('Post/Delete/{id}', [PostController::class, 'delete'])->name("Post.delete");
    Route::post('Post/multiDelete', [PostController::class, 'multiDelete'])->name("Post.multiDelete");
    Route::post('Post/sendToDraft', [PostController::class, 'sendToDraft'])->name("Post.sendToDraft");
    Route::post('Post/sendToPublish', [PostController::class, 'sendToPublish'])->name("Post.sendToPublish");
    Route::post('Post/multiForceDelete', [PostController::class, 'multiForceDelete'])->name("Post.multiForceDelete");
    Route::get('Post/restoreDeleted/{id}', [PostController::class, 'restoreDeleted'])->name("Post.restoreDeleted");
    Route::post('Post/multiRestoreDeleted', [PostController::class, 'multiRestoreDeleted'])->name("Post.multiRestoreDeleted");
    Route::get('Post/ForceDelete/{id}', [PostController::class, 'forceDelete'])->name("Post.forceDelete");
    Route::resource('Post', PostController::class);


    Route::prefix('Video')->group(function () {
        Route::get('/', [ VideoController::class,'index' ])->name("Video.index");
        Route::get('/create', [ VideoController::class,'create' ])->name("Video.create");
        Route::post('/store', [VideoController::class, 'store'])->name('Video.store');
        Route::get('/draft', [ VideoController::class,'draft' ])->name("Video.draft");
        Route::get('/trash', [ VideoController::class,'trash' ])->name("Video.trash");

        Route::get('/edit/{id}', [ VideoController::class,'edit' ])->name("Video.edit");
        Route::put('/update/{id}', [ VideoController::class,'update' ])->name("Video.update");
        Route::get('/show/{id}', [ VideoController::class,'show' ])->name("Video.show");
        Route::get('/delete/{id}', [ VideoController::class,'delete' ])->name("Video.delete");
        Route::post('/multiDelete', [VideoController::class, 'multiDelete'])->name("Video.multiDelete");
        Route::post('/sendToDraft', [VideoController::class, 'sendToDraft'])->name("Video.sendToDraft");
        Route::post('/sendToPublish', [VideoController::class, 'sendToPublish'])->name("Video.sendToPublish");
        Route::post('/multiForceDelete', [VideoController::class, 'multiForceDelete'])->name("Video.multiForceDelete");
        Route::get('/restoreDeleted/{id}', [VideoController::class, 'restoreDeleted'])->name("Video.restoreDeleted");
        Route::post('/multiRestoreDeleted', [VideoController::class, 'multiRestoreDeleted'])->name("Video.multiRestoreDeleted");
        Route::get('/ForceDelete/{id}', [VideoController::class, 'forceDelete'])->name("Video.forceDelete");

    });

});

Route::middleware('auth')->prefix('Comment')->group(function () {
    Route::post( 'create', [ \App\Http\Controllers\CommentController::class, 'create'  ] )->name("Comment.create");
});


Route::middleware('auth')->prefix('Tag')->group(function (){
    Route::get('/', [\App\Http\Controllers\TagController::class, 'index'])->name("Tag.index");
});

Route::middleware('auth')->get('Tag/all', function (){
    return \App\Models\Tag::all();
} );
Route::middleware('auth')->resource('Tag', \App\Http\Controllers\TagController::class );

