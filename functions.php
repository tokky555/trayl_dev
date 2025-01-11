<?php
add_action('init', function(){
    add_theme_support('post-thumbnails');
});

// カテゴリにカスタムフィールドを追加
function add_category_custom_fields($tag) {
    // 現在のカテゴリIDを取得
    $cat_id = $tag->term_id;

    // 現在のカスタムメタデータの値を取得
    $custom_text = get_term_meta($cat_id, 'custom_text', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="custom_text">カスタムテキスト</label>
        </th>
        <td>
            <input type="text" name="custom_text" id="custom_text" value="<?php echo esc_attr($custom_text); ?>" />
            <p class="description">このカテゴリに関連付けたいテキストを入力してください。</p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'add_category_custom_fields');

// カスタムメタデータを保存
function save_category_custom_fields($term_id) {
    if (isset($_POST['custom_text'])) {
        update_term_meta($term_id, 'custom_text', sanitize_text_field($_POST['custom_text']));
    }
}
add_action('edited_category', 'save_category_custom_fields');

// カスタム投稿タイプの登録
function register_gallery_post_type() {
    $labels = array(
        'name'               => 'ギャラリー',
        'singular_name'      => 'ギャラリー',
        'add_new'            => '新規追加',
        'add_new_item'       => 'ギャラリーを追加',
        'edit_item'          => 'ギャラリーを編集',
        'new_item'           => '新しいギャラリー',
        'view_item'          => 'ギャラリーを見る',
        'search_items'       => 'ギャラリーを検索',
        'not_found'          => 'ギャラリーが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にギャラリーはありません',
        'menu_name'          => 'ギャラリー'
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-gallery',
        'taxonomies'         => array('post_tag'), // ここでタグを追加
    );
    register_post_type('gallery', $args);
}
add_action('init', 'register_gallery_post_type');

// ギャラリー投稿タイプにアイキャッチ画像の列を追加
function add_gallery_thumbnail_column($columns) {
    $columns['thumbnail'] = 'アイキャッチ画像'; // 新しい列を追加
    return $columns;
}
add_filter('manage_edit-gallery_columns', 'add_gallery_thumbnail_column');

// アイキャッチ画像を表示
function display_gallery_thumbnail_column($column, $post_id) {
    if ($column == 'thumbnail') {
        // アイキャッチ画像が設定されている場合はプレビューを表示
        $thumbnail = get_the_post_thumbnail($post_id, 'thumbnail');
        if ($thumbnail) {
            echo $thumbnail;
        } else {
            echo 'アイキャッチ画像なし'; // アイキャッチ画像が設定されていない場合
        }
    }
}
add_action('manage_gallery_posts_custom_column', 'display_gallery_thumbnail_column', 10, 2);

// カテゴリとタグの絞り込みリンクを生成する関数
function get_filtered_tag_link($tag_slug) {
    // 現在のカテゴリIDを取得
    $category_id = get_queried_object_id();
    
    // カテゴリのアーカイブURLを取得
    $category_link = get_category_link($category_id);
    
    // タグで絞り込んだURLを生成（タグスラッグをエンコード）
    return add_query_arg('tag', urlencode($tag_slug), $category_link);
}

// 検索機能
function modify_search_query( $query ) {
    if ( $query->is_search && !is_admin() ) {
        // 投稿タイプを指定
        $query->set( 'post_type', 'post' );
        // 公開された投稿のみ
        $query->set( 'post_status', 'publish' );

        // タグを検索対象に追加
        if ( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
            $search_term = sanitize_text_field( $_GET['s'] );  // 検索キーワードの取得

            // タグを検索対象に追加する
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => 'post_tag',  // タグ（post_tag）を検索対象に指定
                    'field'    => 'name',      // タグの名前で検索
                    'terms'    => $search_term, // 入力された検索キーワード
                    'operator' => 'LIKE',       // 部分一致で検索
                ),
            ));
        }
    }
}
add_action( 'pre_get_posts', 'modify_search_query' );

function trail_customize_register( $wp_customize ) {
    // セクションを追加
    $wp_customize->add_section( 'trail_background_section', array(
        'title'       => 'トップページ背景',
        'description' => 'トップページの背景画像を設定します。',
        'priority'    => 30,
    ) );

    // 背景画像の設定を追加
    $wp_customize->add_setting( 'trail_background_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );

    // 背景画像のコントロールを追加
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'trail_background_image_control', array(
        'label'    => '背景画像',
        'section'  => 'trail_background_section',
        'settings' => 'trail_background_image',
    ) ) );
}
add_action( 'customize_register', 'trail_customize_register' );

function my_custom_ga4_tracking() {
    echo "
    <script async src=\"https://www.googletagmanager.com/gtag/js?id=G-G-6SD1GRBX7H\"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-G-6SD1GRBX7H');
    </script>
    ";
}
add_action('wp_head', 'my_custom_ga4_tracking');
