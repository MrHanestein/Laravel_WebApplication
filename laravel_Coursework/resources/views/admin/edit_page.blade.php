<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css')
    <style type="text/css">
        .post_title
        {
            font-size : 30px;
            font-weight:bold;
            text-align:center;
            padding: 30px;
            color: white;
        }
        .div_center
        {
            text-align: center;
            padding: 30px ;
        }
        label{
            display:inline-block;
            width: 200px;
        }
    </style>
</head>
<body>
@include('admin.header')
<div class="d-flex align-items-stretch">
@include('admin.sidebar')
    <div class="page-content">
        <h1 class="post_title">Update Post </h1>
        <form action="{{ route('update_post', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div>
                <form action="{{url('add_post')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="div_center">
                        <label>Post Title</label>
                        <input type="text" name="title" value="{{$post->title}}">
                    </div>
                    <div class="div_center">
                        <label>Add Description</label>
                        <textarea name="description">{{$post->description}}} </textarea>
                    </div>
                    <div class="div_center">
                        <label>Old image</label>
                        <img style="margin:auto" height="100px" width="150px" src="/postimage/{{$post->image}}">
                    </div>
                    <div class="div_center">
                        <label>Update Previous Image</label>
                        <input type="file" name="image">
                    </div>
                    <div class="div_center">
                        <input type="submit" value="Update" class="btn btn-primary mt-3">
                    </div>
        </form>
    </div>
@include('admin.footer')
</body>
</html>

