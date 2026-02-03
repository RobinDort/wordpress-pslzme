<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$decryptedVars = $GLOBALS["decryptedVars"] ?? null;

?>


<?php if (!empty($this->decryptedVars)) : ?>
    <div class="ce_text block">
        <?= esc_attr($settings['personalized_text']) ?>
    </div>

<?php else : ?>
    <?php if ($settings['show_unpersonalized_text'] === true) : ?>
        <div class="ce_text block">
            <?= esc_attr($settings['unpersonalized_text']) ?>
        </div>
    <?php endif; ?>
<?php endif;