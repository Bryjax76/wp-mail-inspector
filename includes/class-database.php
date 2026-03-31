<?php
namespace WMI;

class Database {

    public static function get_table() {
        global $wpdb;
        return $wpdb->prefix . 'wmi_logs';
    }

    public static function install() {

        global $wpdb;

        $table = self::get_table();
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id BIGINT UNSIGNED AUTO_INCREMENT,
            status VARCHAR(20),
            email_to TEXT,
            subject TEXT,
            message LONGTEXT,
            headers LONGTEXT,
            attachments LONGTEXT,
            error TEXT,
            created_at DATETIME,
            PRIMARY KEY (id)
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}