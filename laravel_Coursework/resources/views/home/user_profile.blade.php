<!-- resources/views/home/user_profile.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.homecss')
    <title>User Profile</title>
</head>
<body>
<header>

</header>

<main role="main" class="p-6">
    @isset($profileUser)
        <section aria-label="User Profile" class="mb-6">
            <h1 class="text-3xl font-bold">Welcome, {{ $profileUser->name }}</h1>
            <p>Email: {{ $profileUser->email }}</p>
            <p>User Type: {{ ucfirst($profileUser->usertype) }}</p>
        </section>


        @if($profileUser->profile)
            <section aria-label="User Bio" class="mb-6">
                <h2 class="text-xl font-semibold">Bio</h2>
                <p>{{ $profileUser->profile->bio }}</p>
                @if($profileUser->profile->avatar)
                    <img src="/postimage/{{ $profileUser->profile->avatar }}"
                         alt="Avatar of {{ $profileUser->name }}"
                         class="mt-4 w-32 h-32 rounded-full object-cover">
                @endif
            </section>
        @endif


            <section aria-label="User Posts" class="mb-6">
            <h2 class="text-xl font-semibold">Posts by {{ $profileUser->name }}</h2>
            @forelse($profileUser->posts as $post)
                <article class="border p-4 my-4">
                    <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                    <p>{{ $post->description }}</p>
                    @if($post->image)
                        <img src="/postimage/{{ $post->image }}"
                             alt="Image for post titled {{ $post->title }}"
                             class="mt-2 w-64 h-auto">
                    @endif
                    @if($post->tags && $post->tags->count())
                        <p><strong>Tags:</strong>
                            @foreach($post->tags as $tag)
                                <span>{{ $tag->name }}</span>
                            @endforeach
                        </p>
                    @endif

                    <!-- Like button for post -->
                    @auth
                        <button type="button" data-id="{{ $post->id }}" data-type="post"
                                class="like-post-button" aria-label="Like this post">
                            Like Post
                        </button>
                    @endauth

                    <!-- Edit/Delete Buttons -->
                    @can('update', $post)
                        <a href="{{ route('edit_page', $post->id) }}" class="underline text-blue-600">Edit Post</a>
                    @endcan
                    @can('delete', $post)
                        <form action="{{ route('delete_post', $post) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this post?')">
                                Delete
                            </button>
                        </form>

                    @endcan

                    <h4 class="mt-4 font-semibold">Comments</h4>
                    @foreach($post->comments as $comment)
                        <div class="border-t mt-2 pt-2">
                            <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment_text }}</p>

                            <!-- Like comment -->
                            @auth
                                <button type="button" data-id="{{ $comment->id }}" data-type="comment"
                                        class="like-comment-button" aria-label="Like this comment">
                                    Like Comment
                                </button>
                            @endauth

                            @can('update', $comment)
                                <a href="{{ route('comments.edit', $comment->id) }}" class="underline text-blue-600">Edit</a>
                            @endcan
                            @can('delete', $comment)
                                <form action="{{ route('comments.delete', $comment) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>

                            @endcan
                        </div>
                    @endforeach
                </article>
            @empty
                <p>No posts yet.</p>
            @endforelse
        </section>
    @else
        <p>User profile not found.</p>
    @endisset
</main>


<!-- Include jQuery and AJAX scripts for liking -->
<script src="/admincss/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-post-button').click(function() {
            let postId = $(this).data('id');
            $.post("{{ route('like') }}", {
                _token: "{{ csrf_token() }}",
                type: 'post',
                id: postId
            }, function(response) {
                alert(response.message);
            });
        });

        $('.like-comment-button').click(function() {
            let commentId = $(this).data('id');
            $.post("{{ route('like') }}", {
                _token: "{{ csrf_token() }}",
                type: 'comment',
                id: commentId
            }, function(response) {
                alert(response.message);
            });
        });
    });
</script>
</body>
</html>

