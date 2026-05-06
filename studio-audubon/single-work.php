<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $poster_url = sa_thumbnail_url(get_the_ID(), 'large');
    $work_type  = sa_field('work_type');
    $period     = sa_field('work_period');
    $venue      = sa_field('work_venue');
    $cast_list  = sa_field('work_cast_list');
?>

<main class="site-main">
    <div class="container">
        <article class="work-detail">

            <div class="work-detail__poster-col">
                <?php if ($poster_url) : ?>
                    <img src="<?php echo esc_url($poster_url); ?>" alt="<?php the_title_attribute(); ?>" class="work-detail__poster">
                <?php else : ?>
                    <div class="work-detail__poster-placeholder"></div>
                <?php endif; ?>
            </div>

            <div class="work-detail__info-col">
                <?php if ($work_type) : ?>
                    <span class="work-detail__type"><?php echo esc_html($work_type); ?></span>
                <?php endif; ?>

                <h1 class="work-detail__title"><?php the_title(); ?></h1>

                <?php if ($period || $venue) : ?>
                    <dl class="work-detail__data">
                        <?php if ($period) : ?>
                            <dt>公演期間</dt>
                            <dd><?php echo esc_html($period); ?></dd>
                        <?php endif; ?>
                        <?php if ($venue) : ?>
                            <dt>会場</dt>
                            <dd><?php echo esc_html($venue); ?></dd>
                        <?php endif; ?>
                    </dl>
                <?php endif; ?>

                <?php if (have_posts()) : ?>
                    <div class="work-detail__description">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($cast_list)) : ?>
                    <div class="work-detail__cast">
                        <h2 class="work-detail__cast-heading">出演キャスト</h2>
                        <ul class="work-detail__cast-list">
                            <?php foreach ($cast_list as $actor) : ?>
                                <li>
                                    <a href="<?php echo get_permalink($actor->ID); ?>">
                                        <?php echo esc_html($actor->post_title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

        </article>

        <div class="single-post__back">
            <a href="<?php echo esc_url(home_url('/works/')); ?>" class="btn-back">&larr; ワークス一覧に戻る</a>
        </div>
    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
