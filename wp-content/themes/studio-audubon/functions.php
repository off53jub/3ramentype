<?php

function sa_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => 'メインナビゲーション',
    ]);
}
add_action('after_setup_theme', 'sa_setup');

function sa_enqueue() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Noto+Sans+JP:wght@300;400;500;700&display=swap',
        [],
        null
    );
    wp_enqueue_style('sa-main', get_template_directory_uri() . '/assets/css/main.css', ['google-fonts'], '1.1.0');
    wp_enqueue_script('sa-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.1.0', true);

    // single-actor のみ html2pdf.js を読み込む
    if (is_singular('actor')) {
        wp_enqueue_script(
            'html2pdf',
            'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js',
            [],
            '0.10.1',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'sa_enqueue');

// ACF Local JSON
function sa_acf_json_load_point($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'sa_acf_json_load_point');

function sa_acf_json_save_point($path) {
    return get_template_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'sa_acf_json_save_point');

// 投稿（Information）に標準のタグを使えるようにする（既定で有効だが念のため明示）
function sa_post_supports_tags() {
    register_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'sa_post_supports_tags');

// カスタム投稿タイプ
function sa_register_post_types() {

    // キャスト
    register_post_type('actor', [
        'labels' => [
            'name'          => 'キャスト',
            'singular_name' => 'キャスト',
            'add_new_item'  => 'キャストを追加',
            'edit_item'     => 'キャストを編集',
            'not_found'     => 'キャストが見つかりません',
            'menu_name'     => 'キャスト',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'actors'],
        'menu_icon'     => 'dashicons-groups',
        'supports'      => ['title', 'thumbnail'],
        'show_in_rest'  => false,
        'menu_position' => 5,
    ]);

    // 作品
    register_post_type('work', [
        'labels' => [
            'name'          => '作品',
            'singular_name' => '作品',
            'add_new_item'  => '作品を追加',
            'edit_item'     => '作品を編集',
            'not_found'     => '作品が見つかりません',
            'menu_name'     => '作品',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'works'],
        'menu_icon'     => 'dashicons-video-alt2',
        'supports'      => ['title', 'editor', 'thumbnail'],
        'show_in_rest'  => false,
        'menu_position' => 6,
    ]);

    // バナー（出演情報）
    register_post_type('performance', [
        'labels' => [
            'name'          => 'バナー（出演情報）',
            'singular_name' => '出演情報',
            'add_new_item'  => '出演情報を追加',
            'edit_item'     => '出演情報を編集',
            'not_found'     => '出演情報が見つかりません',
            'menu_name'     => 'バナー',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-images-alt2',
        'supports'      => ['title', 'page-attributes'],
        'show_in_rest'  => false,
        'menu_position' => 4,
    ]);
}
add_action('init', 'sa_register_post_types');

// ACF / postmeta 共通取得
function sa_field($name, $post_id = null) {
    if (function_exists('get_field')) {
        return get_field($name, $post_id ?? false);
    }
    return get_post_meta($post_id ?? get_the_ID(), $name, true);
}

// 全キャスト（表示順）
function sa_get_all_actors() {
    return get_posts([
        'post_type'      => 'actor',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

// バナー用出演情報
function sa_get_performances() {
    return get_posts([
        'post_type'      => 'performance',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

// アイキャッチURL
function sa_thumbnail_url($post_id, $size = 'large') {
    $thumb = get_post_thumbnail_id($post_id);
    if (!$thumb) return '';
    $src = wp_get_attachment_image_src($thumb, $size);
    return $src ? $src[0] : '';
}

// イベント日付（無ければ投稿日）
function sa_event_date($post_id = null, $format = 'Y.m.d') {
    $post_id = $post_id ?: get_the_ID();
    $date    = sa_field('event_date', $post_id);
    if ($date) {
        return mysql2date($format, $date);
    }
    return get_the_date($format, $post_id);
}

// イベント種別ラベル
function sa_event_label($post_id = null) {
    return sa_field('event_label', $post_id ?: get_the_ID());
}

// アクター名と一致するタグの最新Information投稿を1件取得
function sa_get_latest_news_for_actor($actor_id) {
    $actor = get_post($actor_id);
    if (!$actor) return null;

    $tag = get_term_by('name', $actor->post_title, 'post_tag');
    if (!$tag || is_wp_error($tag)) return null;

    $posts = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'tax_query'      => [
            [
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $tag->term_id,
            ],
        ],
    ]);
    return !empty($posts) ? $posts[0] : null;
}

// バナー用ポスター画像URL（ACF または featured image）
function sa_performance_poster_url($post_id, $size = 'large') {
    $poster = sa_field('poster_image', $post_id);
    if (is_array($poster) && !empty($poster['url'])) {
        if ($size && !empty($poster['sizes'][$size])) return $poster['sizes'][$size];
        return $poster['url'];
    }
    if (is_string($poster) && $poster) return $poster;
    return sa_thumbnail_url($post_id, $size);
}
