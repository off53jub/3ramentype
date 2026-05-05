<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $photo_url = sa_thumbnail_url(get_the_ID(), 'large');
    $name_en   = sa_field('actor_name_en');
    $profile   = sa_field('actor_profile');
    $birthday  = sa_field('actor_birthday');
    $height    = sa_field('actor_height');
?>

<main class="site-main">
    <div class="container">
        <article class="actor-profile">

            <div class="actor-profile__photo-col">
                <?php if ($photo_url) : ?>
                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php the_title_attribute(); ?>" class="actor-profile__photo">
                <?php else : ?>
                    <div class="actor-profile__photo-placeholder"></div>
                <?php endif; ?>
            </div>

            <div class="actor-profile__info-col">
                <h1 class="actor-profile__name"><?php the_title(); ?></h1>
                <?php if ($name_en) : ?>
                    <p class="actor-profile__name-en"><?php echo esc_html($name_en); ?></p>
                <?php endif; ?>

                <?php if ($birthday || $height) : ?>
                    <dl class="actor-profile__data">
                        <?php if ($birthday) : ?>
                            <dt>生年月日</dt>
                            <dd><?php echo esc_html($birthday); ?></dd>
                        <?php endif; ?>
                        <?php if ($height) : ?>
                            <dt>身長</dt>
                            <dd><?php echo esc_html($height); ?></dd>
                        <?php endif; ?>
                    </dl>
                <?php endif; ?>

                <?php if ($profile) : ?>
                    <div class="actor-profile__text">
                        <?php echo nl2br(esc_html($profile)); ?>
                    </div>
                <?php endif; ?>
            </div>

        </article>

        <div class="single-post__back">
            <a href="<?php echo esc_url(home_url('/actors/')); ?>" class="btn-back">&larr; アクター一覧に戻る</a>
        </div>
    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
