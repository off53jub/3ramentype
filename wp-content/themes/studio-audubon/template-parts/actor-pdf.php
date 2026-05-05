<?php
/**
 * PDF生成用のアクタープロフィールレイアウト。
 * 通常時は display:none で隠しておき、html2pdf.js の対象として参照する。
 */
$pdf_post_id = isset($pdf_post_id) ? $pdf_post_id : get_the_ID();
$photo_url   = sa_thumbnail_url($pdf_post_id, 'large');
$name_jp     = get_the_title($pdf_post_id);
$name_en     = sa_field('actor_name_en', $pdf_post_id);
$profile     = sa_field('actor_profile', $pdf_post_id);
$birthday    = sa_field('actor_birthday', $pdf_post_id);
$height      = sa_field('actor_height', $pdf_post_id);
?>

<div id="pdfArea" class="pdf-area" aria-hidden="true">
    <div class="pdf-area__inner">

        <header class="pdf-area__header">
            <div class="pdf-area__brand">Studio Audubon</div>
            <div class="pdf-area__heading">PROFILE</div>
        </header>

        <div class="pdf-area__body">
            <div class="pdf-area__photo">
                <?php if ($photo_url) : ?>
                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($name_jp); ?>">
                <?php else : ?>
                    <div class="pdf-area__photo-empty"></div>
                <?php endif; ?>
            </div>

            <div class="pdf-area__info">
                <h1 class="pdf-area__name"><?php echo esc_html($name_jp); ?></h1>
                <?php if ($name_en) : ?>
                    <p class="pdf-area__name-en"><?php echo esc_html($name_en); ?></p>
                <?php endif; ?>

                <?php if ($birthday || $height) : ?>
                    <dl class="pdf-area__data">
                        <?php if ($birthday) : ?>
                            <dt>生年月日</dt><dd><?php echo esc_html($birthday); ?></dd>
                        <?php endif; ?>
                        <?php if ($height) : ?>
                            <dt>身長</dt><dd><?php echo esc_html($height); ?></dd>
                        <?php endif; ?>
                    </dl>
                <?php endif; ?>

                <?php if ($profile) : ?>
                    <div class="pdf-area__profile">
                        <?php echo nl2br(esc_html($profile)); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <footer class="pdf-area__footer">
            <span><?php echo esc_html(home_url('/')); ?></span>
            <span><?php echo date('Y.m.d'); ?></span>
        </footer>

    </div>
</div>
