            <!doctype html>
            <html lang="ja">

            <head>
                <meta charset="UTF-8">
                <title>TRAYL</title>
                <meta name="description" content="ちょっと寄り道してみるのもありかな、と一息つける逃げ場となるようなWEBマガジンを目指しています。">
                <meta name="viewport" content="width=device-width" ,initial-scale=1>
                <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/top.css">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
                <link rel="icon" type="image/svg" href="<?php echo get_template_directory_uri(); ?>/design/favicon.svg">
                <!-- jsライブラリの読み込み（スライドショー） -->
                <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
                <?php wp_head(); ?>
            </head>

            <body>
            <div id="home" class="header-overlay" style="background-image: url('<?php echo esc_url( get_theme_mod( 'trail_background_image' ) ); ?>');">
    <header class="top-header">
        <div class="openbtn">
            <!-- ハンバーガーメニューのアイコン -->
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/design/trayl_logo_white.svg" alt="TRAILトップページ"></a></div>
        <div class="date-container">
            <p class="year"><?php echo date('Y'); ?> <?php $current_day_of_week_short = date('D');
                                                        echo strtoupper($current_day_of_week_short); ?></p>
            <p class="dateofweek"><?php echo date('m'); ?>.<?php echo date('d'); ?></p>
            <span class="date-bar"></span>
        </div>
        <?php get_template_part('template-parts/hamburger-menu'); ?>
    </header>
    <div class="pickup-box">
        <?php
        // カスタムクエリで 'pickup' タグがついている最新の投稿を取得
        $args = array(
            'tag' => 'pickup',
            'posts_per_page' => 1,
        );
        $pickup_query = new WP_Query($args);

        if ($pickup_query->have_posts()) :
            while ($pickup_query->have_posts()) : $pickup_query->the_post();
                // 投稿が属している最初のカテゴリを取得
                $categories = get_the_category();
                $custom_text = '未分類';
                if (!empty($categories)) {
                    $category = $categories[0];
                    $custom_text = get_term_meta($category->term_id, 'custom_text', true);
                    // カスタムテキストが空の場合、カテゴリ名を表示する
                    if (empty($custom_text)) {
                        $custom_text = $category->name;
                    }
                }
        ?>
                <span>PICK UP</span>
                <div class="marquee">
                    <p>
                        <?php echo esc_html($custom_text); ?>　|　
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </p>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <span>PICK UP</span>
            <p>現在表示できる投稿はありません。</p>
        <?php endif; ?>
    </div>
</div>


                <div class="top-category-container">
                    <div class="menu-title-container">
                        <div class="balloon">
                            新しい記事
                        </div>
                        <h2 class="menu-title">What’s New</h2>
                    </div>
                    <div class="line"></div>

                    <?php if (have_posts()) : ?>
                        <?php $count = 0; // カウンターの初期化
                        ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php $count++; ?>
                            <?php if ($count > 3) { // カウンターが3を超えたらループ終了
                                break;
                            } ?>
                            <?php
                            if (has_post_thumbnail()):
                                $id = get_post_thumbnail_id();
                                $img = wp_get_attachment_image_src($id, 'large');
                            else:
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
                        <?php endwhile;
                        wp_reset_query(); ?>
                        <a href="<?php echo esc_url(home_url('/new-posts/')); ?>" class="viewall">
                            <div>view all</div>
                        </a>
                </div>
            <?php else : ?>
                <p class="no-content">Coming Soon...</p>
            <?php endif; ?>
            <div class="gallery">
                <div class="menu-title-container">
                    <div class="balloon">
                        フォトギャラリー
                    </div>
                    <h2 class="menu-title">GALLERY</h2>
                </div>
                <div class="slider-container">
                    <ul class="slider">
                        <?php
                        // 最新の10件の「ギャラリー」投稿を取得
                        $args = array(
                            'post_type' => 'gallery', // カスタム投稿タイプ「ギャラリー」
                            'posts_per_page' => 10,   // 最新10件
                            'post_status' => 'publish' // 公開された投稿のみ
                        );
                        $gallery_query = new WP_Query($args);

                        // ループ処理
                        if ($gallery_query->have_posts()) :
                            while ($gallery_query->have_posts()) : $gallery_query->the_post();
                                // ギャラリー投稿の画像を取得（カスタムフィールドの例として「image」）
                                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // サムネイル画像のURLを取得
                                if ($image_url) : ?>
                                    <li><img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>"></li>
                            <?php endif;
                            endwhile;
                            wp_reset_postdata(); // 投稿データをリセット
                        else : ?>
                            <li>画像がありません</li>
                        <?php endif; ?>
                    </ul>

                </div>
                <a href="<?php echo esc_url(home_url('/gallery/')); ?>" class="viewall">
                    <div>view all</div>
                </a>

            </div>

            <div class="categories-list">
                <div class="menu-title-container">
                    <div class="balloon">
                        カテゴリー
                    </div>
                    <?php get_template_part('template-parts/menu-list'); ?>
                </div>
            </div>

            <div class="top-category-container">
                <div class="menu-title-container">
                    <div class="balloon">
                        管理人の雑記
                    </div>
                    <h2 class="menu-title">RANDOM NOTES</h2>
                </div>
                <div class="line"></div>
                <?php
                // クエリ設定（カテゴリ「blog」の投稿を取得）
                $args = array(
                    'posts_per_page' => 3, // 表示する記事数
                    'category_name' => 'blog', // カテゴリ「blog」の投稿を取得
                );

                $the_query = new WP_Query($args);

                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();
                        if (has_post_thumbnail()):
                            $id = get_post_thumbnail_id();
                            $img = wp_get_attachment_image_src($id, 'large');
                        else:
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
                    <?php
                    endwhile;
                    wp_reset_postdata(); // $postを元に戻す
                    ?>
                    <a href="<?php echo esc_url(home_url('/category/blog/')); ?>" class="viewall">
                        <div>view all</div>
                    </a>
                <?php else : ?>
                    <p class="no-content">Coming Soon...</p>
                <?php endif; ?>
            </div>


            <footer>
            <?php get_template_part('template-parts/footer'); ?>
            </footer>

            <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
            <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script.js"></script>
            <?php wp_footer(); ?>
            </body>

            </html>