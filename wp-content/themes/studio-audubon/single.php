<?php get_header(); ?>

<main class="site-main">
    <div class="container container--narrow">
        <?php while (have_posts()) : the_post();
            $event_label = sa_event_label();
            $event_date  = sa_event_date();
        ?>
            <article class="single-post">
                <header class="single-post__header">
                    <div class="single-post__meta">
                        <?php if ($event_label) : ?>
                            <span class="single-post__label"><?php echo esc_html($event_label); ?></span>
                        <?php endif; ?>
                        <time class="single-post__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                            <?php echo esc_html($event_date); ?>
                        </time>
                    </div>
                    <h1 class="single-post__title"><?php the_title(); ?></h1>
                </header>

                <div class="single-post__body">
                    <?php the_content(); ?>
                </div>

                <?php
                $tags = get_the_tags();
                if ($tags) :
                ?>
                    <div class="single-post__tags">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="single-post__tag">#<?php echo esc_html($tag->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="single-post__back">
                    <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn-back">&larr; Information一覧に戻る</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
