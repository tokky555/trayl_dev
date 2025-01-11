jQuery(document).ready(function($) {
    // タグボタンをクリックしたときの処理
    $('.filter-button').on('click', function() {
        var tagSlug = $(this).data('tag');

        // AJAX リクエストを送信
        $.ajax({
            url: filterTags.ajax_url,
            type: 'GET',
            data: {
                action: 'filter_posts_by_tag',
                tag: tagSlug
            },
            success: function(response) {
                // 絞り込まれた投稿を表示
                $('#posts-list').html(response);
            }
        });
    });
});
