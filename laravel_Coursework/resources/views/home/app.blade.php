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
