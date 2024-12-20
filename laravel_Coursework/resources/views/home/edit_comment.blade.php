<!-- resources/views/home/edit_comment.blade.php -->

<div id="editCommentModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Comment</h2>
        <form id="editCommentForm" action="" method="POST" aria-label="Edit comment form">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="comment_text" class="block font-semibold">Comment</label>
                <textarea id="comment_text" name="comment_text" rows="4" required aria-required="true" class="w-full border p-2"></textarea>
                <p id="comment_error" class="text-red-600" role="alert"></p>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Open modal and populate with comment data
        $('.edit-comment-btn').on('click', function() {
            const commentId = $(this).data('id');
            const commentText = $(this).data('text');

            $('#editCommentForm').attr('action', `/comments/${commentId}/update`);
            $('#comment_text').val(commentText);
            $('#editCommentModal').show();
        });

        // Close the modal
        $('.close').on('click', function() {
            $('#editCommentModal').hide();
        });

        // Handle form submission via AJAX
        $('#editCommentForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    $('#editCommentModal').hide();
                    location.reload(); // Refresh to show updated comment
                },
                error: function(xhr) {
                    $('#comment_error').text(xhr.responseJSON.message || 'An error occurred.');
                }
            });
        });
    });
</script>
