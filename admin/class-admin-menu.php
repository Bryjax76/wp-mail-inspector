<?php
namespace WMI;

class AdminMenu
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    public function enqueue($hook)
    {

        // 🔥 ważne – tylko na naszej stronie
        if ($hook !== 'toplevel_page_wmi-logs') {
            return;
        }

        wp_enqueue_style(
            'wmi-admin-css',
            WMI_URL . 'assets/css/admin.css',
            [],
            defined('WMI_VERSION') ? \WMI_VERSION : '1.0'
        );
        wp_enqueue_script(
            'wmi-admin-js',
            WMI_URL . 'assets/js/admin.js',
            [],
            defined('WMI_VERSION') ? \WMI_VERSION : '1.0',
            true
        );
    }

    public function menu()
    {
        add_menu_page(
            'Mail Inspector',
            'Mail Inspector',
            'manage_options',
            'wmi-logs',
            [$this, 'render'],
            'dashicons-email'
        );
    }

    private function handle_actions()
    {

        if (!isset($_POST['wmi_action'])) {
            return;
        }

        if ($_POST['wmi_action'] !== 'clear_logs') {
            return;
        }

        if (
            !isset($_POST['_wpnonce']) ||
            !wp_verify_nonce($_POST['_wpnonce'], 'wmi_clear_logs')
        ) {
            return;
        }

        global $wpdb;
        $table = \WMI\Database::get_table();

        $wpdb->query("TRUNCATE TABLE {$table}");
    }

    public function render()
    {
        $this->handle_actions();

        global $wpdb;
        $table = \WMI\Database::get_table();
        $logs = $wpdb->get_results("SELECT * FROM {$table} ORDER BY id DESC LIMIT 50");

        require WMI_PATH . 'admin/views/logs-page.php';
    }
}