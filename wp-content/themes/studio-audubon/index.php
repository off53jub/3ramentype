<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <h1 class="page-title">
            <?php
            if (is_home()) {
                echo 'ニュース';
            } elseif (is_archive()) {
                the_archive_title();
            } else {
                the_title();
            }
            ?>
        </h1>

        <?php if (have_posts()) : ?>
            <div class="news-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="news-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="news-card__thumb">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        <?php endif; ?>
                        <div class="news-card__body">
                            <time class="news-card__date" datetime="<?php echo get_the_date('Y-m-d'); ?>">
                                <?php echo get_the_date('Y.m.d'); ?>
                            </time>
                            <h2 class="news-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="news-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 40); ?></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php the_posts_pagination(['mid_size' => 2]); ?>
            </div>
        <?php else : ?>
            <p class="no-content">記事が見つかりませんでした。</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
