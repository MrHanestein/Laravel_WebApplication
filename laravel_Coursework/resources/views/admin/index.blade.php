<!DOCTYPE html>
<html>
<head>
@include('admin.css')
</head>
<body>
@include('admin.header')
@include('admin.admin_dashboard')
<div class="d-flex align-items-stretch">
    @include('admin.sidebar')
    @include('admin.body')
        @include('admin.footer')
</body>
</html>

