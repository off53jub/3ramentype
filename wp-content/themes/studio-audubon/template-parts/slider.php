<?php
$performances = sa_get_performances();
if (empty($performances)) return;
?>

<div class="hero-slider" id="heroSlider" aria-label="出演情報スライダー">

    <?php foreach ($performances as $i => $perf) :
        $cast_name  = sa_field('cast_name',   $perf->ID);
        $role_name  = sa_field('role_name',   $perf->ID);
        $show_title = sa_field('show_title',  $perf->ID);
        $period     = sa_field('show_period', $perf->ID);
        $link       = sa_field('show_link',   $perf->ID);
        $poster     = sa_field('poster_image', $perf->ID);
        $poster_url = is_array($poster) ? $poster['url'] : $poster;
        if (!$poster_url) $poster_url = sa_thumbnail_url($perf->ID, 'large');
    ?>
        <div class="slide<?php echo $i === 0 ? ' is-active' : ''; ?>" role="group" aria-label="スライド <?php echo $i + 1; ?>">
            <div class="slide__inner">

                <!-- 左：テキスト情報 -->
                <div class="slide__text">
                    <?php if ($cast_name) : ?>
                        <p class="slide__cast"><?php echo esc_html($cast_name); ?></p>
                    <?php endif; ?>
                    <?php if ($role_name) : ?>
                        <h2 class="slide__role">
                            <?php echo esc_html($role_name); ?>
                            <span class="slide__role-suffix">役出演</span>
                        </h2>
                    <?php endif; ?>
                    <?php if ($show_title) : ?>
                        <p class="slide__show"><?php echo esc_html($show_title); ?></p>
                    <?php endif; ?>
                    <?php if ($period) : ?>
                        <p class="slide__period"><?php echo esc_html($period); ?></p>
                    <?php endif; ?>
                    <?php if ($link) : ?>
                        <a href="<?php echo esc_url($link); ?>" class="slide__link" target="_blank" rel="noopener">
                            詳細を見る
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 右：ポスター画像 -->
                <div class="slide__poster">
                    <?php if ($poster_url) : ?>
                        <img src="<?php echo esc_url($poster_url); ?>"
                             alt="<?php echo esc_attr($show_title ?: $perf->post_title); ?> ポスター"
                             loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
                    <?php else : ?>
                        <div class="slide__poster-placeholder"></div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

    <?php if (count($performances) > 1) : ?>
        <div class="slider-controls">
            <button class="slider-btn slider-btn--prev" id="sliderPrev" aria-label="前のスライド">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <div class="slider-dots" id="sliderDots" role="tablist">
                <?php foreach ($performances as $i => $perf) : ?>
                    <button class="slider-dot<?php echo $i === 0 ? ' is-active' : ''; ?>"
                            role="tab"
                            aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                            aria-label="スライド <?php echo $i + 1; ?>">
                    </button>
                <?php endforeach; ?>
            </div>
            <button class="slider-btn slider-btn--next" id="sliderNext" aria-label="次のスライド">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    <?php endif; ?>

</div>
