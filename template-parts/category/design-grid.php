<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>TRAYL</title>
    <?php get_template_part('template-parts/head'); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/grid.css">
    <!-- jsライブラリの読み込み（スライドショー） -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <?php wp_head(); ?>
</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6SD1GRBX7H"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6SD1GRBX7H');
</script>

<body>
<?php get_template_part('template-parts/header'); ?>

    <div class="line"></div>
    <div class="category-name">
    <?php
    // 現在のカテゴリオブジェクトを取得
    $category = get_queried_object();

    // カテゴリ名を取得
    $category_name = $category->name;

    // カテゴリのカスタムテキストを取得
    $custom_text = get_term_meta($category->term_id, 'custom_text', true);
    ?>

    <!-- カテゴリ名を表示 -->
    <p class="category-name-english"><?php echo esc_html($category_name); ?></p>

    <!-- カスタムテキストを表示 -->
    <p class="category-name-japanese"><?php echo esc_html($custom_text); ?></p>
</div>

<ul class="corner-tag-list">
    <?php
    // 現在のカテゴリ ID を取得
    $category_id = get_queried_object_id();

    // 現在のカテゴリに属する投稿を取得
    $args = array(
        'cat' => $category_id, // 現在のカテゴリ ID
        'posts_per_page' => -1, // 全投稿を取得
        'fields' => 'ids', // 投稿 ID のみを取得
    );
    $query = new WP_Query($args);

    // すべての投稿 ID を取得
    $post_ids = $query->posts;

    // 投稿に登録されたすべてのタグを取得
    $tags = wp_get_object_terms($post_ids, 'post_tag', array('fields' => 'all'));

    // 現在選択されているタグ（クエリパラメータ）を取得
    $current_tag_slug = get_query_var('tag');

    // #ALLタグのリンク
    echo '<li class="tag_name"><a href="' . esc_url(get_category_link($category_id)) . '" class="' . (empty($current_tag_slug) ? 'selected' : '') . '">#ALL</a></li>';

    // タグがある場合のみループ処理
    if (!empty($tags) && !is_wp_error($tags)) {
        foreach ($tags as $tag) {
            // 各タグをリスト表示
            echo '<li class="tag_name"><a href="' . esc_url(get_category_link($category_id)) . '?tag=' . urlencode($tag->slug) . '" class="' . ($current_tag_slug == $tag->slug ? 'selected' : '') . '">#' . esc_html($tag->name) . '</a></li>';
        }
    } else {
        echo '<li class="tag_name">タグがありません</li>';
    }

    // WP_Queryをリセット
    wp_reset_postdata();
    ?>
</ul>

<div class="double_border"></div>

<?php
// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// タグのクエリパラメータを取得
$tag_slug = get_query_var('tag');

// クエリの引数を設定
$args = array(
    'posts_per_page' => 24, // 1ページあたりの投稿数
    'paged'          => $paged, // 現在のページ番号
    'cat'            => get_queried_object_id(), // 現在のカテゴリIDを取得
);

// タグが指定されていない（ALLが選ばれている）場合、タグの絞り込みを外す
if ($tag_slug && $tag_slug != 'all') {
    $args['tag'] = $tag_slug;  // タグが指定されている場合は絞り込み
}

// クエリを実行
$the_query = new WP_Query($args);

if ($the_query->have_posts()) :
    // 投稿の総数と現在の投稿の範囲を計算
    $total_posts = $the_query->found_posts; // 総投稿数
    $start_post = ($paged - 1) * $args['posts_per_page'] + 1; // 現在のページの最初の投稿番号
    $end_post = min($paged * $args['posts_per_page'], $total_posts); // 現在のページの最後の投稿番号
    ?>
    <div class="article_grid_view">
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php
            if (has_post_thumbnail()) :
                $id = get_post_thumbnail_id();
                $img = wp_get_attachment_image_src($id, 'large');
            else :
                $img = array(get_template_directory_uri() . '/image/thumbnail.png');
            endif;
            ?>
            <a href="<?php the_permalink(); ?>" class="list-view-link">
                <div class="list-view-content">
                    <div class="article_thumbnail">
                        <img src="<?php echo $img[0]; ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                    <div class="whatsnew-text">
                        <p class="article_date"><?php the_time(get_option('date_format')); ?></p>
                        <p class="article_title"><?php the_title(); ?></p>
                    </div>
                </div>
            </a>
        <?php endwhile; ?>
    </div>

    <!-- カスタムページネーション -->
    <div class="pager-container">
        <div class="pager">
            <!-- 前のページへのリンク -->
            <?php if ($paged > 1) : ?>
                <div class="back">
                    <a href="<?php echo get_pagenum_link($paged - 1); ?>">&larr;</a>
                </div>
            <?php endif; ?>

            <!-- 現在の投稿範囲と総投稿数 -->
            <p>
                <?php echo $end_post . '/' . $total_posts; ?>
            </p>

            <!-- 次のページへのリンク -->
            <?php if ($paged < $the_query->max_num_pages) : ?>
                <div class="next">
                    <a href="<?php echo get_pagenum_link($paged + 1); ?>">&rarr;</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p class="no-content">Coming Soon...</p>
<?php endif; ?>




<?php get_template_part('template-parts/footer'); ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script.js"></script>
    <?php wp_footer(); ?>
</body>

</html>