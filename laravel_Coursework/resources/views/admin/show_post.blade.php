<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('admin.css')
    <style type="text/css">
        .title_deg
        {
            font-size: 20px;
            font-weight: bold;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .table_deg
        {
            border: 2px solid pink;
            width: 70%;
            text-align: center;
            margin-left: 70px;
        }
        .th_deg
        {
            background-color: purple;
        }
        .img_deg
        {
            height: 90px;
            width: 160px;
            padding: 10px;
        }
    </style>
</head>
<body>
@include('admin.header')
<div class="d-flex align-items-stretch">
@include('admin.sidebar')
    <div class="page-content">
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {{session()->get('message')}}
            </div>
        @endif
        <h1 class="title_deg">All Post</h1>
        <table class="table_deg">
            <tr class="th_deg ">
                <th>Post Title</th>
                <th>Description</th>
                <th>Post By</th>
                <th>Post Status</th>
                <th>UserType</th>
                <th>Image</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>=-890-90-
            @foreach($post as $post)
            <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->description}}</td>
                <td>{{$post->name}}</td>
                <td>{{$post->post_status}}</td>
                <td>{{$post->usertype}}</td>
                <td>
                    <img class="img_deg" src="postimage/{{$post->image}}">
                </td>
                <td>
                    <form action="{{ route('delete_post', $post) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')   {{-- Tell Laravel to treat it as DELETE --}}
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this post?')">
                            Delete
                        </button>
                    </form>

                </td>
                <td>
                    <a href="{{url('edit_page',$post->id)}}" class="btn btn-success">Edit</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@include('admin.footer')
    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                title: "Are you sure to Delete this post",
                text: "You will not be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willCancel) => {
                    if (willCancel) {



                        window.location.href = urlToRedirect;

                    }


                });


        }
    </script>
</div>"
</body>
</html>

