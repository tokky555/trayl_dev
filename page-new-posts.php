<?php
/*
Template Name: 新着記事一覧
*/

?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>TRAIL</title>
    <?php get_template_part('template-parts/head'); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/list.css">
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
    <!-- 固定の見出し -->
    <h1 class="category-name-english">What's New</h1>
    <p class="category-name-japanese">新着記事一覧</p>
</div>

<ul class="corner-tag-list">
    <?php
    // サイト全体の投稿からタグを取得
    $tags = get_tags(array(
        'hide_empty' => true, // 投稿がないタグは除外
    ));

    // 現在選択されているタグ（クエリパラメータ）を取得
    $current_tag_slug = get_query_var('tag');

    // 新着記事一覧ページのスラッグを基にページオブジェクトを取得
    $new_posts_page = get_page_by_path('new-posts');
    
    // ページが見つかった場合にURLを取得
    if ($new_posts_page) {
        $new_posts_url = get_permalink($new_posts_page->ID);
    } else {
        $new_posts_url = home_url('/new-posts'); // デフォルトで指定のURLを設定
    }

    // #ALLタグのリンクを動的に設定
    echo '<li class="tag_name"><a href="' . esc_url($new_posts_url) . '" class="' . (empty($current_tag_slug) ? 'selected' : '') . '">#ALL</a></li>';

    // タグがある場合のみループ処理
    if (!empty($tags)) {
        foreach ($tags as $tag) {
            // 各タグをリスト表示
            echo '<li class="tag_name"><a href="' . esc_url(get_filtered_tag_link($tag->slug)) . '" class="' . ($current_tag_slug == $tag->slug ? 'selected' : '') . '">#' . esc_html($tag->name) . '</a></li>';
        }
    } else {
        echo '<li class="tag_name">タグがありません</li>';
    }
    ?>
</ul>





<div class="double_border"></div>

<!-- 投稿一覧 -->
<?php
// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// タグのクエリパラメータを取得
$tag_slug = get_query_var('tag');

// クエリの引数を設定
$args = array(
    'posts_per_page' => 24, // 1ページあたりの投稿数
    'paged'          => $paged, // 現在のページ番号
    'post_type'      => 'post', // 通常の投稿のみ
    'orderby'        => 'date', // 日付順
    'order'          => 'DESC', // 新しい順
);

// タグが指定されている場合、タグで絞り込み
if ($tag_slug && $tag_slug != 'all') {
    $args['tag'] = $tag_slug;
}

// クエリを実行
$the_query = new WP_Query($args);

if ($the_query->have_posts()) :
    // 投稿の総数と現在の投稿の範囲を計算
    $total_posts = $the_query->found_posts; // 総投稿数
    $start_post = ($paged - 1) * $args['posts_per_page'] + 1; // 現在のページの最初の投稿番号
    $end_post = min($paged * $args['posts_per_page'], $total_posts); // 現在のページの最後の投稿番号
    ?>
    <div class="post-list">
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
                    <div class="thum_box">
                        <img src="<?php echo $img[0]; ?>" alt="サムネイル1">
                    </div>
                    <div class="whatsnew-text">
                        <p class="whatsnew-date"><?php the_time(get_option('date_format')); ?></p>
                        <p class="whatsnew-title"><?php the_title(); ?></p>
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