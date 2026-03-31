<?php
namespace WMI;

class Hooks {

    public function __construct() {
        add_filter('wp_mail', [$this, 'capture_mail'], 10, 1);
        add_action('wp_mail_failed', [$this, 'mail_failed'], 10, 1);
    }

    public function capture_mail($args) {

        Logger::log([
            'status' => 'sent',
            'to' => maybe_serialize($args['to']),
            'subject' => $args['subject'],
            'message' => $args['message'],
            'headers' => maybe_serialize($args['headers']),
            'attachments' => maybe_serialize($args['attachments']),
        ]);

        return $args;
    }

    public function mail_failed($error) {

        Logger::log([
            'status' => 'failed',
            'error' => $error->get_error_message(),
        ]);
    }
}