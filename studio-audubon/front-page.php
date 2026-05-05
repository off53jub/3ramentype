<?php get_header(); ?>

<?php get_template_part('template-parts/slider'); ?>

<main class="site-main">

    <!-- Information -->
    <section class="section section--news">
        <div class="container">
            <h2 class="section-title">Information</h2>
            <div class="news-grid news-grid--home">
                <?php
                $news_query = new WP_Query([
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                ]);
                while ($news_query->have_posts()) : $news_query->the_post();
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
                            <h3 class="news-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="section-more">
                <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn-more">Information一覧</a>
            </div>
        </div>
    </section>

    <!-- アクター -->
    <section class="section section--actors section--alt">
        <div class="container">
            <h2 class="section-title">Actors</h2>
            <div class="actor-grid actor-grid--home">
                <?php
                $actors = get_posts([
                    'post_type'      => 'actor',
                    'posts_per_page' => 6,
                    'orderby'        => 'menu_order title',
                    'order'          => 'ASC',
                    'post_status'    => 'publish',
                ]);
                foreach ($actors as $actor) :
                    $photo_url = sa_thumbnail_url($actor->ID, 'medium');
                ?>
                    <a href="<?php echo get_permalink($actor->ID); ?>" class="actor-card">
                        <div class="actor-card__photo">
                            <?php if ($photo_url) : ?>
                                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($actor->post_title); ?>">
                            <?php else : ?>
                                <div class="actor-card__placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <p class="actor-card__name"><?php echo esc_html($actor->post_title); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="section-more">
                <a href="<?php echo esc_url(home_url('/actors/')); ?>" class="btn-more">アクター一覧</a>
            </div>
        </div>
    </section>

    <!-- ワークス（A4ポスター一覧） -->
    <section class="section section--works">
        <div class="container">
            <h2 class="section-title">Works</h2>
            <div class="poster-grid poster-grid--home">
                <?php
                $works = get_posts([
                    'post_type'      => 'work',
                    'posts_per_page' => 6,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                ]);
                foreach ($works as $work) :
                    $poster_url = sa_thumbnail_url($work->ID, 'medium');
                    $caption    = sa_field('caption_text', $work->ID);
                ?>
                    <article class="poster-card">
                        <a href="<?php echo get_permalink($work->ID); ?>" class="poster-card__link">
                            <div class="poster-card__image">
                                <?php if ($poster_url) : ?>
                                    <img src="<?php echo esc_url($poster_url); ?>" alt="<?php echo esc_attr($work->post_title); ?>" loading="lazy">
                                <?php else : ?>
                                    <div class="poster-card__placeholder"></div>
                                <?php endif; ?>
                            </div>
                            <p class="poster-card__title"><?php echo esc_html($work->post_title); ?></p>
                            <?php if ($caption) : ?>
                                <p class="poster-card__caption"><?php echo esc_html($caption); ?></p>
                            <?php endif; ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="section-more">
                <a href="<?php echo esc_url(home_url('/works/')); ?>" class="btn-more">ワークス一覧</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
