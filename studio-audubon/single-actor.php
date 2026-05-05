<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $actor_id   = get_the_ID();
    $photo_url  = sa_thumbnail_url($actor_id, 'large');
    $name_jp    = get_the_title();
    $name_en    = sa_field('actor_name_en');
    $profile    = sa_field('actor_profile');
    $birthday   = sa_field('actor_birthday');
    $height     = sa_field('actor_height');
    $latest_news = sa_get_latest_news_for_actor($actor_id);
?>

<main class="site-main">
    <div class="container">
        <article class="actor-profile">

            <div class="actor-profile__photo-col">
                <?php if ($photo_url) : ?>
                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($name_jp); ?>" class="actor-profile__photo">
                <?php else : ?>
                    <div class="actor-profile__photo-placeholder"></div>
                <?php endif; ?>
            </div>

            <div class="actor-profile__info-col">
                <h1 class="actor-profile__name"><?php echo esc_html($name_jp); ?></h1>
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

        <!-- 関連 Information + PDF -->
        <section class="actor-meta-section" aria-label="関連情報">
            <div class="actor-meta-section__inner">

                <?php if ($latest_news) : ?>
                    <a href="<?php echo esc_url(get_permalink($latest_news->ID)); ?>" class="actor-related-news">
                        <span class="actor-related-news__label">最新の出演情報</span>
                        <span class="actor-related-news__title"><?php echo esc_html(get_the_title($latest_news->ID)); ?></span>
                        <span class="actor-related-news__date"><?php echo esc_html(sa_event_date($latest_news->ID)); ?></span>
                        <span class="actor-related-news__arrow">&rarr;</span>
                    </a>
                <?php endif; ?>

                <button type="button"
                        class="actor-pdf-btn"
                        id="downloadPdfBtn"
                        data-name="<?php echo esc_attr($name_jp); ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    PDFプロフィールをダウンロード
                </button>
            </div>
        </section>

        <div class="single-post__back">
            <a href="<?php echo esc_url(home_url('/actors/')); ?>" class="btn-back">&larr; アクター一覧に戻る</a>
        </div>
    </div>
</main>

<?php
// PDF生成用に隠した要素を出力
$pdf_post_id = $actor_id;
get_template_part('template-parts/actor-pdf');
?>

<?php endwhile; ?>

<?php get_footer(); ?>
