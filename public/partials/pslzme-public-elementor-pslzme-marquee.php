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

$allowed_html['h1']['class'] = true;
$allowed_html['h2']['class'] = true;
$allowed_html['h3']['class'] = true;
$allowed_html['h4']['class'] = true;
$allowed_html['h5']['class'] = true;
$allowed_html['h6']['class'] = true;
$allowed_html['p']['class']  = true;
$allowed_html['span']['class'] = true;

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
            <div class="pslzme-marquee-text-track">
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