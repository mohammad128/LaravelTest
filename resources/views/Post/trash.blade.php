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
                                    <a href="{{ route('Post.restoreDeleted', [$post->id,'redirect'=>route('Post.trash')]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                          </svg>
                                    </a> &nbsp;
                                    <a href="{{ route('Post.forceDelete', [$post->id, 'redirect'=>route('Post.trash')]) }}">
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
                    <option value="delete" data-action="{{ route('Post.multiForceDelete') }}">Physicall Delete</option>
                    <option value="sendToDraft" data-action="{{ route('Post.multiRestoreDeleted') }}">Restore</option>
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
