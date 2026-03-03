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

    <?php if($varsSet && $personalized_text) : ?>

         <div class="pslzme_image ce_text block layered-text">
            <?= wp_kses_post($personalized_text) ?>
        </div>

    <?php else: ?>

        <div class="pslzme_image ce_text block layered-text">
            <?= wp_kses_post($unpersonalized_text) ?>
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