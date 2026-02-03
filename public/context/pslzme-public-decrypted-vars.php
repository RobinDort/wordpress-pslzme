<?php

    $options = get_option('pslzme_settings', []);
    $dbConn = new PslzmeDatabaseConnection($options);
    $connection = $dbConn->get_connection();
    $decryptionController = new DecryptionController($connection);

    // Call the decrypt method to decrypt necessary variables
    $decryptionController->decrypt();

    // Init the vars for later use.
    $decryptedLinkCreator = $decryptFormData->get_decrypted_link_creator();
    $decryptedTitle = $decryptFormData->get_decrypted_title();
    $decryptedFirstName = $decryptFormData->get_decrypted_first_name();
    $decryptedLastName = $decryptFormData->get_decrypted_last_name();
    $decryptedCompanyName = $decryptFormData->get_decrypted_company_name();
    $decryptedCompanyGender = $decryptFormData->get_decrypted_company_gender();
    $decryptedGender = $decryptFormData->get_decrypted_gender();
    $decryptedAddress = $decryptFormData->get_decrypted_address();
    $decryptedHousenumber = $decryptFormData->get_decrypted_housenumber();
    $decryptedPostcode = $decryptFormData->get_decrypted_postcode();
    $decryptedPlace = $decryptFormData->get_decrypted_place();
    $decryptedCountry = $decryptFormData->get_decrypted_country();
    $decryptedPosition = $decryptFormData->get_decrypted_position();
    $decryptedCurl = $decryptFormData->get_decrypted_curl();
    $decryptedFC = $decryptFormData->get_decrypted_fc();


    if ($decryptedLinkCreator !== null && $decryptedLinkCreator !== "") {
        $GLOBALS['pslzme_decryptedVars']['linkCreator'] = $decryptedLinkCreator;  
    }
    
    if ($decryptedTitle !== null && $decryptedTitle !== "") {
        $GLOBALS['pslzme_decryptedVars']['title'] = $decryptedTitle;  
    }
    
    if ($decryptedFirstName !== null && $decryptedFirstName !== "") {
        $GLOBALS['pslzme_decryptedVars']['firstName'] = $decryptedFirstName;  
    }
    
    if ($decryptedLastName !== null && $decryptedLastName !== "") {
        $GLOBALS['pslzme_decryptedVars']['lastName'] = $decryptedLastName;  
    }
    
    if ($decryptedCompanyName !== null && $decryptedCompanyName !== "") {
        $GLOBALS['pslzme_decryptedVars']['company'] = $decryptedCompanyName;  
    }
    
    if ($decryptedCompanyGender !== null) {
        $GLOBALS['pslzme_decryptedVars']['companyGender'] = $decryptedCompanyGender;  
    }
    
    if ($decryptedGender !== null && $decryptedGender !== "") {
        $GLOBALS['pslzme_decryptedVars']['gender'] = $decryptedGender;  
    }

    if ($decryptedAddress !== null && $decryptedAddress !== "") {
        $GLOBALS['pslzme_decryptedVars']['address'] = $decryptedAddress;  
    }

    if ($decryptedHousenumber !== null && $decryptedHousenumber !== "") {
        $GLOBALS['pslzme_decryptedVars']['housenumber'] = $decryptedHousenumber;  
    }
    
    if ($decryptedPostcode !== null && $decryptedPostcode !== "") {
        $GLOBALS['pslzme_decryptedVars']['postcode'] = $decryptedPostcode;  
    }

    if ($decryptedPlace !== null && $decryptedPlace !== "") {
        $GLOBALS['pslzme_decryptedVars']['place'] = $decryptedPlace;  
    }
    
    if ($decryptedCountry !== null && $decryptedCountry !== "") {
        $GLOBALS['pslzme_decryptedVars']['country'] = $decryptedCountry;  
    }
    
    if ($decryptedPosition !== null && $decryptedPosition !== "") {
        $GLOBALS['pslzme_decryptedVars']['position'] = $decryptedPosition;  
    }
    
    if ($decryptedCurl !== null && $decryptedCurl !== "") {
        $GLOBALS['pslzme_decryptedVars']['curl'] = $decryptedCurl;  
    }
    
    if ($decryptedFC !== null && $decryptedFC !== "") {
        $GLOBALS['pslzme_decryptedVars']['fc'] = $decryptedFC;  
    }
    
    
    if (!empty($decryptedLinkCreator) && !empty($decryptedFirstName) && !empty($decryptedLastName)) {
            $GLOBALS['decryptedVars']['varsSet'] = true;
    } else {
            $GLOBALS['decryptedVars']['varsSet'] = false;
    }

?>