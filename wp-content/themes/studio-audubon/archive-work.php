<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <h1 class="page-title">Works</h1>

        <?php if (have_posts()) : ?>
            <div class="work-grid work-grid--full">
                <?php while (have_posts()) : the_post();
                    $poster_url = sa_thumbnail_url(get_the_ID(), 'medium');
                    $work_type  = sa_field('work_type');
                    $period     = sa_field('work_period');
                ?>
                    <a href="<?php the_permalink(); ?>" class="work-card">
                        <div class="work-card__poster">
                            <?php if ($poster_url) : ?>
                                <img src="<?php echo esc_url($poster_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div class="work-card__placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="work-card__info">
                            <?php if ($work_type) : ?>
                                <span class="work-card__type"><?php echo esc_html($work_type); ?></span>
                            <?php endif; ?>
                            <h2 class="work-card__title"><?php the_title(); ?></h2>
                            <?php if ($period) : ?>
                                <p class="work-card__period"><?php echo esc_html($period); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
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
