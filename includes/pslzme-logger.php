<?php

class PslzmeLogger {

    private static $instance = null;
    private $enabled;

    private function __construct() {
        $this->enabled = defined('WP_DEBUG') && WP_DEBUG;
    }

    public function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function write_log(string $level, string $message, array $context = []) {
        if (!$this->enabled) return;

        $prefix = "[PSLZME][$level]";
        $context_string = !empty($context) ? ' ' . wp_json_encode($context) : '';
        error_log("$prefix $message$context_string");
    }

    public function info(string $message, array $context = []) {
        $this->write_log('INFO', $message, $context);
    }

    public function warning(string $message, array $context = []) {
        $this->write_log('WARNING', $message, $context);
    }

    public function error(string $message, array $context = []) {
        $this->write_log('ERROR', $message, $context);
    }

    public function debug(string $message, array $context = []) {
        $this->write_log('DEBUG', $message, $context);
    }
}




?>