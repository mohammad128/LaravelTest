<div class="container d-md-flex align-items-stretch">
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        {{ $slot }}
    </div>

    <nav id="sidebar">
        <div class="p-4 pt-5">
            <h5><a href="#">Dashboard</a></h5>
            <ul class="list-unstyled components mb-5">
                <li>
                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Posts</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu2">
                        <li>
                            <a href="{{ route('Post.index') }}">

                                Published <span
                                    class="p-1 text-white badge badge-pill badge-primary">{{ auth()->user()->posts()->published()->get()->count() }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Post.create') }}"> Add New</a>
                        </li>
                        <li>
                            <a href="{{ route('Post.draft') }}">

                                Drafts <span
                                    class="p-1 text-dark badge badge-pill badge-warning">{{ auth()->user()->posts()->draft()->get()->count() }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Post.trash') }}">

                                Trashes <span
                                    class="p-1 text-white badge badge-pill badge-danger">{{ auth()->user()->posts()->trashed()->get()->count() }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Videos</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu3">
                        <li><a href="{{ route('Video.index') }}"> All
                                Videos <span class="p-1 text-white badge badge-pill badge-primary">{{ auth()->user()->videos()->published()->get()->count() }}</span></a></li>
                        <li><a href="{{ route('Video.create') }}"> Add
                                New</a></li>
                        <li><a href="{{ route('Video.draft') }}">
                                Drafts<span class="p-1 text-dark badge badge-pill badge-warning">{{ auth()->user()->videos()->draft()->get()->count() }}</span></a></li>
                        <li><a href="{{ route('Video.trash') }}">
                                Trashes <span class="p-1 text-white badge badge-pill badge-danger">{{ auth()->user()->videos()->trashed()->get()->count() }}</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">User</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">
                        <li><a href="{{ route('profile.index') }}">
                                Profile</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu6" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Tags</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu6">
                        <li><a href="{{ route('Tag.index') }}">
                                Manage Tags</a></li>
                    </ul>
                </li>
            </ul>
            <div class="mb-5">
                <h5>Tag Cloud</h5>
                <div class="tagcloud">
                    <a href="#" class="tag-cloud-link">dish</a>
                    <a href="#" class="tag-cloud-link">menu</a>
                    <a href="#" class="tag-cloud-link">food</a>
                    <a href="#" class="tag-cloud-link">sweet</a>
                    <a href="#" class="tag-cloud-link">tasty</a>
                    <a href="#" class="tag-cloud-link">delicious</a>
                    <a href="#" class="tag-cloud-link">desserts</a>
                    <a href="#" class="tag-cloud-link">drinks</a>
                </div>
            </div>
            <div class="mb-5">
                <h5>Newsletter</h5>
                <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                        <div class="icon"><span class="icon-paper-plane"></span></div>
                        <input type="text" class="form-control" placeholder="Enter Email Address">
                    </div>
                </form>
            </div>
        </div>
    </nav>
</div>


<script>
    $(document).ready(function () {
        let url = window.location.href.split('?')[0];
        console.log(url);
        $("#sidebar a").each(function () {
            if ($(this).attr("href") == url) {
                // $('#sidebar a[href="'+window.location.href+'"]').addClass("active");
                // $('#sidebar a[href="'+window.location.href+'"]').closest('ul').addClass("show");
                $(this).addClass("active");
                $(this).closest('ul').addClass("show");
            }
        });
    });
</script>
