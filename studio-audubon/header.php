<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="siteHeader">
    <div class="header-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?>">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                $logo_path = get_template_directory() . '/assets/images/logo.png';
                $logo_uri  = get_template_directory_uri() . '/assets/images/logo.png';
                if (file_exists($logo_path)) {
                    echo '<img src="' . esc_url($logo_uri) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
                }
            }
            ?>
        </a>

        <nav class="main-nav" aria-label="メインナビゲーション">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-list',
                'fallback_cb'    => function() {
                    echo '<ul class="nav-list">';
                    echo '<li><a href="' . home_url('/') . '">ホーム</a></li>';
                    echo '<li><a href="' . home_url('/news/') . '">Information</a></li>';
                    echo '<li><a href="' . home_url('/actors/') . '">アクター</a></li>';
                    echo '<li><a href="' . home_url('/about/') . '">アバウト</a></li>';
                    echo '<li><a href="' . home_url('/works/') . '">ワークス</a></li>';
                    echo '<li><a href="' . home_url('/contact/') . '">コンタクト</a></li>';
                    echo '</ul>';
                },
            ]);
            ?>
        </nav>

        <button class="menu-toggle" id="menuToggle" aria-label="メニューを開く" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
