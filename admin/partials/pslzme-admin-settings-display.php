<?php
/**
 * Provide a admin area view for the plugins admin settings
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/admin/partials
 */

$options = get_option('pslzme_settings', []);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
 <div class="wrap">
    <h1><?= esc_html__("Pslzme Configuration", "pslzme") ?></h1>
    <div class="pslzme-configuration-container">
        <h2><?= esc_html__("Pslzme configuration 1", "pslzme") ?></h2>
        <div class="pslzme-explanation">
            <p><?= esc_html__("explanation 1", "pslzme") ?></p>
            <p><?= esc_html__("explanation 2", "pslzme") ?></p>
        </div>

        <div class="pslzme-configuration-step">
            <h3><?= esc_html__("configuration step 1", "pslzme") ?></h3>
            <div class="pslzme-explanation">
                <p><?= esc_html__("explanation 3", "pslzme") ?></p>
                <p><?= esc_html__("explanation 4", "pslzme") ?></p>
            </div>
        </div>

        <div class="pslzme-configuration-step">
            <div class="pslzme-explanation">
                <h3><?= esc_html__("configuration step 2", "pslzme") ?></h3>
                <p><?= esc_html__("explanation 5", "pslzme") ?></p>
            </div>

            <div class="pslzme-db-configuration">
                <!-- SETTINGS FORM -->
               <form method="post" action="options.php" class="pslzme-settings-form">
                    <?php settings_fields('pslzme_settings_group'); ?>
                    <?php do_settings_fields('pslzme_settings', 'pslzme_db_section'); ?>
                    <?php submit_button(__('Save', 'pslzme')); ?>
                </form>
            </div>
        </div>

        <div class="pslzme-configuration-step">
            <div class="pslzme-explanation">
                <h3><?= esc_html__("configuration step 3", "pslzme") ?></h3>
                <p><?= esc_html__("explanation 6", "pslzme") ?></p>
                <?php if(!empty($options["tables_configured"])): ?>
                    <p><?= esc_html__("tables configured", "pslzme") ?></p>
                <?php else : ?>
                    <button id="create-tables-sbmt" type="submit"><?= esc_html__("configure tables", "pslzme") ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="pslzme-configuration-container">
        <h2><?= esc_html__("Pslzme configuration 2", "pslzme") ?></h2>
        <div class="pslzme-explanation">
            <p><?= esc_html__("explanation 7", "pslzme") ?></p>
            <p><?= esc_html__("explanation 8", "pslzme") ?></p>

            <?php if (!empty($options["url_licensed"])): ?>
                <p><?= esc_html__("url licensed", "pslzme") ?></p>
            <?php else : ?>
                <button id="license-domain-sbmt" type="submit"><?= esc_html__("license domain", "pslzme") ?></button>
            <?php endif; ?>
        </div>
    </div>

    <div class="pslzme-configuration-container">
        <h2><?= esc_html__("Pslzme configuration 3", "pslzme") ?></h2>
        <p><?= esc_html__("explanation 9", "pslzme") ?></p>
        <p><?= esc_html__("explanation 10", "pslzme") ?></p>
        <p><?= esc_html__("explanation 11", "pslzme") ?></p>
        <div class="pslzme-internal-pages-fields">
            <form method="post" action="options.php" class="pslzme-settings-form">
                <?php settings_fields('pslzme_settings_group'); ?>
                <?php do_settings_fields('pslzme_settings', 'pslzme_ip_section'); ?>
                <?php submit_button(__('Save', 'pslzme')); ?>
            </form>
        </div>
    </div>
</div>