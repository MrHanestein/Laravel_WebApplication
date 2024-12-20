<x-app-layout>
    <div class="p-6" role="main">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}. Use the links below to navigate:</p>
        <ul class="list-disc ml-5 mt-4">
            <li><a href="{{ route('homepage') }}" class="underline text-blue-600">View Posts</a></li>
            <li><a href="{{ route('show_post') }}" class="underline text-blue-600">Manage Your Posts (Admin or Your Own)</a></li>
            <li><a href="{{ url('notifications') }}" class="underline text-blue-600">View Your Notifications</a></li>
            <li><a href="{{ url('user_profile', Auth::user()->id) }}" class="underline text-blue-600">Your Profile</a></li>
        </ul>
    </div>
</x-app-layout>
