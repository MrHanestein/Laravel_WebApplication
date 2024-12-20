<!DOCTYPE html>
<html>
<head>
    @include('admin.css')

    <style type="text/css">
        .post_title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }
        .div_center {
            text-align: center;
            padding: 30px ;
        }
        label {
            display: inline-block;
            width: 200px;
        }
    </style>
</head>
<body>
@include('admin.header')
<div class="d-flex align-items-stretch">
    @include('admin.sidebar')
    <div class="page-content">
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h1 class="post_title">Add Post</h1>
        <div>
            <form action="{{ route('add_post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="div_center">
                    <label>Post Title</label>
                    <input type="text" name="title" required>
                </div>
                <div class="div_center">
                    <label>Add Description</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="div_center">
                    <label>Add Image</label>
                    <input type="file" name="image" accept="image/*">
                </div>
                <div class="div_center">
                    <input type="submit" value="Submit" class="btn btn-primary mt-3">
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.footer')
</body>
</html>
