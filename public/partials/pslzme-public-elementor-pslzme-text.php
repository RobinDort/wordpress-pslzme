<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$personalizedText = $settings['personalized_text'] ?? '';
$unpersonalizedText = $settings['unpersonalized_text'] ?? '';
$showUnpersonalized = $settings['show_unpersonalized_text'] ?? '';

$decryptionController = DecryptionController::get_instance();
$varsSet = $decryptionController->vars_set();

?>

<?php if ($varsSet && $settings['personalized_text'] !== '') : ?>
    
    <div class="ce_text block">
        <?= wp_kses_post($personalizedText) ?>
    </div>

<?php else : ?>
    <?php if ($settings['show_unpersonalized_text'] === 'yes') : ?>
        <div class="ce_text block">
            <?= wp_kses_post($unpersonalizedText) ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
