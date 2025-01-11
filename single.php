<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>TRAYL</title>
    <?php get_template_part('template-parts/head'); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/single.css">
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

    <div class="post-info">
        <p class="category">
            <?php
            $categories = get_the_category(); // 投稿に紐づくカテゴリーを取得
            if (! empty($categories)) {
                echo esc_html($categories[0]->name); // 最初のカテゴリー名を出力
            }
            ?>
        </p>
        <p class="post-date">
            <?php echo get_the_date('Y.m.d'); ?>
        </p>
    </div>

    <h1 class="article-title"><?php the_title(); ?></h1>

    <ul class="article-tag">
    <ul class="tags">
    <?php
    $tags = get_the_tags(); // 投稿に関連付けられたタグを取得
    if ($tags) { // タグが存在する場合に処理
        foreach ($tags as $tag) {
            // 現在の投稿のカテゴリを取得
            $categories = get_the_category();
            $category_slug = isset($categories[0]) ? $categories[0]->slug : ''; // 最初のカテゴリスラッグを取得

            // タグの絞り込みURLを作成
            $tag_url = esc_url(get_tag_link($tag->term_id));
            $filtered_url = home_url('/category/' . $category_slug . '/?tag=' . $tag->slug);

            // 各タグをリストアイテムとして表示
            echo '<li class="tag_name"><a href="' . $filtered_url . '">#' . esc_html($tag->name) . '</a></li>';
        }
    } else {
        // タグがない場合の代替出力
        echo "";
    }
    ?>
</ul>

    </ul>

    <?php if ( has_post_thumbnail() ) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail('large', ['class' => 'responsive-thumbnail']); ?>
    </div>
<?php endif; ?>

    <div class="article-content">
        <?php the_content(); ?>
    </div>

    <?php get_template_part('template-parts/footer'); ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script.js"></script>
    <?php wp_footer(); ?>
</body>

</html>