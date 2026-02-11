<?php

/**
 * Class that handles the creation of custom shortcodes for pslzme
 */
class PslzmeShortcodeService {

    private $controller;
    private $browserLanguage;

    /**
     * constructor.
     * @controller A controller that contains functions to handle different kinds of decryption.
     * Located in /public/controller/pslzme-public-decryption-controller.php.
     */
    public function __construct() {
        $this->controller = DecryptionController::get_instance();
        $browserLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en';
        $this->browserLanguage = substr($browserLanguage, 0, 2);
    }

    /**
     * This function registers static and dynamic shortcodes for pslzme.
     */
    public function register_shortcodes() {
        $this->register_static_shortcodes();
        $this->register_dynamic_shortcodes();
    }


    /**
     * This function handles the creation of static shortcodes for pslzme.
     * For each key inside the staticShortcodes array a new shortcode is created by using the getter function of the DecryptionController class.
     */
    private function register_static_shortcodes() {
        $staticShortcodes = [
            'pslzme-link-creator'   => 'get_decrypted_link_creator',
            'pslzme-title'          => 'get_decrypted_title',
			'pslzme-firstname'      => 'get_decrypted_first_name',
			'pslzme-lastname'       => 'get_decrypted_last_name',
            'pslzme-company'        => 'get_decrypted_company_name',
            'pslzme-position'       => 'get_decrypted_position',
			'pslzme-company-url'    => 'get_decrypted_curl',
			'pslzme-first-contact'  => 'get_decrypted_fc',
        ];

        foreach ($staticShortcodes as $shortcode => $getter) {
			add_shortcode($shortcode, function() use ($getter) {
				return esc_html($this->controller->$getter());
			});
		}
    }

    
    /**
     * This function handles the creation of dynamic shortcodes for pslzme.
     * For each key inside the dynamicShortcodes array a new shortcode is created.
     * Instead of the DecryptionControllers getter functions, individual functions that return a special output are used.
     */
    private function register_dynamic_shortcodes() {
        $dynamicShortcodes = [
            'pslzme-greeting1-capital'              => 'get_greeting1_capital',
            'pslzme-greeting1-lowercase'            => 'get_greeting1_lowercase',
            'pslzme-greeting2-capital'              => 'get_greeting2_capital',
            'pslzme-greeting2-lowercase'            => 'get_greeting2_lowercase',
            'pslzme-greeting3-capital'              => 'get_greeting3_capital',
            'pslzme-greeting3-lowercase'            => 'get_greeting3_lowercase',
            'pslzme-Mr-Ms'                          => 'get_mr_ms',
            'pslzme-company-gender-akk-capital'     => 'get_company_gender_akk_capital',
            'pslzme-company-gender-akk-lowercase'   => 'get_company_gender_akk_lowercase',
            'pslzme-company-gender-dat-capital'     => 'get_company_gender_dat_capital',
            'pslzme-company-gender-dat-lowercase'   => 'get_company_gender_dat_lowercase',
            'pslzme-company-gender-gen-capital'     => 'get_company_gender_gen_capital',
            'pslzme-company-gender-gen-lowercase'   => 'get_company_gender_gen_lowercase',
            'pslzme-company-gender-nom-capital'     => 'get_company_gender_nom_capital',
            'pslzme-company-gender-nom-lowercase'   => 'get_company_gender_nom_lowercase',
        ];

        foreach ($dynamicShortcodes as $shortcode => $method) {
			add_shortcode($shortcode, function() use ($method) {
				return esc_html($this->$method());
			});
		}
    }

    /**
     * This function creates a special output for the pslzme-greeting1-capital shortcode. The output starts in capital.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_greeting1_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "Sehr geehrter Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "Sehr geehrte Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Dear Mr.";
            } else {
                return 'Dear';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Dear Ms.";
            } else {
                return 'Dear';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-greeting1-lowercase shortcode. The output starts in lowercase.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_greeting1_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "sehr geehrter Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "sehr geehrte Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "dear Mr.";
            } else {
                return 'dear';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "dear Ms.";
            } else {
                return 'dear';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-greeting2-capital shortcode. The output starts in capital.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_greeting2_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "Werter Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "Werte Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Dear Mr.";
            } else {
                return 'Dear';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Dear Ms.";
            } else {
                return 'Dear';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-greeting2-lowercase shortcode. The output starts in lowercase.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_greeting2_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "werter Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "werte Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "dear Mr.";
            } else {
                return 'dear';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "dear Ms.";
            } else {
                return 'dear';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-greeting3-capital shortcode. The output starts in capital.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_greeting3_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "Lieber Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "Liebe Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Dearest Mr.";
            } else {
                return 'Dearest';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Dearest Ms.";
            } else {
                return 'Dearest';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-greeting3-lowercase shortcode. The output starts in lowercase.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_greeting3_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "lieber Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "liebe Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "dearest Mr.";
            } else {
                return 'dearest';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "dearest Ms.";
            } else {
                return 'dearest';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-Mr-Ms shortcode. The output starts in capital.
     * @return A german or english string depending on the browser language and the decrypted gender from the pslzme param.
     */
    private function get_mr_ms() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "m") {
            return "Herr";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_gender() === "f") {
            return "Frau";

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "m") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Mr.";
            } else {
                return '';
            }

        } else if ($this->browserLanguage === 'en' && $this->controller->get_decrypted_gender() === "f") {
            if (!empty($this->controller->get_decrypted_title())) {
                return "Ms.";
            } else {
                return '';
            }
        } 
    }

    /**
     * This function creates a special output for the pslzme-company-gender-akk-capital shortcode. The output starts in capital.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Akkusativ.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_akk_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "Den";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "Die";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "Das";

        } else if ($this->browserLanguage === 'en') {
            return "The";

        } else {
            // default value
            return "Die";
        }
    }


    /**
     * This function creates a special output for the pslzme-company-gender-akk-lowercase shortcode. The output starts in lowercase.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Akkusativ.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_akk_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "den";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "die";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "das";

        } else if ($this->browserLanguage === 'en') {
            return "the";

        } else {
            // default value
            return "die";
        }
    }

    /**
     * This function creates a special output for the pslzme-company-gender-dat-capital shortcode. The output starts in capital.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Dativ.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_dat_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "Dem";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "Der";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "Dem";

        } else if ($this->browserLanguage === 'en') {
            return "The";

        } else {
            // default value
            return "Der";
        }
    }

    /**
     * This function creates a special output for the pslzme-company-gender-dat-lowercase shortcode. The output starts in lowercase.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Dativ.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_dat_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "dem";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "der";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "dem";

        } else if ($this->browserLanguage === 'en') {
            return "the";

        } else {
            // default value
            return "der";
        }
    }

    /**
     * This function creates a special output for the pslzme-company-gender-gen-capital shortcode. The output starts in capital.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Genitiv.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_gen_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "Des";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "Der";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "Des";

        } else if ($this->browserLanguage === 'en') {
            return "The";

        } else {
            // default value
            return "Der";
        }
    }

    /**
     * This function creates a special output for the pslzme-company-gender-gen-lowercase shortcode. The output starts in lowercase.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Genitiv.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_gen_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "des";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "der";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "des";

        } else if ($this->browserLanguage === 'en') {
            return "the";

        } else {
            // default value
            return "der";
        }
    }

    /**
     * This function creates a special output for the pslzme-company-gender-nom-capital shortcode. The output starts in capital.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Nominativ.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_nom_capital() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "Der";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "Die";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "Das";

        } else if ($this->browserLanguage === 'en') {
            return "The";

        } else {
            // default value
            return "Der";
        }
    }

    /**
     * This function creates a special output for the pslzme-company-gender-nom-lowercase shortcode. The output starts in lowercase.
     * This is used especially in german websites where nouns are build using the 'kasus' that defined the article before the word. The 'kasus' used here is Nominativ.
     * @return A german or english string depending on the browser language and the decrypted company gender from the pslzme param.
     */
    private function get_company_gender_nom_lowercase() {
        if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "m") {
            return "der";
            
        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "f") {
            return "die";

        } else if ($this->browserLanguage === 'de' && $this->controller->get_decrypted_company_gender() === "d") {
            return "das";

        } else if ($this->browserLanguage === 'en') {
            return "the";

        } else {
            // default value
            return "der";
        }
    }
}

?>