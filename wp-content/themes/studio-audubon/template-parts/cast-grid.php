<?php
$actors = sa_get_all_actors();
if (empty($actors)) return;
?>

<section class="cast-grid-section" aria-label="所属キャスト">
    <div class="container">
        <h2 class="cast-grid-title">Cast</h2>
        <ul class="cast-grid">
            <?php foreach ($actors as $actor) :
                $photo_url = sa_thumbnail_url($actor->ID, 'thumbnail');
            ?>
                <li class="cast-grid__item">
                    <a href="<?php echo get_permalink($actor->ID); ?>" class="cast-grid__link">
                        <div class="cast-grid__photo">
                            <?php if ($photo_url) : ?>
                                <img src="<?php echo esc_url($photo_url); ?>"
                                     alt="<?php echo esc_attr($actor->post_title); ?>"
                                     loading="lazy">
                            <?php else : ?>
                                <div class="cast-grid__photo-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <span class="cast-grid__name"><?php echo esc_html($actor->post_title); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
