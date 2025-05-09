<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    // Index implementation for user login
    public function index()
    {
        if (Auth::check()) {
            $post = Post::with('tags')->get();
            $profileUser = Auth::user();
            $notifications = $profileUser->notifications()->orderBy('created_at', 'desc')->get();
            $usertype = $profileUser->usertype;

            if ($usertype == 'user') {
                return view('home.homepage', compact('post', 'profileUser', 'notifications'));
            } elseif ($usertype == 'admin') {
                return view('admin.index');
            } else {
                return redirect()->back();
            }
        }

        // If not authenticated, redirect to login
        return redirect()->route('login')->with('message', 'Please log in to access the homepage.');
    }

    // Homepage Method
    public function homepage()
    {
        $post = Post::with('tags')->get();
        $profileUser = Auth::user();
        $notifications = Auth::check()
            ? Auth::user()->notifications()->orderBy('created_at', 'desc')->get()
            : collect();

        return view('home.homepage', compact('post', 'profileUser', 'notifications'));
    }


    // Post Details
    public function post_details($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->back()->with('message', 'Post not found.');
        }

        return view('home.post_details', compact('post'));
    }

    // Create Post from Homepage
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->post_status = 'active';
        $post->user_id = $user->id;
        $post->name = $user->name;
        $post->usertype = $user->usertype;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('postimage'), $imagename);
            $post->image = $imagename;
        }

        $post->save();

        Alert::success('Post Created Successfully', 'Congratulations');

        return redirect()->back()->with('message', 'Post Added Successfully');
    }

    // Show Notifications
    public function showNotifications()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('message', 'Please log in to view notifications.');
        }

        // Fetch notifications ordered by creation date
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return view('home.notifications', compact('notifications'));
    }

    // User Profile
    public function userProfile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('message', 'User not found.');
        }

        return view('home.user_profile', compact('user'));
    }
    public function my_post()
    {
        return view('home.my_post');
    }
    public function markAllNotificationsAsRead()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('message', 'Please log in to view notifications.');
        }
    }
}
