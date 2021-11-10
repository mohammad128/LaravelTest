@extends('layouts.app')
@section('content')

    <x-dashboard>

        <form method="POST" action="{{ route('Video.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($errors->all())
                @foreach ($errors->all() as $error)
                    <span class="text-danger">{{ $error }}</span><br>
                @endforeach
            @endif

            <div class="form-group row">
                <input name="title" type="text" class="form-control" id="inputEmail3" placeholder="Video Title"
                       value="{{old('title')}}">
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="form-group row">
                <textarea class="froalaEditor" name="description"> {{old('description')}} </textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="form-group row">
                <input type='file' name="video" id='videoUpload'/>
                <video
                    id="my-video"
                    class="video-js"
                    controls
                    preload="auto"
                    width="640"
                    height="264"
                    data-setup="{}"
                    controls src="/uploads/videos/default.mp4">
                    <source src="/uploads/videos/default.mp4" type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
                @if($errors->has('video'))
                    <span class="text-danger">{{ $errors->first('video') }}</span>
                @endif

            </div>
            <div class="form-group row">
                <div class="form-check">
                    <input name="status" class="form-check-input" type="checkbox" id="gridCheck1">
                    <label class="form-check-label" for="gridCheck1">
                        Send To Draft
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Publish</button>
                </div>
            </div>
        </form>
    </x-dashboard>
    <script !src="">
        $(document).ready(function () {
            document.getElementById("videoUpload")
                .onchange = function (event) {
                let file = event.target.files[0];
                let blobURL = URL.createObjectURL(file);
                document.querySelector("video").src = blobURL;
            }
        });
    </script>
@endsection
