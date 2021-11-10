<div class="row">
@php


foreach ($comments->get() as $comment) {
    if( $comment->parent_id == 0 )
        show_comment($comment, $comments);
}

function get_sub_comment( $comment_id, $comments ) {
    foreach( $comments->get() as $comment ) {
        if( $comment->parent_id == $comment_id ) {
            show_comment($comment,$comments, true);
        }
    }
}

function show_comment( $comment, $comments, $isSub=false ) {
    $user = \App\Models\User::find($comment->user_id);
    @endphp
    @if(!$isSub)
    <div class="col-md-12 my-2" style="box-shadow: -1px 0px #fc7fb2;">
    @else
    <div class="sub_comemnt ml-4">
    @endif
        <div class="media g-mb-30 media-comment">
            <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="/uploads/avatars/{{$user->profile->image}}" alt="Image Description">
            <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                <div class="g-mb-15">
                    <h5 class="h5 g-color-gray-dark-v1 mb-0">{{ $user->name  }}</h5>
                    <span class="g-color-gray-dark-v4 g-font-size-12">{{ $comment->created_at  }}</span>
                </div>

                <p>{{ $comment->comment }}</p>

                <ul class="list-inline d-sm-flex my-0">
                    <li class="list-inline-item g-mr-20">
                        <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#">
                            <i class="fa fa-thumbs-up g-pos-rel g-top-1 g-mr-3"></i>
                            {{ $comment->like  }}
                        </a>
                    </li>
                    <li class="list-inline-item g-mr-20">
                        <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#">
                            <i class="fa fa-thumbs-down g-pos-rel g-top-1 g-mr-3"></i>
                            {{ $comment->dislike  }}
                        </a>
                    </li>
                    <li class="list-inline-item ml-auto">
                        <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover reply_comment" href="#commentForm" data-id="{{$comment->id}}">
                            <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                            Reply
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @php
            get_sub_comment($comment->id, $comments);
        @endphp
    </div>
    @php
}
@endphp
</div>
@auth
<div class="row" >
    <div class="col-md-12">{{ __('Add Comment')  }}:</div>
    <form id="commentForm" class="col-md-12" action="{{ route('Comment.create')  }}" method="post">
        @php
        $user = \App\Models\User::find(auth()->user()->id);
        @endphp
        @csrf

        <div class="media g-mb-30 media-comment">
            <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="/uploads/avatars/{{$user->profile->image}}" alt="Image Description">
            <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                <div class="g-mb-15">
                    <h5 class="h5 g-color-gray-dark-v1 mb-0">{{ $user->name  }}</h5>
                </div>

                <p>
                    <textarea class="form-control border bg-dark text-white " name="comment" id="" cols="30" rows="10"></textarea>
                </p>
                @if ($errors->has('comment'))
                    <span class="text-danger">{{ $errors->first('comment') }}</span>
                @endif

            </div>
        </div>
        <input type="hidden" name="type" value="{{get_class($post)}}">
        <input type="hidden" name="id" value="{{$post->id}}">
        <input type="hidden" id="reply_id" name="reply_id" value="0">
        <input type="hidden" name="redirect" value="{{ \Illuminate\Support\Facades\Request::fullUrl()  }}">
        <button class="btn btn-primary" type="submit">{{__('Send')}}</button>
    </form>
</div>
@endauth
