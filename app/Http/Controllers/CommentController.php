<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create( Request $request ) {
        $request->validate([
            'comment'=>['required', 'max:255'],
        ]);
        $type = $request->get('type');
        $post = $type::find($request->get('id'));
        $post->comments()->create([
            'user_id'=>auth()->user()->id,
            'comment'=>$request->get('comment'),
            'status'=>'waiting',
            'parent_id'=>$request->get('reply_id')
        ]);
        return redirect()->to($request->get('redirect'));
    }
}
