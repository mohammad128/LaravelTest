<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(Tag::create([
//            'name'=>'tag2'
//        ])->id);

//        $tag = Tag::find(18);
//        Post::find(523)->tags()->save($tag);
//        Video::find(1)->tags()->save($tag);
//        $post_tags = Post::find(1)->tags;
//        $video_tags = Video::find(1)->tags;
//        dd($post_tags,$video_tags);


//        dd( Post::find(509)->comments()->create([
//            'comment' => 'test comment 3',
//            'status' => 'waiting',
//            'user_id' => 3
//        ]) );
//        dd( Video::find(1)->comments );


        $posts = auth()->user()->posts()->published()->paginate(10);
        return view("Post.index", compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:8'],
            'content' => ['required', 'min:8'],
        ]);

        $title = $request->title;
        $content = $request->content;
        $status =  $request->status == 'on' ? "draft": "published";

        $post = auth()->user()->posts()->create([
            'title' => $title,
            'content' => $content,
            'status'=> $status
        ]);


        if( !empty($request->get('tags')) ) {
            foreach (json_decode($request->get('tags')) as $tag) {
                $_tag = $tag->value;
                $__tag = Tag::whereRaw( 'LOWER(`name`) LIKE ?', [ $_tag ] )->first();
                Post::find($post->id)->tags()->save( $__tag );
            }
        }

        alert()
            ->success(
                "Post Created Successfully.",
                'Successfully'
            )
            ->persistent('OK');

        return redirect()->route('Post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = auth()->user()->posts()->find($id);
//        dd($post->tags()->where("name", "C#")->get());
        return view('Post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'min:8'],
            'content' => ['required', 'min:8'],
        ]);

        $title = $request->title;
        $content = $request->content;
        $status =  $request->status == 'on' ? "draft": "published";

        $post = auth()->user()->posts()->find($id);
        $post->update([
            'title' => $title,
            'content' => $content,
            'status'=> $status
        ]);
        $post->tags()->detach();
        if( !empty($request->get('tags')) ) {
            foreach (json_decode($request->get('tags')) as $tag) {
                $_tag = $tag->value;
                $__tag = Tag::whereRaw( 'LOWER(`name`) LIKE ?', [ $_tag ] )->first();
                if( empty( $__tag ) ) {
                    $__tag = Tag::create([
                        'name'=>$_tag
                    ]);
                }
                Post::find($post->id)->tags()->save($__tag);
            }
        }

        alert()
            ->success(
                "Post Updated Successfully.",
                'Successfully'
            )
            ->persistent('OK');

        return redirect()->route('Post.edit', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function delete($id, Request $request)
    {
        $redirect = isset($request->query()['redirect']) ? $request->query()['redirect']  : route('Post.index');

        auth()->user()->posts()->find($id)->delete();
        alert()
            ->warning(
                "Post Deleted Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        return redirect()->to( $redirect );
    }

    public function multiDelete(Request $request)
    {
        if(isset( $request->all()['ids']) ) {
            Post::destroy($request->all()['ids']);
            alert()
                ->warning('Posts Deleted.', 'Delete')
                ->persistent('OK');
        }
        return redirect()->route('Post.index');
    }


    public function sendToDraft(Request $request)
    {
        if(isset( $request->all()['ids'] ) ) {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->posts()->find($id)->update([
                    'status'=>'draft'
                ]);
            }
            alert()
                ->warning('Posts Sended To Draft.', 'Delete')
                ->persistent('OK');
        }
        return redirect()->route('Post.index');
    }

    public function sendToPublish(Request $request)
    {
        if(isset( $request->all()['ids'] ) ) {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->posts()->find($id)->update([
                    'status'=>'published'
                ]);
            }
            alert()
                ->success('Posts Published.', 'Published')
                ->persistent('OK');
        }
        return redirect()->route('Post.index');
    }

    public function forceDelete( $id, Request $request ) {
        $redirect = isset($request->query()['redirect']) ? $request->query()['redirect']  : route('Post.index');
        auth()->user()->posts()->withTrashed()->find($id)->forceDelete();
        alert()
        ->warning(
            "Post Deleted Successfully.",
            'Successfully'
        )
        ->persistent('OK');
        return redirect()->to( $redirect );
    }
    public function multiForceDelete( Request $request ) {

        if(isset( $request->all()['ids'] ) ) {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->posts()->withTrashed()->find($id)->forceDelete();
            }
            alert()
                ->warning('Posts physically deleted. you cant restore it.', 'Delete')
                ->persistent('OK');
        }
        return redirect()->route('Post.trash');
    }
    public function multiRestoreDeleted(Request $request)
    {
        if( isset( $request->all()['ids'] ) )  {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->posts()->withTrashed()->find($id)->restore();
            }
            alert()->success(
                "Post Restored Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        }
        return redirect()->route("Post.trash");
    }

    public function restoreDeleted($id, Request $request)
    {
        $redirect = isset($request->query()['redirect']) ? $request->query()['redirect']  : route('Post.index');
        auth()->user()->posts()->withTrashed()->find($id)->restore();
        alert()
        ->success(
            "Post Restored Successfully.",
            'Successfully'
        )
        ->persistent('OK');
        return redirect()->to( $redirect );

    }

    public function trash()
    {
        $paginate_number = (env('PAGINATE_NUMBER'));
        $posts = auth()->user()->posts()->trashed()->paginate(10);
        return view("Post.trash", compact('posts'));
    }

    public function draft()
    {
        $paginate_number = (env('PAGINATE_NUMBER'));
        $posts = auth()->user()->posts()->draft()->paginate(10);
        return view("Post.draft", compact('posts'));
    }
}
