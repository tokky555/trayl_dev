<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>TRAIL</title>
    <?php get_template_part('template-parts/head'); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/gallery.css">
    <!-- jsライブラリの読み込み（スライドショー） -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Fancybox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet" />
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
    


    <p class="photo_contact"><br>写真撮影のご依頼：reitokky555@gmail.com</p>

    <?php
// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// ギャラリー投稿タイプの投稿を取得
$args = array(
    'post_type'      => 'gallery',    // カスタム投稿タイプ「gallery」
    'posts_per_page' => 24,           // 1ページあたりの投稿数
    'paged'          => $paged,       // ページネーション
);

// クエリを実行
$gallery_query = new WP_Query($args);

if ($gallery_query->have_posts()) :
    // 総投稿数を取得
    $total_posts = $gallery_query->found_posts; // 総投稿数

    // 現在のページの最初と最後の投稿番号を計算
    $start_post = ($paged - 1) * $args['posts_per_page'] + 1; // 現在のページの最初の投稿番号
    $end_post = min($paged * $args['posts_per_page'], $total_posts); // 現在のページの最後の投稿番号
    ?>
    <div class="article_grid_view">
        <?php
        while ($gallery_query->have_posts()) :
            $gallery_query->the_post();
            if (has_post_thumbnail()) :
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                ?>
                <a href="<?php echo $thumbnail_url; ?>" class="gallery-item" data-fancybox="gallery">
                    <img class="article_item" src="<?php echo $thumbnail_url; ?>" alt="<?php the_title(); ?>">
                </a>
                <?php
            endif;
        endwhile;
        ?>
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
            <?php if ($paged < $gallery_query->max_num_pages) : ?>
                <div class="next">
                    <a href="<?php echo get_pagenum_link($paged + 1); ?>">&rarr;</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    wp_reset_postdata(); // WP_Queryのリセット
else :
    echo '<p>ギャラリーに投稿はありません。</p>';
endif;
?>

    </div>

    <?php get_template_part('template-parts/footer'); ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script.js"></script>
    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <?php wp_footer(); ?>
</body>

</html>