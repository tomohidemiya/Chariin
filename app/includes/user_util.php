<?php
    function is_user_logged_in() {
        $user = wp_get_current_user();
        return $user->exists();
    }
    function get_logged_in_user_id() {
        $user = wp_get_current_user();
        return $user->ID;
    }
    function is_used_ssl() {
        $user = wp_get_current_user();
        return $user->use_ssl === '1';
    }
