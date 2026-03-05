<?php

/**
 * Provide a public-facing view for the pslzme content elementor widget.
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

$unpersonalized_text = $settings['pslzme_3d_unpersonalized_text'] ?? '';
$personalized_text = $settings['pslzme_3d_personalized_text'] ?? '';
$scene_background = $settings['pslzme_3d_scene_background'] ?? '#222222';
$highlight_color_one = $settings['pslzme_3d_highlight_color_one'] ?? '#a4dd46';
$highlight_color_two = $settings['pslzme_3d_highlight_color_two'] ?? '#0000ff';
$highlight_color_three = $settings['pslzme_3d_highlight_color_three'] ?? '#ff0000';

$usedText = $varsSet && $personalized_text ? $personalized_text : $unpersonalized_text;
?>

<div class="pslzme-3d-text" 
    data-3d-text="<?= esc_attr( $usedText ) ?>"
    data-background="<?= esc_attr( $scene_background ) ?>"
    data-highlight-color-one="<?= esc_attr( $highlight_color_one ) ?>"
    data-highlight-color-two="<?= esc_attr( $highlight_color_two ) ?>"
    data-highlight-color-three="<?= esc_attr( $highlight_color_three ) ?>">
</div>