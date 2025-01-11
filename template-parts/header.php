<header class="top-header">
    <div class="openbtn">
        <!-- ハンバーガーメニューのアイコン -->
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/design/TRALロゴ_black.svg" alt="TRAILトップページ"></a></div>
    <div class="date-container">
        <p class="year"><?php echo date('Y'); ?> <?php $current_day_of_week_short = date('D');
                                                    echo strtoupper($current_day_of_week_short); ?></p>
        <p class="dateofweek"><?php echo date('m'); ?>.<?php echo date('d'); ?></p>
        <span class="date-bar"></span>
    </div>
    <?php get_template_part('template-parts/hamburger-menu'); ?>

    
</header>