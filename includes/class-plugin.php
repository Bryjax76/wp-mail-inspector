<?php
namespace WMI;

class Plugin {

    private static $instance;

    public static function instance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->includes();
        $this->init_hooks();
    }

    private function includes() {
        require_once WMI_PATH . 'includes/class-hooks.php';
        require_once WMI_PATH . 'includes/class-logger.php';
        require_once WMI_PATH . 'includes/class-database.php';
        require_once WMI_PATH . 'admin/class-admin-menu.php';
    }

    private function init_hooks() {
        new Hooks();
        new AdminMenu();
    }
}