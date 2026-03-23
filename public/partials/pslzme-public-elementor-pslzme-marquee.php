<?php

/**
 * Provide a public-facing view for the pslzme text elementor widget.
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

$personalizedText = $settings['marquee_personalized_text'] ?? '';
$unpersonalizedText = $settings['marquee_unpersonalized_text'] ?? '';
$textDirection = $settings['marquee_text_direction'] ?? 'left';

$allowed_html = [
    'h1'    => ['class' => true],
    'h2'    => ['class' => true],
    'h3'    => ['class' => true],
    'h4'    => ['class' => true],
    'h5'    => ['class' => true],
    'h6'    => ['class' => true],
    'p'     => ['class' => true],
    'span'  => ['class' => true],
    'img'   => ['class' => true, 'src' => true, 'alt' => true, 'width' => true, 'height' => true]
];

$decryptionController = DecryptionController::get_instance();
$varsSet = $decryptionController->vars_set();

$content = '';

if ($varsSet && !empty($personalizedText)) {
    $content = $personalizedText;
} else {
    $content = $unpersonalizedText;
}

?>

<?php if (!empty($content)) : ?>
    <div class="pslzme-marquee">
        <div class="pslzme-marquee-text">
            <div class="pslzme-marquee-text-track <?= $textDirection === 'left' ? 'pslzme-marquee-text-anim-left' : 'pslzme-marquee-text-anim-right' ?> ">
                <div class="pslzme-marquee-item">
                    <?= wp_kses($content, $allowed_html) ?>
                </div>
                <div class="pslzme-marquee-item">
                    <?= wp_kses($content, $allowed_html) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>