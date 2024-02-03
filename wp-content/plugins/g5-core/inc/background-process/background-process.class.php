<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Async_Request', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/libraries/wp-async-request.php'));
}
if ( ! class_exists( 'WP_Background_Process', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/libraries/wp-background-process.php'));
}

abstract class G5Core_Background_Process extends WP_Background_Process {

    /**
     * Get batch.
     *
     * @return stdClass Return the first batch from the queue.
     */
    protected function get_batch() {
        global $wpdb;

        $table        = $wpdb->options;
        $column       = 'option_name';
        $key_column   = 'option_id';
        $value_column = 'option_value';

        if ( is_multisite() ) {
            $table        = $wpdb->sitemeta;
            $column       = 'meta_key';
            $key_column   = 'meta_id';
            $value_column = 'meta_value';
        }

        $key = $wpdb->esc_like( $this->identifier . '_batch_' ) . '%';

        $query = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE {$column} LIKE %s ORDER BY {$key_column} ASC LIMIT 1", $key ) ); // @codingStandardsIgnoreLine.

        $batch       = new stdClass();
        $batch->key  = $query->$column;
        $batch->data = array_filter( (array) maybe_unserialize( $query->$value_column ) );

        return $batch;
    }

    /**
     * See if the batch limit has been exceeded.
     *
     * @return bool
     */
    protected function batch_limit_exceeded() {
        return $this->time_exceeded() || $this->memory_exceeded();
    }

    /**
     * Handle.
     *
     * Pass each queue item to the task handler, while remaining
     * within server memory and time limit constraints.
     */
    protected function handle() {
        $this->lock_process();

        do {
            $batch = $this->get_batch();

            foreach ( $batch->data as $key => $value ) {
                $task = $this->task( $value );

                if ( false !== $task ) {
                    $batch->data[ $key ] = $task;
                } else {
                    unset( $batch->data[ $key ] );
                }

                if ( $this->batch_limit_exceeded() ) {
                    // Batch limits reached.
                    break;
                }
            }

            // Update or delete current batch.
            if ( ! empty( $batch->data ) ) {
                $this->update( $batch->key, $batch->data );
            } else {
                $this->delete( $batch->key );
            }
        } while ( ! $this->batch_limit_exceeded() && ! $this->is_queue_empty() );

        $this->unlock_process();

        // Start next batch or complete process.
        if ( ! $this->is_queue_empty() ) {
            $this->dispatch();
        } else {
            $this->complete();
        }
    }

    /**
     * Schedule cron healthcheck.
     *
     * @param array $schedules Schedules.
     * @return array
     */
    public function schedule_cron_healthcheck( $schedules ) {
        $interval = apply_filters( $this->identifier . '_cron_interval', 5 );

        if ( property_exists( $this, 'cron_interval' ) ) {
            $interval = apply_filters( $this->identifier . '_cron_interval', $this->cron_interval );
        }

        // Adds every 5 minutes to the existing schedules.
        $schedules[ $this->identifier . '_cron_interval' ] = array(
            'interval' => MINUTE_IN_SECONDS * $interval,
            /* translators: %d: interval */
            'display'  => sprintf( __( 'Every %d minutes', 'g5-core' ), $interval ),
        );

        return $schedules;
    }

    /**
     * Delete all batches.
     *
     * @return WC_Background_Process
     */
    public function delete_all_batches() {
        global $wpdb;

        $table  = $wpdb->options;
        $column = 'option_name';

        if ( is_multisite() ) {
            $table  = $wpdb->sitemeta;
            $column = 'meta_key';
        }

        $key = $wpdb->esc_like( $this->identifier . '_batch_' ) . '%';

        $wpdb->query( $wpdb->prepare( "DELETE FROM {$table} WHERE {$column} LIKE %s", $key ) ); // @codingStandardsIgnoreLine.

        return $this;
    }

    /**
     * Kill process.
     *
     * Stop processing queue items, clear cronjob and delete all batches.
     */
    public function kill_process() {
        if ( ! $this->is_queue_empty() ) {
            $this->delete_all_batches();
            wp_clear_scheduled_hook( $this->cron_hook_identifier );
        }
    }

}