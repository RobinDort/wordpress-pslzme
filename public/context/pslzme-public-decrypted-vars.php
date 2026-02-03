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
        $GLOBALS['decryptedVars']['linkCreator'] = $decryptedLinkCreator;  
    }
    
    if ($decryptedTitle !== null && $decryptedTitle !== "") {
        $GLOBALS['decryptedVars']['title'] = $decryptedTitle;  
    }
    
    if ($decryptedFirstName !== null && $decryptedFirstName !== "") {
        $GLOBALS['decryptedVars']['firstName'] = $decryptedFirstName;  
    }
    
    if ($decryptedLastName !== null && $decryptedLastName !== "") {
        $GLOBALS['decryptedVars']['lastName'] = $decryptedLastName;  
    }
    
    if ($decryptedCompanyName !== null && $decryptedCompanyName !== "") {
        $GLOBALS['decryptedVars']['company'] = $decryptedCompanyName;  
    }
    
    if ($decryptedCompanyGender !== null) {
        $GLOBALS['decryptedVars']['companyGender'] = $decryptedCompanyGender;  
    }
    
    if ($decryptedGender !== null && $decryptedGender !== "") {
        $GLOBALS['decryptedVars']['gender'] = $decryptedGender;  
    }

    if ($decryptedAddress !== null && $decryptedAddress !== "") {
        $GLOBALS['decryptedVars']['address'] = $decryptedAddress;  
    }

    if ($decryptedHousenumber !== null && $decryptedHousenumber !== "") {
        $GLOBALS['decryptedVars']['housenumber'] = $decryptedHousenumber;  
    }
    
    if ($decryptedPostcode !== null && $decryptedPostcode !== "") {
        $GLOBALS['decryptedVars']['postcode'] = $decryptedPostcode;  
    }

    if ($decryptedPlace !== null && $decryptedPlace !== "") {
        $GLOBALS['decryptedVars']['place'] = $decryptedPlace;  
    }
    
    if ($decryptedCountry !== null && $decryptedCountry !== "") {
        $GLOBALS['decryptedVars']['country'] = $decryptedCountry;  
    }
    
    if ($decryptedPosition !== null && $decryptedPosition !== "") {
        $GLOBALS['decryptedVars']['position'] = $decryptedPosition;  
    }
    
    if ($decryptedCurl !== null && $decryptedCurl !== "") {
        $GLOBALS['decryptedVars']['curl'] = $decryptedCurl;  
    }
    
    if ($decryptedFC !== null && $decryptedFC !== "") {
        $GLOBALS['decryptedVars']['fc'] = $decryptedFC;  
    }
    
    
    if (!empty($decryptedLinkCreator) && !empty($decryptedFirstName) && !empty($decryptedLastName)) {
            $GLOBALS['decryptedVars']['varsSet'] = true;
    } else {
            $GLOBALS['decryptedVars']['varsSet'] = false;
    }

?>