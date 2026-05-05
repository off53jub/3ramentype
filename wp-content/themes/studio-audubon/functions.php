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
    wp_enqueue_style('sa-main', get_template_directory_uri() . '/assets/css/main.css', ['google-fonts'], '1.0.0');
    wp_enqueue_script('sa-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'sa_enqueue');

// ACF Local JSON: テーマのフィールド定義を自動読み込み
function sa_acf_json_load_point($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'sa_acf_json_load_point');

function sa_acf_json_save_point($path) {
    return get_template_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'sa_acf_json_save_point');

// カスタム投稿タイプ登録
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

    // 出演情報（ヘッダースライダー用）
    register_post_type('performance', [
        'labels' => [
            'name'          => 'スライダー（出演情報）',
            'singular_name' => '出演情報',
            'add_new_item'  => '出演情報を追加',
            'edit_item'     => '出演情報を編集',
            'not_found'     => '出演情報が見つかりません',
            'menu_name'     => 'スライダー',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-slides',
        'supports'      => ['title', 'page-attributes'],
        'show_in_rest'  => false,
        'menu_position' => 4,
    ]);
}
add_action('init', 'sa_register_post_types');

// ACF が有効な場合もそうでない場合も動作するフィールド取得ヘルパー
function sa_field($name, $post_id = null) {
    if (function_exists('get_field')) {
        return get_field($name, $post_id ?? false);
    }
    return get_post_meta($post_id ?? get_the_ID(), $name, true);
}

// 全キャストを表示順で取得
function sa_get_all_actors() {
    return get_posts([
        'post_type'      => 'actor',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

// スライダー用出演情報を取得
function sa_get_performances() {
    return get_posts([
        'post_type'      => 'performance',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

// アイキャッチ画像 URL を取得（サイズ指定付き）
function sa_thumbnail_url($post_id, $size = 'large') {
    $thumb = get_post_thumbnail_id($post_id);
    if (!$thumb) return '';
    $src = wp_get_attachment_image_src($thumb, $size);
    return $src ? $src[0] : '';
}
