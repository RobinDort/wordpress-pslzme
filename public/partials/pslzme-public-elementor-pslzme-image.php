<?php

/**
 * Provide a public-facing view for the pslzme image elementor widget.
 *
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/public/partials
 */
?>

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$decryptionController = DecryptionController::get_instance();
$varsSet = $decryptionController->vars_set();

$personalized_text = $settings['pslzme_image_personalized_text'] ?? '';
$unpersonalized_text = $settings['pslzme_image_unpersonalized_text'] ?? '';

$personalized_texts = $settings['pslzme_image_personalized_texts'] ?? [];
$unpersonalized_texts = $settings['pslzme_image_unpersonalized_texts'] ?? [];

$background_image_id    = $settings['pslzme_image_background']['id'] ?? '';
$background_image_url   = $settings['pslzme_image_background']['url'] ?? '';
$background_image_size  = $settings['pslzme_image_background_size'] ?? 'full';
$background_image_alt   = $settings['pslzme_image_background_alt_text'] ?? '';
$background_image_title = $settings['pslzme_image_background_title'] ?? '';

$foreground_image_id    = $settings['pslzme_image_foreground']['id'] ?? '';
$foreground_image_url   = $settings['pslzme_image_foreground']['url'] ?? '';
$foreground_image_size  = $settings['pslzme_image_foreground_size'] ?? 'full';
$foreground_image_alt   = $settings['pslzme_image_foreground_alt_text'] ?? '';
$foreground_image_title = $settings['pslzme_image_foreground_title'] ?? '';
?>


<div class="pslzme-ov-image-container">
    <?php if($background_image_url) : ?>
        <?php
            $bg_img_size = $background_image_size;
            $bg_img_src  = wp_get_attachment_image_src( $background_image_id, $bg_img_size )[0] ?? $background_image_url;
        ?>
        
        <div class="pslzme-background-figure">
            <img src="<?= esc_url($bg_img_src) ?>" alt="<?= esc_attr($background_image_alt) ?>" title="<?= esc_attr($background_image_title) ?>" />
        </div>

    <?php endif; ?>

    <?php if($varsSet && !empty($personalized_texts)): ?>

        <div class="pslzme-image-flex-container">

            <?php foreach ($personalized_texts as $ptItem):
                $ptext = $ptItem['text'] ?? '';
                $horizontal_alignment = $ptItem['horizontal_position'] ?? 'left';
                $vertical_alignment = $ptItem['vertical_position'] ?? 'start';
                $text_color = $uptItem['text_color'] ?? '#000000';
                $text_spacing = $uptItem['text_spacing'] ?? [];
                $unit = $text_spacing['unit'] ?? 'px';
                $top = $text_spacing['top'] ?? 0;
                $right = $text_spacing['right'] ?? 0;
                $bottom = $text_spacing['bottom'] ?? 0;
                $left = $text_spacing['left'] ?? 0;
                $text_padding = $uptItem['text_padding'] ?? [];
                $punit = $text_padding['unit'] ?? 'px';
                $ptop = $text_padding['top'] ?? 0;
                $pright = $text_padding['right'] ?? 0;
                $pbottom = $text_padding['bottom'] ?? 0;
                $pleft = $text_padding['left'] ?? 0;
            ?>

                <div class="pslzme_image ce_text block layered-text"
                    style="display: flex;
                    justify-content: <?= esc_attr($horizontal_alignment); ?>;
                    align-items: <?= esc_attr($vertical_alignment); ?>;
                    color: <?= esc_attr($text_color); ?>;
                    margin: <?= esc_attr($top) . esc_attr($unit) ?> 
                            <?= esc_attr($right) . esc_attr($unit) ?> 
                            <?= esc_attr($bottom) . esc_attr($unit) ?> 
                            <?= esc_attr($left) . esc_attr($unit) ?>;
                    padding:<?= esc_attr($ptop) . esc_attr($punit) ?> 
                            <?= esc_attr($pright) . esc_attr($punit) ?> 
                            <?= esc_attr($pbottom) . esc_attr($punit) ?> 
                            <?= esc_attr($pleft) . esc_attr($punit) ?>;">
                    <?= wp_kses_post($ptext) ?>
                </div>

            <?php endforeach; ?>

        </div>
    <?php else: ?>

        <div class="pslzme-image-flex-container">

            <?php foreach ($unpersonalized_texts as $uptItem):
                $upText = $uptItem['text'];
                $horizontal_alignment = $uptItem['horizontal_position'] ?? 'left';
                $vertical_alignment = $uptItem['vertical_position'] ?? 'start';
                $text_spacing = $uptItem['text_spacing'] ?? [];
                $text_color = $uptItem['text_color'] ?? '#000000';
                $unit = $text_spacing['unit'] ?? 'px';
                $top = $text_spacing['top'] ?? 0;
                $right = $text_spacing['right'] ?? 0;
                $bottom = $text_spacing['bottom'] ?? 0;
                $left = $text_spacing['left'] ?? 0;
                $text_padding = $uptItem['text_padding'] ?? [];
                $punit = $text_padding['unit'] ?? 'px';
                $ptop = $text_padding['top'] ?? 0;
                $pright = $text_padding['right'] ?? 0;
                $pbottom = $text_padding['bottom'] ?? 0;
                $pleft = $text_padding['left'] ?? 0;
            ?>
                <div class="pslzme_image ce_text block layered-text" 
                    style="display: flex;
                    justify-content: <?= esc_attr($horizontal_alignment); ?>;
                    align-items: <?= esc_attr($vertical_alignment); ?>;
                    color: <?= esc_attr($text_color); ?>;
                    margin: <?= esc_attr($top) . esc_attr($unit) ?> 
                            <?= esc_attr($right) . esc_attr($unit) ?> 
                            <?= esc_attr($bottom) . esc_attr($unit) ?> 
                            <?= esc_attr($left) . esc_attr($unit) ?>;
                    padding:<?= esc_attr($ptop) . esc_attr($punit) ?> 
                        <?= esc_attr($pright) . esc_attr($punit) ?> 
                        <?= esc_attr($pbottom) . esc_attr($punit) ?> 
                        <?= esc_attr($pleft) . esc_attr($punit) ?>;">
                    <?= wp_kses_post($upText) ?>
                </div>

            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <?php if($foreground_image_url) : ?>
        <?php
            $fg_img_size = $foreground_image_size;
            $fg_img_src  = wp_get_attachment_image_src( $foreground_image_id, $fg_img_size )[0] ?? $foreground_image_url;
        ?>

        <div class="pslzme-foreground-figure">
            <img src="<?= esc_url($fg_img_src) ?>" alt="<?= esc_attr($foreground_image_alt) ?>" title="<?= esc_attr($foreground_image_title) ?>" />
        </div>
        
    <?php endif; ?>
</div>