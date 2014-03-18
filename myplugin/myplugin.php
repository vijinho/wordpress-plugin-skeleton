<?php
/**
 * Plugin Name: MyPlugin
 * Plugin URI: https://github.com/vijinho/wordpress-plugin-skeleton
 * Description: MyPlugin-specific features
 * Version: 1.0
 * Author: Vijay Mahrra
 * Author URI: https://github.com/vijinho
 * License: GPLv2
 */

/*  Copyright 2014 Vijay Mahrra

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @link http://codex.wordpress.org/Writing_a_Plugin
 */

$pluginClass = 'MyPlugin';

if (!class_exists($pluginClass))
{
    class MyPlugin
    {
        private static $instance;

        private static $version = '1.0';

        public static function instance()
        {
            if (!isset(self::$instance)) {
                $class = get_called_class();
                self::$instance =  new $class;
            }
            return self::$instance;
        }

        public function __construct()
        {
            $class = get_class($this);
            add_action('init', array($class, 'load_translations'));
            register_activation_hook(__FILE__, array($class, 'activate'));
            register_deactivation_hook(__FILE__, array($class, 'deactivate'));
        }

        /**
         * Log message if `DEBUG` and DEBUG_LOG enabled in wp-config.php
         *
         * @param mixed   $message string to log, or object to log via `print_r`
         */
        public static function debug($message)
        {
            $enabled = defined('DEBUG') && defined('DEBUG_LOG') && DEBUG == true && DEBUG_LOG == true;
            if (!$enabled) {
                return false;
            }
            $class = get_called_class();
            $message = print_r($message, true);
            error_log($class . ': ' .  $message);
        }

        /**
         * Load translations
         */
        public static function load_translations()
        {
            self::debug('Translations Loaded');
            $plugin_path = plugin_basename(dirname( __FILE__ ) .'/i18n');
            load_plugin_textdomain(basename(plugin_dir_path(__FILE__)), false, $plugin_path);
        }

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            self::debug('Plugin Activation');
        }

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            self::debug('Plugin Deactivation');
        }
    }
}

//instantiate the class
if (class_exists($pluginClass)) {
    $pluginObject = $pluginClass::instance();
}
