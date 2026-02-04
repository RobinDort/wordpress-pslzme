<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$decryptionController = DecryptionController::get_instance();
$varsSet = $decryptionController->vars_set();

$personalized_image_id    = $settings['pslzme_content_personalized_image']['id'] ?? '';
$personalized_image_url   = $settings['pslzme_content_personalized_image']['url'] ?? '';
$personalized_image_alt   = $settings['pslzme_content_personalized_image_alt'] ?? '';
$personalized_image_size  = $settings['pslzme_content_personalized_image_size'] ?? 'full';
$personalized_image_caption = $settings['pslzme_content_personalized_image_caption'] ?? '';
$personalized_image_link  = $settings['pslzme_content_personalized_image_link'] ?? '';

$unpersonalized_image_id    = $settings['pslzme_content_unpersonalized_image']['id'] ?? '';
$unpersonalized_image_url   = $settings['pslzme_content_unpersonalized_image']['url'] ?? '';
$unpersonalized_image_alt   = $settings['pslzme_content_unpersonalized_image_alt'] ?? '';
$unpersonalized_image_size  = $settings['pslzme_content_unpersonalized_image_size'] ?? 'full';
$unpersonalized_image_caption = $settings['pslzme_content_unpersonalized_image_caption'] ?? '';
$unpersonalized_image_link  = $settings['pslzme_content_unpersonalized_image_link'] ?? '';

$personalized_video_id = $settings['pslzme_content_personalized_video']['id'] ?? '';
$personalized_video_url = $settings['pslzme_content_personalized_video']['url'] ?? '';
$personalized_video_width = $settings['pslzme_content_personalized_video_width'] ?? 'full';
$personalized_video_height = $settings['pslzme_content_personalized_video_height'] ?? 'full';
$personalized_video_options = $settings['pslzme_content_personalized_video_options'] ?? [];

$unpersonalized_video_id = $settings['pslzme_content_unpersonalized_video']['id'] ?? '';
$unpersonalized_video_url = $settings['pslzme_content_unpersonalized_video']['url'] ?? '';
$unpersonalized_video_width = $settings['pslzme_content_unpersonalized_video_width'] ?? 'full';
$unpersonalized_video_height = $settings['pslzme_content_unpersonalized_video_height'] ?? 'full';
$unpersonalized_video_options = $settings['pslzme_content_unpersonalized_video_options'] ?? [];

?>

<?php if ($settings['pslzme_content_type'] === 'image'): ?>
    <?php if ($varsSet && $personalized_image_url) : ?>
        <?php
            $img_size = $personalized_image_size;
            $img_src  = wp_get_attachment_image_src( $personalized_image_id, $img_size )[0] ?? $personalized_image_url;
            $link_url = '';
            if ( $personalized_image_link ) {
                $link_url = get_permalink($personalized_image_link);
            }
        ?>

        <div class="ce_image pslzme-image">
            <a href="<?= esc_url($link_url) ?>">
                <img src="<?= esc_url($img_src) ?>" alt="<?= esc_attr($personalized_image_alt) ?>" />
                <?php if ( $personalized_image_caption ) : ?>
                    <figcaption><?= esc_html( $personalized_image_caption ); ?>
                    </figcaption>
                <?php endif; ?>
            </a>
        </div>
    
    <?php else : ?>
        <?php
            $img_size = $unpersonalized_image_size;
            $img_src = wp_get_attachment_image_src( $unpersonalized_image_id, $img_size )[0] ?? $unpersonalized_image_url;
            $link_url = '';
            if ( $unpersonalized_image_link ) {
                $link_url = get_permalink($unpersonalized_image_link);
            }
        ?>

        <div class="ce_image pslzme-image">
            <a href="<?= esc_url($link_url) ?>">
                <img src="<?= esc_url($img_src) ?>" alt="<?= esc_attr($unpersonalized_image_alt) ?>" />
                <?php if ( $unpersonalized_image_caption ) : ?>
                    <figcaption><?= esc_html( $unpersonalized_image_caption ); ?>
                    </figcaption>
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>

<?php elseif ($settings['pslzme_content_type'] === 'video'): ?>

    <?php if ($varsSet && $personalized_video_url) : ?>
        <?php
            // Use the URL from the media control
            $video_src = $personalized_video_url;

            // Video attributes
            $width  = intval($personalized_video_width);
            $height = intval($personalized_video_height);

            // Options
            $attrs = '';
            if (in_array('autoplay', $personalized_video_options)) {
                $attrs .= ' autoplay';
            }
            if (in_array('controls_hidden', $personalized_video_options)) {
                // If "controls_hidden" is set, don't add controls
            } else {
                $attrs .= ' controls';
            }
            if (in_array('loop', $personalized_video_options)) {
                $attrs .= ' loop';
            }
            if (in_array('playsinline', $personalized_video_options)) {
                $attrs .= ' playsinline';
            }
            if (in_array('muted', $personalized_video_options)) {
                $attrs .= ' muted';
            }
        ?>

        <div class="ce_video pslzme-video">
            <video width="<?= esc_attr($width) ?>" height="<?= esc_attr($height) ?>" <?= $attrs ?>>
                <source src="<?= esc_url($video_src) ?>" type="video/mp4">
                <?= esc_html__('Your browser does not support the video tag.', 'pslzme') ?>
            </video>
        </div>

    <?php else : ?>
        <?php
            // Use the URL from the media control
            $video_src = $unpersonalized_video_url;

            // Video attributes
            $width  = intval($unpersonalized_video_width);
            $height = intval($unpersonalized_video_height);

            // Options
            $attrs = '';
            if (in_array('autoplay', $unpersonalized_video_options)) {
                $attrs .= ' autoplay';
            }
            if (in_array('controls_hidden', $unpersonalized_video_options)) {
                // If "controls_hidden" is set, don't add controls
            } else {
                $attrs .= ' controls';
            }
            if (in_array('loop', $unpersonalized_video_options)) {
                $attrs .= ' loop';
            }
            if (in_array('playsinline', $unpersonalized_video_options)) {
                $attrs .= ' playsinline';
            }
            if (in_array('muted', $unpersonalized_video_options)) {
                $attrs .= ' muted';
            }
        ?>

        <div class="ce_video pslzme-video">
            <video width="<?= esc_attr($width) ?>" height="<?= esc_attr($height) ?>" <?= $attrs ?>>
                <source src="<?= esc_url($video_src) ?>" type="video/mp4">
                <?= esc_html__('Your browser does not support the video tag.', 'pslzme') ?>
            </video>
        </div>
        
    <?php endif; ?>

<?php endif; ?>