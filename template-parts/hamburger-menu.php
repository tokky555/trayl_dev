<div class="menu-open">
                            <div id="g-menu-list">
                                <div class="categories-list">
                                    <div class="menu-title-container">
                                        <img id="menu-open-logo" src="<?php echo get_template_directory_uri(); ?>/design/trayl_logo_black.svg" alt="TRAILトップページ">
                                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-form-001">
                                            <input type="text" name="s" placeholder="キーワードを入力">
                                            <button type="submit" aria-label="検索"></button>
                                        </form>


                                        <div class="balloon">
                                            カテゴリー
                                        </div>
                                        <?php get_template_part('template-parts/menu-list'); ?>
                                    </div>
                                </div>
                                <?php get_template_part('template-parts/footer'); ?>
                            </div>
                        </div>