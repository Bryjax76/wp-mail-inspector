<?php
namespace WMI;

class Logger {

    public static function log($data) {

        global $wpdb;

        $table = Database::get_table();

        $wpdb->insert($table, [
            'status' => $data['status'] ?? 'unknown',
            'email_to' => $data['to'] ?? '',
            'subject' => $data['subject'] ?? '',
            'message' => $data['message'] ?? '',
            'headers' => $data['headers'] ?? '',
            'attachments' => $data['attachments'] ?? '',
            'error' => $data['error'] ?? '',
            'created_at' => current_time('mysql'),
        ]);
    }
}