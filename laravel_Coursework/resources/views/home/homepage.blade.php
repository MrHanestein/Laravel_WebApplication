<!-- resources/views/home/homepage.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.homecss')
    <title>Homepage</title>
</head>
<body>
@include('sweetalert::alert')
<header>
    @include('home.header')
</header>

<main>
    @include('home.banner')
    @include('home.services')
    @include('home.about')
    @include('home.user_profile')
    @include('home.edit_comment')
    @include('home.notifications')<!-- New Partial for editing comments via AJAX -->



    @auth
        @include('home.auth')
    @endauth
    @include('home.app')
    @include('home.like_comment')

</main>
<footer>
    @include('home.footer')
</footer>
</body>
</html>
