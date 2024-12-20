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
        <img style="padding: 20px; margin-bottom: 20px; height: 200px; width:350px;"
             src="/postimage/{{$post->image}}"
             alt="Image for post titled {{$post->title}}">
    </div>
    <h1>{{ $post->title }}</h1>
    <p>Posted By <b>{{ $post->name }}</b></p>
    <p>{{ $post->description }}</p>

    @auth
        <!-- Like button for post -->
        <button type="button" id="like-post" data-id="{{$post->id}}" data-type="post" aria-label="Like this post">
            Like Post
        </button>
    @endauth

    @include('home.footer')
</main>

<hr>

<div class="container" style="margin-top:20px;">
    <h2>Comments</h2>
    <div id="comments-list" aria-live="polite">
        @foreach($post->comments as $comment)
            <div style="border-bottom:1px solid #ddd; margin-bottom:10px; padding-bottom:10px;">
                <strong>{{ $comment->user->name }}</strong> -
                <small>{{ $comment->created_at->diffForHumans() }}</small>
                <p>{{ $comment->comment_text }}</p>

                @auth
                    <!-- Like button for each comment -->
                    <button type="button" class="like-comment" data-id="{{$comment->id}}" data-type="comment" aria-label="Like this comment">
                        Like Comment
                    </button>

                    @@can('update', $comment)
                        <button class="edit-comment-btn" data-id="{{$comment->id}}" data-text="{{$comment->comment_text}}" aria-label="Edit Comment">Edit</button>
                    @endcan
                    @can('delete', $comment)
                        <form style="display:inline;" method="POST" action="{{route('comments.delete', $comment->id)}}">
                            @csrf
                            <button type="submit" aria-label="Delete Comment">Delete</button>
                        </form>
                    @endcan
            </div>
        @endforeach
    </div>

    @auth
        <h3>Add a Comment:</h3>
        <form id="comment-form" aria-label="Add a new comment form">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <label for="comment_text">Your comment</label><br>
            <textarea name="comment_text" id="comment_text" rows="3" style="width:100%;" required></textarea>
            <br><br>
            <button type="submit" style="padding:10px 20px; background:blue; color:#fff; border:none; cursor:pointer;" aria-label="Submit Comment">
                Submit Comment
            </button>
        </form>
    @else
        <p>You must be <a href="{{ route('login') }}">logged in</a> to comment.</p>
    @endauth
</div>

<script src="/admincss/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#comment-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('comments.store') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    let commentHtml = '<div style="border-bottom:1px solid #ddd; margin-bottom:10px; padding-bottom:10px;">'
                        + '<strong>' + response.user_name + '</strong> - <small>' + response.created_at + '</small>'
                        + '<p>' + response.comment_text + '</p>'
                        + '</div>';
                    $('#comments-list').prepend(commentHtml);
                    $('#comment_text').val('');
                },
                error: function() {
                    alert("Could not add comment. Please try again.");
                }
            });
        });

        $('#like-post').on('click', function() {
            $.ajax({
                url: "{{ route('like') }}",
                method: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    type: 'post',
                    id: $(this).data('id')
                },
                success: function(response) {
                    alert(response.message);
                }
            });
        });

        $('.like-comment').on('click', function() {
            $.ajax({
                url: "{{ route('like') }}",
                method: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    type: 'comment',
                    id: $(this).data('id')
                },
                success: function(response) {
                    alert(response.message);
                }
            });
        });
    });
</script>
</body>
</html>
