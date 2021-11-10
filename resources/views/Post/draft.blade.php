@extends('layouts.app')
@section('content')

    <x-dashboard>
        <form id="_form" method="POST" action="" class="row justify-content-center">
            @csrf
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">UpdatedAt</th>
                            <th></th>
                            <th scope="col"><input type="checkbox" id="selectAll"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($posts as $post)
                            <tr>
                                <th scope="row">{{ $post->id }}</th>
                                <th><a href="{{ route('Post.edit', [$post->id]) }}" target="_blank">
                                        {{ $post->title }} </a></th>
                                <th>{{ $post->updated_at }}</th>
                                <td>
                                    <a href="{{ route('Post.show', [$post->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg>
                                    </a> &nbsp;
                                    <a href="{{ route('Post.edit', [$post->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </a> &nbsp;
                                    <a href="{{ route('Post.delete', [$post->id, 'redirect'=>route('Post.draft')]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                        </svg>
                                    </a>
                                </td>
                                <th style="text-align: center">
                                    <input name="ids[]" class="form-check-input" type="checkbox" value="{{ $post->id }}">
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <select name="action" id="_action" class="form-select form-select-lg mb-3"
                    aria-label=".form-select-lg example" style="padding: .5em;">
                    <option selected>Open this select menu</option>
                    <option value="delete" data-action="{{ route('Post.multiDelete') }}">Delete</option>
                    <option value="publish" data-action="{{ route('Post.sendToPublish') }}">Publish</option>
                </select>
                <script>
                    $(document).ready(function() {
                        $("#_action").change(function(e) {
                            let action = $(this.options[e.target.selectedIndex]).data("action");
                            $("#_form").attr("action", action);
                        });
                        $("#selectAll").change(function() {
                            $("#_form .table tbody .form-check-input").prop('checked', $(this).is(':checked'));
                        })

                    });
                </script>
                <button type="submit" class="btn btn-dark">StartAction</button>

            </div>
        </form>
        {{ $posts->links() }}


    </x-dashboard>

@endsection
