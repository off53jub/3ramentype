<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <h1 class="page-title">
            <?php
            if (is_home()) {
                echo 'Information';
            } elseif (is_archive()) {
                the_archive_title();
            } else {
                the_title();
            }
            ?>
        </h1>

        <?php if (have_posts()) : ?>
            <div class="news-grid">
                <?php while (have_posts()) : the_post();
                    $event_label = sa_event_label();
                    $event_date  = sa_event_date();
                ?>
                    <article class="news-card">
                        <div class="news-card__body">
                            <div class="news-card__meta">
                                <?php if ($event_label) : ?>
                                    <span class="news-card__label"><?php echo esc_html($event_label); ?></span>
                                <?php endif; ?>
                                <time class="news-card__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                                    <?php echo esc_html($event_date); ?>
                                </time>
                            </div>
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
