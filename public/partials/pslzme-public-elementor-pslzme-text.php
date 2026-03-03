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
$showUnpersonalizedText = $settings['show_unpersonalized_text'] ?? '';

$decryptionController = DecryptionController::get_instance();
$varsSet = $decryptionController->vars_set();

?>

<?php if ($varsSet && $personalizedText !== '') : ?>
    <div class="pslzme-text ce_text block">
        <?= wp_kses_post($personalizedText) ?>
    </div>
<?php else : ?>
    <?php if ($showUnpersonalizedText === 'yes') : ?>
        <div class="pslzme-text ce_text block">
            <?= wp_kses_post($unpersonalizedText) ?>
        </div>
    <?php endif; ?>
<?php endif; ?>