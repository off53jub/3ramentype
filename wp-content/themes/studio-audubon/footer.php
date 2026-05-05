
<?php get_template_part('template-parts/cast-grid'); ?>

<footer class="site-footer">
    <div class="footer-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
            <?php bloginfo('name'); ?>
        </a>
        <nav class="footer-nav" aria-label="フッターナビゲーション">
            <a href="<?php echo esc_url(home_url('/actors/')); ?>">アクター</a>
            <a href="<?php echo esc_url(home_url('/works/')); ?>">ワークス</a>
            <a href="<?php echo esc_url(home_url('/news/')); ?>">ニュース</a>
            <a href="<?php echo esc_url(home_url('/about/')); ?>">アバウト</a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>">コンタクト</a>
        </nav>
        <p class="footer-copy">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
