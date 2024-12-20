<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.homecss')
    <title>Notifications</title>
</head>
<body>
<header>
    @include('home.header')
</header>

<main role="main" class="p-6">
    <h1 class="text-2xl font-bold mb-4">Your Notifications</h1>
    @forelse($notifications as $notification)
        <div class="border p-4 mb-4 {{ $notification->read_at ? '' : 'bg-gray-100' }}">
            <p>{{ $notification->data['message'] ?? 'No message' }}</p>
            <small>{{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p>You have no notifications.</p>
    @endforelse

    <form action="{{ url('mark_all_notifications_as_read') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="underline text-blue-600">Mark all as read</button>
    </form>
</main>

@include('home.footer')
</body>
<!-- resources/views/home/notifications.blade.php -->

@auth
    <div style="text-align:center; margin:20px auto; padding:20px;">
        <h3>Your Notifications</h3>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <ul>
                @foreach(Auth::user()->unreadNotifications as $notification)
                    <li>{{$notification->data['message']}}</li>
                @endforeach
            </ul>
        @else
            <p>No new notifications.</p>
        @endif
        <a href="{{route('notifications')}}">View All Notifications</a>
    </div>
@endauth

</html>
