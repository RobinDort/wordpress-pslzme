<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$personalizedText = $settings['personalized_text'] ?? '';
$unpersonalizedText = $settings['unpersonalized_text'] ?? '';
$showUnpersonalized = $settings['show_unpersonalized_text'] ?? '';

$options = get_option('pslzme_settings', []);
$dbConn = new PslzmeDatabaseConnection($options);
$connection = $dbConn->get_connection();
$decryptionController = new DecryptionController($connection);

// Call the decrypt method to decrypt necessary variables
$decryptionController->decrypt();

// Init the vars for later use.
$decryptedLinkCreator = $decryptionController->get_decrypted_link_creator();
$decryptedTitle = $decryptionController->get_decrypted_title();
$decryptedFirstName = $decryptionController->get_decrypted_first_name();
$decryptedLastName = $decryptionController->get_decrypted_last_name();
$decryptedCompanyName = $decryptionController->get_decrypted_company_name();
$decryptedCompanyGender = $decryptionController->get_decrypted_company_gender();
$decryptedGender = $decryptionController->get_decrypted_gender();
$decryptedAddress = $decryptionController->get_decrypted_address();
$decryptedHousenumber = $decryptionController->get_decrypted_housenumber();
$decryptedPostcode = $decryptionController->get_decrypted_postcode();
$decryptedPlace = $decryptionController->get_decrypted_place();
$decryptedCountry = $decryptionController->get_decrypted_country();
$decryptedPosition = $decryptionController->get_decrypted_position();
$decryptedCurl = $decryptionController->get_decrypted_curl();
$decryptedFC = $decryptionController->get_decrypted_fc();

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
