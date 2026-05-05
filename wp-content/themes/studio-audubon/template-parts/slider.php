<?php
$performances = sa_get_performances();
if (empty($performances)) return;
$count = count($performances);
?>

<section class="poster-banner" id="posterBanner" aria-label="出演情報バナー">
    <div class="poster-banner__viewport">
        <div class="poster-banner__track" id="posterTrack">

            <?php foreach ($performances as $i => $perf) :
                $caption    = sa_field('caption_text', $perf->ID);
                $link       = sa_field('show_link',    $perf->ID);
                $poster_url = sa_performance_poster_url($perf->ID, 'large');
                $alt        = $caption ?: $perf->post_title;
                $tag        = $link ? 'a' : 'div';
                $href_attr  = $link ? ' href="' . esc_url($link) . '" target="_blank" rel="noopener"' : '';
            ?>
                <article class="poster-card" role="group" aria-label="ポスター <?php echo $i + 1; ?>">
                    <<?php echo $tag; ?> class="poster-card__link"<?php echo $href_attr; ?>>
                        <div class="poster-card__image">
                            <?php if ($poster_url) : ?>
                                <img src="<?php echo esc_url($poster_url); ?>"
                                     alt="<?php echo esc_attr($alt); ?>"
                                     loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>">
                            <?php else : ?>
                                <div class="poster-card__placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <?php if ($caption) : ?>
                            <p class="poster-card__caption"><?php echo esc_html($caption); ?></p>
                        <?php endif; ?>
                    </<?php echo $tag; ?>>
                </article>
            <?php endforeach; ?>

        </div>
    </div>

    <?php if ($count > 3) : ?>
        <div class="poster-banner__controls">
            <button class="poster-banner__btn poster-banner__btn--prev" id="posterPrev" aria-label="前へ">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="poster-banner__btn poster-banner__btn--next" id="posterNext" aria-label="次へ">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
    <?php endif; ?>
</section>
