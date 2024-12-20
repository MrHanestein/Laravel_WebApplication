<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a New Post</title>
</head>
<body>
@auth
    <main style="text-align:center; margin:20px auto; padding:20px;">
        <h2>Create a New Post</h2>
        <form action="{{route('create_post')}}" method="POST" enctype="multipart/form-data"
              style="display:inline-block; text-align:left; background:#f9f9f9; padding:20px; border-radius:5px;"
              role="form" aria-labelledby="create-post-heading">
            @csrf
            <fieldset>
                <legend id="create-post-heading" class="sr-only">Create a New Post Form</legend>

                <div style="margin-bottom:1em;">
                    <label for="title">Title <span aria-hidden="true">*</span></label><br>
                    <input type="text" id="title" name="title" required aria-required="true" style="width:100%;">
                </div>

                <div style="margin-bottom:1em;">
                    <label for="description">Description <span aria-hidden="true">*</span></label><br>
                    <textarea id="description" name="description" rows="5" cols="40" required aria-required="true" style="width:100%;"></textarea>
                </div>

                <div style="margin-bottom:1em;">
                    <label for="image">Image (optional)</label><br>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary" aria-label="Add New Post">Add Post</button>
            </fieldset>
        </form>
    </main>
@endauth
</body>
</html>
