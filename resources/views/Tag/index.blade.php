@extends('layouts.app')
@section('content')
    <x-dashboard>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <input type="text" class="form-control" id="addTag" placeholder="Add New Tag" >
            </div>
            <div class="col-md-6 col-sm-12">
                <input type="text" class="form-control" id="searchTag" placeholder="Search Tag..." >
            </div>
            <div class="col-md-12">
                <span>Dbl-Click on tag to edit.</span>
            </div>
        </div>
        <hr>
        <div id="tag-container" class="col-md-12">
            @foreach($tags as $tag)
            <button type="button" class="btn btn-primary mt-1 tagBtn" id="tagBtn_{{$tag->id}}">
                <span class="tag_title" data-tagId="{{ $tag->id }}">{{$tag->name}}</span> <span class="badge badge-light">{{ \App\Models\Tag::find($tag->id)->posts()->count() + \App\Models\Tag::find($tag->id)->videos()->count() }}</span>
                <span class="badge badge-light delete_tag" id="delete_tag{{$tag->id}}" data-tagId="{{ $tag->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                    </svg>
                </span>
            </button>
            @endforeach
        </div>
    </x-dashboard>

@endsection


@section('script')
    <script src="{{ asset('js/tag.js')  }}"></script>
@endsection
