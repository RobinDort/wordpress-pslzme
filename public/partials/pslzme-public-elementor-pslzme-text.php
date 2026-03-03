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
$marqueeMinHeight = $settings['marquee_min_height']['size'] ?? 0;
$marqueeUnit      = $settings['marquee_min_height']['unit'] ?? 'px';


$style = '';

if (!empty($textColor)) {
    $style .= 'color:' . esc_attr($textColor) . ';';
}

if (!empty($fontSize)) {
    $style .= 'font-size:' . esc_attr($fontSize . $fontUnit) . ';';
}

$marqueeContainerStyle = '';
$fontStyle = '';

if ($enableMarquee === 'yes' && !empty($marqueeMinHeight)) {
    $marqueeContainerStyle = 'min-height:' . esc_attr($marqueeMinHeight . $marqueeUnit) . ';';
    $fontStyle = 'font-size:' . esc_attr($marqueeMinHeight . $marqueeUnit) . '; line-height:1;';
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

$enableMarquee = $settings['enable_marquee'] ?? 'no';

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
    <?php if ($enableMarquee === 'yes') : ?>
        <div class="marquee">
            <div class="marquee-text">
                <div class="marquee-text-track">
                    <div class="marquee-item">
                        <?= wp_kses($content, $allowed_html) ?>
                    </div>
                    <div class="marquee-item">
                        <?= wp_kses($content, $allowed_html) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?= wp_kses($content, $allowed_html); ?>
    <?php endif; ?>
<?php endif; ?>
