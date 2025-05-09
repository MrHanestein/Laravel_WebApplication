<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.homecss')
    <title>Post Details</title>
</head>
<body>
<header class="header_section">
    @include('home.header')
</header>

<main style="text-align:center;" class="col-md-13">
    <div>
        <img  src="/postimage/{{ $post->image }}"
              alt="Image for post titled {{ $post->title }}"
              style="padding:20px;margin-bottom:20px;height:200px;width:350px;">
    </div>

    <h1>{{ $post->title }}</h1>
    <p>Posted By <b>{{ $post->name }}</b></p>
    <p>{{ $post->description }}</p>

    {{-- optional delete for post owner / admin --}}
    @can('delete', $post)
        <form action="{{ route('delete_post', $post) }}"
              method="POST"
              class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this post?')">
                Delete Post
            </button>
        </form>
    @endcan

    @auth
        <!-- Like button for post -->
        <button  type="button"
                 id="like-post"
                 data-id="{{ $post->id }}"
                 data-type="post"
                 aria-label="Like this post">
            Like Post
        </button>
    @endauth

    @include('home.footer')
</main>

<hr>

<div class="container" style="margin-top:20px;">
    <h2>Comments</h2>

    <div id="comments-list" aria-live="polite">
        @foreach ($post->comments as $comment)
            <div style="border-bottom:1px solid #ddd;margin-bottom:10px;padding-bottom:10px;">
                <strong>{{ $comment->user->name }}</strong> –
                <small>{{ $comment->created_at->diffForHumans() }}</small>
                <p>{{ $comment->comment_text }}</p>

                @auth
                    <!-- Like button for each comment -->
                    <button  type="button"
                             class="like-comment"
                             data-id="{{ $comment->id }}"
                             data-type="comment"
                             aria-label="Like this comment">
                        Like Comment
                    </button>

                    @can('update', $comment)
                        <button class="edit-comment-btn"
                                data-id="{{ $comment->id }}"
                                data-text="{{ $comment->comment_text }}"
                                aria-label="Edit Comment">
                            Edit
                        </button>
                    @endcan

                    @can('delete', $comment)
                        <form  action="{{ route('comments.delete', $comment) }}"
                               method="POST"
                               style="display:inline;">
                            @csrf
                            @method('DELETE')   {{-- <-- verb spoof - FIXED --}}
                            <button type="submit"
                                    aria-label="Delete Comment">
                                Delete
                            </button>
                        </form>
                    @endcan
                @endauth
            </div>
        @endforeach
    </div>

    @auth
        <h3>Add a Comment:</h3>
        <form id="comment-form" aria-label="Add a new comment form">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <label for="comment_text">Your comment</label><br>
            <textarea  name="comment_text"
                       id="comment_text"
                       rows="3"
                       style="width:100%;"
                       required></textarea><br><br>

            <button type="submit"
                    style="padding:10px 20px;background:blue;color:#fff;border:none;cursor:pointer;"
                    aria-label="Submit Comment">
                Submit Comment
            </button>
        </form>
    @else
        <p>You must be <a href="{{ route('login') }}">logged in</a> to comment.</p>
    @endauth
</div>

{{-- ---------------------------------------------------------------- --}}
{{--  Scripts                                                        --}}
{{-- ---------------------------------------------------------------- --}}
<script src="/admincss/vendor/jquery/jquery.min.js"></script>

<script>
    /* ---------- jQuery version (AJAX) ---------- */
    $(function () {

        /* add comment */
        $('#comment-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url:  "{{ route('comments.store') }}",
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,

                success: function (res) {
                    const html =
                        `<div style="border-bottom:1px solid #ddd;margin-bottom:10px;padding-bottom:10px;">
                       <strong>${res.user_name}</strong> –
                       <small>${res.created_at}</small>
                       <p>${res.comment_text}</p>
                   </div>`;
                    $('#comments-list').prepend(html);
                    $('#comment_text').val('');
                },
                error: () => alert('Could not add comment. Please try again.')
            });
        });

        /* like post */
        $('#like-post').on('click', function () {
            $.post("{{ route('like') }}", {
                _token : "{{ csrf_token() }}",
                type   : 'post',
                id     : $(this).data('id')
            }, res => alert(res.message));
        });

        /* like comment */
        $('.like-comment').on('click', function () {
            $.post("{{ route('like') }}", {
                _token : "{{ csrf_token() }}",
                type   : 'comment',
                id     : $(this).data('id')
            }, res => alert(res.message));
        });
    });
</script>

</body>
</html>
