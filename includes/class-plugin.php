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

        // 🔥 CRON hook
        add_action('wmi_cleanup_logs', [$this, 'cleanup_logs']);
    }

    /**
     * 🔥 CRON: delete logs older than 90 days
     */
    public function cleanup_logs() {
        global $wpdb;

        $table = Database::get_table();

        $wpdb->query(
            "DELETE FROM {$table} WHERE created_at < NOW() - INTERVAL 90 DAY"
        );
    }

    /**
     * 🔥 ACTIVATION
     */
    public static function activate() {

        // create DB table
        Database::install();

        // schedule cron if not exists
        if (!wp_next_scheduled('wmi_cleanup_logs')) {
            wp_schedule_event(time(), 'daily', 'wmi_cleanup_logs');
        }
    }

    /**
     * 🔥 DEACTIVATION
     */
    public static function deactivate() {

        // remove cron
        wp_clear_scheduled_hook('wmi_cleanup_logs');
    }
}