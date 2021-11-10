@extends('layouts.app')
@section('content')
    <x-dashboard>

        <form method="POST" action="{{ route('Post.update', [$post->id]) }}">
            @csrf
            @method('PUT')
            @if ($errors->all())
                @foreach ($errors->all() as $error)
                    <span class="text-danger">{{ $error }}</span><br>
                @endforeach
            @endif

            <div class="form-group row">
                <input name="title" type="text" class="form-control" id="inputEmail3" placeholder="Post Title"
                    value="{{ old('title') ? old('title') : $post->title }}">
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="form-group row">
                <textarea class="froalaEditor" name="content" >{{ old('content') ? old('content') : $post->content }}</textarea>
                @if ($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
            </div>
            <div class="form-group row">
                <div class="form-check">
                    @if ($post->status == "draft")
                        <input name="status" class="form-check-input" type="checkbox" id="gridCheck1" checked>
                    @else
                        <input name="status" class="form-check-input" type="checkbox" id="gridCheck1">
                    @endif
                    <label class="form-check-label" for="gridCheck1">
                        Send To Draft
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <input name='tags' placeholder='Tags' value='{{ $post->tags->implode('name', ',')  }}'>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <br><hr><br>
        <x-comments :comments="$post->comments()" :post="$post">
        </x-comments>
    </x-dashboard>

@endsection
@section('script')
    <link rel="stylesheet" href="{{asset('css/create-post.css')}}">
    <script src="{{asset('js/tagify.js')}}"></script>
    <script src="{{asset('js/editPost.js')}}"></script>
@endsection

