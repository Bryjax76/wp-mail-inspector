<div class="wrap">
    <h1>Mail Logs</h1>

    <div class="actions-menu" style="display: flex; justify-content: space-between; align-items: center; margin: 1em 0;">
        <form method="post" style="margin-bottom: 15px;">
            <?php wp_nonce_field('wmi_clear_logs'); ?>
            <input type="hidden" name="wmi_action" value="clear_logs">
            <button type="submit" class="button button-danger"
                onclick="return confirm('Are you sure you want to delete all logs?');">
                Clear Logs
            </button>
        </form>
        <span>Logs will be automatically cleared after 90 days...</span>
    </div>

    <?php if (!empty($logs)): ?>
        <table class="widefat striped wmi-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Headers</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Data</th>
                    <th>Error</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo esc_html($log->id); ?></td>
                        <td>
                            <?php
                            $status_class = $log->status === 'sent' ? 'wmi-status--sent' : 'wmi-status--failed';
                            ?>
                            <span class="wmi-status <?php echo esc_attr($status_class); ?>">
                                <?php echo esc_html(strtoupper($log->status)); ?>
                            </span>
                        </td>
                        <td class="wmi-headers">
                            <?php echo esc_html($log->headers); ?>
                        </td>
                        <td><?php echo esc_html($log->email_to); ?></td>
                        <td><?php echo esc_html($log->subject); ?></td>
                        <td class="wmi-message">
                            <div class="wmi-message-short">
                                <?php echo nl2br(esc_html($log->message)); ?>
                            </div>
                            <span class="wmi-toggle">Czytaj więcej</span>
                        </td>
                        <td><?php echo esc_html($log->created_at); ?></td>
                        <td class="wmi-error">
                            <?php if (!empty($log->error)): ?>

                                <?php
                                $error = esc_html($log->error);
                                $is_long_error = strlen($error) > 120; // 👈 próg
                                ?>

                                <div class="<?php echo $is_long_error ? 'wmi-error-short' : ''; ?>">
                                    <?php echo nl2br($error); ?>
                                </div>

                                <?php if ($is_long_error): ?>
                                    <span class="wmi-toggle-error">Pokaż błąd</span>
                                <?php endif; ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Brak logów.</p>
    <?php endif; ?>
</div>