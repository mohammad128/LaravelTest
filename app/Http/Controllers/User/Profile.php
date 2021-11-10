<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Profile extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => ['required', 'string', 'max:255', 'min:8'],
            'age' => ['required', 'alpha_num'],
            'address'=>['required', 'min:10', 'max:255'],
            'bio'=>['required', 'min:10', 'max:2048'],
            'phone'=>['required', 'min:11', 'max:11'],
            'avatar'=>[ 'image','mimes:jpg,jpeg,png,bmp,gif', 'dimensions:min_width=100,min_height=100,max_width=500,max_height=500']
        ]);
        auth()->user()->update([
            'name'=>$request->get('name')
        ]);

        $image_name = auth()->user()->profile->image;
        if( $request->hasFile('avatar') ) {
            $avatar = $request->file('avatar');
            $image_name = time() . "." . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('uploads/avatars/' . $image_name ) );
            if( ! Str::startsWith( auth()->user()->profile->image, "avatar" ) ) {
                File::delete( public_path('uploads/avatars/'.auth()->user()->profile->image ) );
            }
        }

        auth()->user()->profile()->update([
            'age'=>$request->get('age'),
            'address'=>$request->get('address'),
            'bio'=>$request->get('bio'),
            'phone'=>$request->get('phone'),
            'image' =>$image_name
        ]);


        return redirect()->route('profile.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
