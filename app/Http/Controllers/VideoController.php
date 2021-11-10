<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = auth()->user()->videos()->published()->paginate(10);
        return view("Video.index", compact('videos'));
    }
    public function create()
    {
        return view('Video.create');
    }
    public function draft()
    {
        $videos = auth()->user()->videos()->draft()->paginate(10);
        return view("Video.draft", compact('videos'));
    }
    public function trash()
    {
        $videos = auth()->user()->videos()->trashed()->paginate(10);
        return view("Video.trash", compact('videos'));
    }

    public function edit($id)
    {
        $video = auth()->user()->videos()->find($id);
        return view('Video.edit', compact('video'));
    }
    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'min:8'],
            'description' => ['required', 'min:8'],
            'video' => ['required', 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi']
        ]);

        $f_name = time().'.'.$request->file('video')->getClientOriginalExtension();
        $request->file('video')->move(
            public_path('uploads/videos/'), $f_name
        );

        $title = $request->get('title');
        $description = $request->get('description');
        $status =  $request->get('status') == 'on' ? "draft": "published";
        $video = '/uploads/videos/'.$f_name;
        auth()->user()->videos()->create([
            'title' => $title,
            'description'=>$description,
            'status'=>$status,
            'video'=>$video
        ]);
        alert()
            ->success(
                "Video Created Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        return redirect()->route('Video.index');
    }

    public function update($id, Request $request) {
        $request->validate([
            'title' => ['required', 'min:8'],
            'description' => ['required', 'min:8'],
            'video' => [ 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi']
        ]);
        $f_name = auth()->user()->videos()->find($id)->video;
        if ($request->hasFile('video')) {
            $f_name = public_path() . auth()->user()->videos()->find($id)->video;
            unlink($f_name);
            $f_name = time() . '.' . $request->file('video')->getClientOriginalExtension();
            $request->file('video')->move(
                public_path('uploads/videos/'), $f_name
            );
            $f_name = '/uploads/videos/'.$f_name;
        }

        $title = $request->get('title');
        $description = $request->get('description');
        $status =  $request->get('status') == 'on' ? "draft": "published";
        $video = $f_name;
        auth()->user()->videos()->find($id)->update([
            'title' => $title,
            'description'=>$description,
            'status'=>$status,
            'video'=>$video
        ]);
        alert()
            ->success(
                "Video Updated Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        return redirect()->route('Video.edit',[$id]);
    }


    public function delete( $id, Request $request) {

        $redirect = isset($request->query()['redirect']) ? $request->query()['redirect']  : route('Video.index');

        auth()->user()->videos()->find($id)->delete();
        alert()
            ->warning(
                "Video Deleted Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        return redirect()->to( $redirect );
    }

    public function multiDelete(Request $request)
    {
        if(isset( $request->all()['ids']) ) {
            Video::destroy($request->all()['ids']);
            alert()
                ->warning('Videos Deleted.', 'Delete')
                ->persistent('OK');
        }
        return redirect()->route('Video.index');
    }


    public function sendToDraft(Request $request)
    {
        if(isset( $request->all()['ids'] ) ) {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->videos()->find($id)->update([
                    'status'=>'draft'
                ]);
            }
            alert()
                ->warning('Videos Sended To Draft.', 'Delete')
                ->persistent('OK');
        }
        return redirect()->route('Video.index');
    }


    public function sendToPublish(Request $request)
    {
        if(isset( $request->all()['ids'] ) ) {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->videos()->find($id)->update([
                    'status'=>'published'
                ]);
            }
            alert()
                ->success('Videos Published.', 'Published')
                ->persistent('OK');
        }
        return redirect()->route('Video.draft');
    }


    public function forceDelete( $id, Request $request ) {
        $redirect = isset($request->query()['redirect']) ? $request->query()['redirect']  : route('Video.index');
        auth()->user()->videos()->withTrashed()->find($id)->forceDelete();
        alert()
            ->warning(
                "Video Deleted Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        return redirect()->to( $redirect );
    }
    public function multiForceDelete( Request $request ) {

        if(isset( $request->all()['ids'] ) ) {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->videos()->withTrashed()->find($id)->forceDelete();
            }
            alert()
                ->warning('Videoss physically deleted. you cant restore it.', 'Delete')
                ->persistent('OK');
        }
        return redirect()->route('Video.trash');
    }
    public function multiRestoreDeleted(Request $request)
    {
        if( isset( $request->all()['ids'] ) )  {
            foreach( $request->all()['ids'] as $id ) {
                auth()->user()->videos()->withTrashed()->find($id)->restore();
            }
            alert()->success(
                "Videos Restored Successfully.",
                'Successfully'
            )
                ->persistent('OK');
        }
        return redirect()->route("Video.trash");
    }
    public function restoreDeleted($id, Request $request)
    {
        $redirect = isset($request->query()['redirect']) ? $request->query()['redirect']  : route('Video.index');
        auth()->user()->videos()->withTrashed()->find($id)->restore();
        alert()
            ->success(
                "Video Restored Successfully.",
                'Successfully'
            )
            ->persistent('OK');
        return redirect()->to( $redirect );

    }


}
