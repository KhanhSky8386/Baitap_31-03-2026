<?php
/**
 * Plugin Name: LearnPress Stats Dashboard
 * Plugin URI:  https://example.com/
 * Description: Hiển thị thống kê LearnPress tổng số khóa học, học viên đã đăng ký và số khóa học đã hoàn thành.
 * Version: 1.0.0
 * Author: Student
 * Author URI: https://example.com/
 * Text Domain: lp-stats-addon
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'lp_stats_get_stats' ) ) {

    function lp_stats_get_total_courses() {
        if ( post_type_exists( defined( 'LP_COURSE_CPT' ) ? LP_COURSE_CPT : 'lp_course' ) ) {
            $posts_count = wp_count_posts( defined( 'LP_COURSE_CPT' ) ? LP_COURSE_CPT : 'lp_course' );
            return isset( $posts_count->publish ) ? intval( $posts_count->publish ) : 0;
        }

        return 0;
    }

    function lp_stats_get_total_students() {
        global $wpdb;

        $table = $wpdb->prefix . 'learnpress_user_items';
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) !== $table ) {
            return 0;
        }

        $item_type = defined( 'LP_COURSE_CPT' ) ? LP_COURSE_CPT : 'lp_course';
        $status_enrolled = defined( 'LP_COURSE_ENROLLED' ) ? LP_COURSE_ENROLLED : 'enrolled';
        $status_purchased = defined( 'LP_COURSE_PURCHASED' ) ? LP_COURSE_PURCHASED : 'purchased';
        $status_finished = defined( 'LP_COURSE_FINISHED' ) ? LP_COURSE_FINISHED : 'finished';

        return intval( $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(DISTINCT user_id) FROM {$table} WHERE item_type = %s AND status IN (%s, %s, %s)",
            $item_type,
            $status_enrolled,
            $status_purchased,
            $status_finished
        ) ) );
    }

    function lp_stats_get_completed_courses() {
        global $wpdb;

        $table = $wpdb->prefix . 'learnpress_user_items';
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) !== $table ) {
            return 0;
        }

        $item_type = defined( 'LP_COURSE_CPT' ) ? LP_COURSE_CPT : 'lp_course';
        $status_finished = defined( 'LP_COURSE_FINISHED' ) ? LP_COURSE_FINISHED : 'finished';

        return intval( $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE item_type = %s AND status = %s",
            $item_type,
            $status_finished
        ) ) );
    }

    function lp_stats_get_stats() {
        if ( ! class_exists( 'LP' ) && ! post_type_exists( defined( 'LP_COURSE_CPT' ) ? LP_COURSE_CPT : 'lp_course' ) ) {
            return array(
                'total_courses'    => 0,
                'total_students'   => 0,
                'completed_courses'=> 0,
                'message'          => __( 'LearnPress chưa kích hoạt hoặc chưa có dữ liệu LearnPress.', 'lp-stats-addon' ),
            );
        }

        return array(
            'total_courses'     => lp_stats_get_total_courses(),
            'total_students'    => lp_stats_get_total_students(),
            'completed_courses' => lp_stats_get_completed_courses(),
        );
    }

    function lp_stats_render_dashboard_widget() {
        $stats = lp_stats_get_stats();

        if ( isset( $stats['message'] ) ) {
            echo '<p>' . esc_html( $stats['message'] ) . '</p>';
            return;
        }

        echo '<div class="lp-stats-dashboard">';
        echo '<p><strong>' . esc_html__( 'Tổng số khóa học:', 'lp-stats-addon' ) . '</strong> ' . intval( $stats['total_courses'] ) . '</p>';
        echo '<p><strong>' . esc_html__( 'Tổng số học viên đã đăng ký:', 'lp-stats-addon' ) . '</strong> ' . intval( $stats['total_students'] ) . '</p>';
        echo '<p><strong>' . esc_html__( 'Số khóa học đã hoàn thành:', 'lp-stats-addon' ) . '</strong> ' . intval( $stats['completed_courses'] ) . '</p>';
        echo '</div>';
    }

    function lp_stats_add_dashboard_widget() {
        if ( current_user_can( 'manage_options' ) ) {
            wp_add_dashboard_widget(
                'lp_stats_dashboard_widget',
                __( 'LearnPress Stats Dashboard', 'lp-stats-addon' ),
                'lp_stats_render_dashboard_widget'
            );
        }
    }

    function lp_stats_shortcode( $atts ) {
        $stats = lp_stats_get_stats();

        if ( isset( $stats['message'] ) ) {
            return '<div class="lp-stats-shortcode"><p>' . esc_html( $stats['message'] ) . '</p></div>';
        }

        ob_start();
        ?>
        <div class="lp-stats-shortcode">
            <div class="lp-stat-item"><strong><?php echo esc_html__( 'Tổng số khóa học:', 'lp-stats-addon' ); ?></strong> <?php echo intval( $stats['total_courses'] ); ?></div>
            <div class="lp-stat-item"><strong><?php echo esc_html__( 'Tổng số học viên đã đăng ký:', 'lp-stats-addon' ); ?></strong> <?php echo intval( $stats['total_students'] ); ?></div>
            <div class="lp-stat-item"><strong><?php echo esc_html__( 'Số khóa học đã hoàn thành:', 'lp-stats-addon' ); ?></strong> <?php echo intval( $stats['completed_courses'] ); ?></div>
        </div>
        <?php
        return ob_get_clean();
    }

    function lp_stats_enqueue_admin_styles() {
        echo '<style>.lp-stats-dashboard p{margin:0 0 10px;padding:0}.lp-stats-shortcode{border:1px solid #ddd;padding:15px;background:#fff}.lp-stats-shortcode .lp-stat-item{margin-bottom:10px;font-weight:600;}</style>';
    }

    add_action( 'wp_dashboard_setup', 'lp_stats_add_dashboard_widget' );
    add_action( 'admin_head', 'lp_stats_enqueue_admin_styles' );
    add_shortcode( 'lp_stats_dashboard', 'lp_stats_shortcode' );
}
