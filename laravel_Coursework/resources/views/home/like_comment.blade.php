<!-- Add JavaScript for likes/comments if not added before -->
<script src="/admincss/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-post').on('click', function() {
            const postId = $(this).data('id');
            $.post("{{route('like')}}", {
                _token: "{{csrf_token()}}",
                type: 'post',
                id: postId
            }, function(response) {
                alert(response.message);
            });
        });
    });
</script>
