<?php get_header(); ?>

<main class="site-main">
    <div class="container container--narrow">
        <?php while (have_posts()) : the_post(); ?>
            <article class="single-post">
                <header class="single-post__header">
                    <time class="single-post__date" datetime="<?php echo get_the_date('Y-m-d'); ?>">
                        <?php echo get_the_date('Y.m.d'); ?>
                    </time>
                    <h1 class="single-post__title"><?php the_title(); ?></h1>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-post__thumb">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post__body">
                    <?php the_content(); ?>
                </div>

                <div class="single-post__back">
                    <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn-back">&larr; ニュース一覧に戻る</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
