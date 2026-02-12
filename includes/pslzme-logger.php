<?php


/**
 * The file that defines the plugins main logger class
 * Class uses the Singleton pattern to be able to log different messages anywhere inside the plugin
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/includes
 */

class PslzmeLogger {

    private static $instance = null;
    private $enabled;

    /**
     * constructor
     * @enabled Boolean that defines if the debug modus is enabled or not
     */
    private function __construct() {
        $this->enabled = defined('WP_DEBUG') && WP_DEBUG;
    }

    /**
     * This function creates the instance of the logger throughout the application.
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * This function controls the loggers main functionality by writing different messages depending on the context.
     * @level This is telling how serious or important the log entry is.
     * @message This is the main log text of what will be written into the log file.
     * @context An array that gives extra details about the logging message.
     */
    private function write_log(string $level, string $message, array $context = []) {
        if (!$this->enabled) return;

        $prefix = "[PSLZME][$level]";
        $context_string = !empty($context) ? ' ' . wp_json_encode($context) : '';
        error_log("$prefix $message$context_string");
    }

    /**
     * This function writes an info message to the log file.
     * @message The message that will be written into the file. The write_log function will use 'INFO' as the level param.
     * @context Additional context for the log.
     */
    public function info(string $message, array $context = []) {
        $this->write_log('INFO', $message, $context);
    }

    /**
     * This function writes a warning message to the log file.
     * @message The message that will be written into the file. The write_log function will use 'WARNING' as the level param.
     * @context Additional context for the log.
     */
    public function warning(string $message, array $context = []) {
        $this->write_log('WARNING', $message, $context);
    }

    /**
     * This function writes an error message to the log file.
     * @message The message that will be written into the file. The write_log function will use 'ERROR' as the level param.
     * @context Additional context for the log.
     */
    public function error(string $message, array $context = []) {
        $this->write_log('ERROR', $message, $context);
    }

    /**
     * This function writes a debug message to the log file.
     * @message The message that will be written into the file. The write_log function will use 'DEBUG' as the level param.
     * @context Additional context for the log.
     */
    public function debug(string $message, array $context = []) {
        $this->write_log('DEBUG', $message, $context);
    }
}




?>