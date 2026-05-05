<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <h1 class="page-title">Works</h1>

        <?php if (have_posts()) : ?>
            <div class="poster-grid">
                <?php while (have_posts()) : the_post();
                    $poster_url = sa_thumbnail_url(get_the_ID(), 'large');
                    $caption    = sa_field('caption_text');
                ?>
                    <article class="poster-card">
                        <a href="<?php the_permalink(); ?>" class="poster-card__link">
                            <div class="poster-card__image">
                                <?php if ($poster_url) : ?>
                                    <img src="<?php echo esc_url($poster_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                <?php else : ?>
                                    <div class="poster-card__placeholder"></div>
                                <?php endif; ?>
                            </div>
                            <p class="poster-card__title"><?php the_title(); ?></p>
                            <?php if ($caption) : ?>
                                <p class="poster-card__caption"><?php echo esc_html($caption); ?></p>
                            <?php endif; ?>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php the_posts_pagination(['mid_size' => 2]); ?>
            </div>
        <?php else : ?>
            <p class="no-content">作品情報はまだ登録されていません。</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
