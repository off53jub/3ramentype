<?php get_header(); ?>

<?php get_template_part('template-parts/slider'); ?>

<main class="site-main">

    <!-- 最新ニュース -->
    <section class="section section--news">
        <div class="container">
            <h2 class="section-title">News</h2>
            <div class="news-grid news-grid--home">
                <?php
                $news_query = new WP_Query([
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                ]);
                while ($news_query->have_posts()) : $news_query->the_post();
                ?>
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
                            <h3 class="news-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="section-more">
                <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn-more">ニュース一覧</a>
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

    <!-- ワークス -->
    <section class="section section--works">
        <div class="container">
            <h2 class="section-title">Works</h2>
            <div class="work-grid work-grid--home">
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
                    $work_type  = sa_field('work_type', $work->ID);
                    $period     = sa_field('work_period', $work->ID);
                ?>
                    <a href="<?php echo get_permalink($work->ID); ?>" class="work-card">
                        <div class="work-card__poster">
                            <?php if ($poster_url) : ?>
                                <img src="<?php echo esc_url($poster_url); ?>" alt="<?php echo esc_attr($work->post_title); ?>">
                            <?php else : ?>
                                <div class="work-card__placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="work-card__info">
                            <?php if ($work_type) : ?>
                                <span class="work-card__type"><?php echo esc_html($work_type); ?></span>
                            <?php endif; ?>
                            <h3 class="work-card__title"><?php echo esc_html($work->post_title); ?></h3>
                            <?php if ($period) : ?>
                                <p class="work-card__period"><?php echo esc_html($period); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="section-more">
                <a href="<?php echo esc_url(home_url('/works/')); ?>" class="btn-more">ワークス一覧</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
