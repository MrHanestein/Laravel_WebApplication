<!-- resources/views/home/homepage.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.homecss')
    <title>Homepage</title>
</head>
<body>
<header>
    @include('home.header')
</header>

<main>
    @include('home.banner')
    @include('home.services')
    @include('home.about')
    @include('home.user_profile')      <!-- New Partial -->
    @include('home.notifications')     <!-- New Partial -->
    @include('home.edit_comment')      <!-- New Partial for editing comments via AJAX -->

    @auth
        @include('home.auth')
    @endauth

    <section aria-label="List of posts">
        @foreach($post as $p)
            <article style="border:1px solid #ccc; padding:10px; margin:10px;">
                <img src="/postimage/{{$p->image}}" alt="Image for post titled {{$p->title}}" style="width:200px;height:auto;">
                <h2>{{$p->title}}</h2>
                <p>{{$p->description}}</p>
                @if($p->tags && $p->tags->count())
                    <p><strong>Tags:</strong>
                        @foreach($p->tags as $tag)
                            <span>{{$tag->name}}</span>
                        @endforeach
                    </p>
                @endif

                <!-- Like button for post -->
                @auth
                    <button type="button" class="like-post" data-id="{{$p->id}}" data-type="post" aria-label="Like this post">Like</button>
                @endauth

                <a href="{{route('post_details',$p->id)}}">View Details</a>
            </article>
        @endforeach
    </section>
</main>

<footer>
    @include('home.footer')
</footer>

<!-- Add JavaScript for likes/comments if not added before -->
<script src="/admincss/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-post').on('click', function() {
            const postId = $(this).data('id');
            $.post("{{route('like')}}", {
                _token: "{{csrf_token()}}",
                type: 'post',
                id: postId
            }, function(response) {
                alert(response.message);
            });
        });
    });
</script>
</body>
</html>
