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
$fogEnabled = $settings['pslzme_3d_fog_enabled'] ?? 'yes';
$fogColor = $settings['pslzme_3d_fog_color'] ?? '#222222';
$mirrored = $settings['pslzme_3d_mirrored'] ?? 'yes';
$movingLight = $settings['pslzme_3d_moving_light'] ?? 'yes';
$rotationEnabled = $settings['pslzme_3d_rotation'] ?? 'yes';
$rotationDirection = $settings['pslzme_3d_rotation_direction'] ?? 'left';
$draggable = $settings['pslzme_3d_draggable'] ?? 'yes';
$floorEnabled = $settings['pslzme_3d_floor_enabled'] ?? 'yes';
$debugUiEnabled = $settings['pslzme_3d_debug_ui'] ?? 'no';
$cameraPositionX = $settings['pslzme_3d_camera_position_x'] ?? 0;
$cameraPositionY = $settings['pslzme_3d_camera_position_y'] ?? 150;
$cameraPositionZ = $settings['pslzme_3d_camera_position_z'] ?? 700;
$cameraTargetX = $settings['pslzme_3d_camera_target_x'] ?? 0;
$cameraTargetY = $settings['pslzme_3d_camera_target_y'] ?? 115;
$cameraTargetZ = $settings['pslzme_3d_camera_target_z'] ?? 0;

$usedText = $varsSet && !empty($personalized_text) ? $personalized_text : $unpersonalized_text;
?>

<div class="pslzme-3d-text <?= $draggable ? 'pslzme-3d-text-draggable' : '' ?>" 
    data-3d-text="<?= esc_attr( $usedText ) ?>"
    data-background="<?= esc_attr( $scene_background ) ?>"
    data-highlight-color-one="<?= esc_attr( $highlight_color_one ) ?>"
    data-highlight-color-two="<?= esc_attr( $highlight_color_two ) ?>"
    data-highlight-color-three="<?= esc_attr( $highlight_color_three ) ?>"
    data-fog-enabled="<?= esc_attr( $fogEnabled ) ?>"
    data-fog-color="<?= esc_attr( $fogColor ) ?>"
    data-mirrored="<?= esc_attr( $mirrored ) ?>"
    data-moving-light="<?= esc_attr( $movingLight ) ?>"
    data-rotation-enabled="<?= esc_attr( $rotationEnabled) ?>"
    data-rotation-direction="<?= esc_attr( $rotationDirection ) ?>"
    data-draggable="<?= esc_attr( $draggable ) ?>"
    data-floor-enabled="<?= esc_attr( $floorEnabled) ?>"
    data-debug-ui="<?= esc_attr( $debugUiEnabled ) ?>"
    data-camera-pos-x="<?= esc_attr($cameraPositionX) ?>"
    data-camera-pos-x-tablet="<?= esc_attr($settings['pslzme_3d_camera_position_x_tablet'] ?? $cameraPositionX) ?>"
    data-camera-pos-x-mobile="<?= esc_attr($settings['pslzme_3d_camera_position_x_mobile'] ?? $cameraPositionX) ?>"

    data-camera-pos-y="<?= esc_attr($cameraPositionY) ?>"
    data-camera-pos-y-tablet="<?= esc_attr($settings['pslzme_3d_camera_position_y_tablet'] ?? $cameraPositionY) ?>"
    data-camera-pos-y-mobile="<?= esc_attr($settings['pslzme_3d_camera_position_y_mobile'] ?? $cameraPositionY) ?>"

    data-camera-pos-z="<?= esc_attr($cameraPositionZ) ?>"
    data-camera-pos-z-tablet="<?= esc_attr($settings['pslzme_3d_camera_position_z_tablet'] ?? $cameraPositionZ) ?>"
    data-camera-pos-z-mobile="<?= esc_attr($settings['pslzme_3d_camera_position_z_mobile'] ?? $cameraPositionZ) ?>"

    data-camera-target-x="<?= esc_attr($cameraTargetX) ?>"
    data-camera-target-x-tablet="<?= esc_attr($settings['pslzme_3d_camera_target_x_tablet'] ?? $cameraTargetX) ?>"
    data-camera-target-x-mobile="<?= esc_attr($settings['pslzme_3d_camera_target_x_mobile'] ?? $cameraTargetX) ?>"

    data-camera-target-y="<?= esc_attr($cameraTargetY) ?>"
    data-camera-target-y-tablet="<?= esc_attr($settings['pslzme_3d_camera_target_y_tablet'] ?? $cameraTargetY) ?>"
    data-camera-target-y-mobile="<?= esc_attr($settings['pslzme_3d_camera_target_y_mobile'] ?? $cameraTargetY) ?>"

    data-camera-target-z="<?= esc_attr($cameraTargetZ) ?>"
    data-camera-target-z-tablet="<?= esc_attr($settings['pslzme_3d_camera_target_z_tablet'] ?? $cameraTargetZ) ?>"
    data-camera-target-z-mobile="<?= esc_attr($settings['pslzme_3d_camera_target_z_mobile'] ?? $cameraTargetZ) ?>">
</div>