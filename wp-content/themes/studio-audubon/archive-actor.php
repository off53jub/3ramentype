<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <h1 class="page-title">Actors</h1>

        <?php if (have_posts()) : ?>
            <div class="actor-grid actor-grid--full">
                <?php while (have_posts()) : the_post();
                    $photo_url = sa_thumbnail_url(get_the_ID(), 'medium');
                ?>
                    <a href="<?php the_permalink(); ?>" class="actor-card">
                        <div class="actor-card__photo">
                            <?php if ($photo_url) : ?>
                                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div class="actor-card__placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <p class="actor-card__name"><?php the_title(); ?></p>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="no-content">キャスト情報はまだ登録されていません。</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
