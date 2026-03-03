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

$personalizedText = $settings['personalized_text'] ?? '';
$unpersonalizedText = $settings['unpersonalized_text'] ?? '';
$showUnpersonalized = $settings['show_unpersonalized_text'] ?? '';
$textColor = $settings['text_color'] ?? '';
$fontSize  = $settings['text_typography_font_size']['size'] ?? '';
$fontUnit  = $settings['text_typography_font_size']['unit'] ?? 'px';


$style = '';

if (!empty($textColor)) {
    $style .= 'color:' . esc_attr($textColor) . ';';
}

if (!empty($fontSize)) {
    $style .= 'font-size:' . esc_attr($fontSize . $fontUnit) . ';';
}

$allowed_html = wp_kses_allowed_html( 'post' );

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
} elseif ($showUnpersonalized === 'yes') {
    $content = $unpersonalizedText;
}
 $content = preg_replace_callback(
    '/^<([a-z0-9]+)([^>]*)>/i',
    function ($matches) {

        if (strpos($matches[2], 'class=') !== false) {
            return preg_replace(
                '/class="([^"]*)"/',
                'class="$1 pslzme-text ce_text block"',
                $matches[0]
            );
        }

        return '<' . $matches[1] . $matches[2] . ' class="pslzme-text ce_text block">';
    },
    $content,
    1
);


?>

<?php if (!empty($content)) : ?>
            <?= wp_kses($content, $allowed_html); ?>
        </div>

<?php endif; ?>
