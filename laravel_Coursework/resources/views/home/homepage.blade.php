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
    @include('home.app')
    @include('home.like_comment')

</main>
<footer>
    @include('home.footer')
</footer>
</body>
</html>
