<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

/**
 * Adds a toast message to the session as Flashdata using SweetAlert2.
 *
 * @param string $icon    The type of icon (e.g., 'success', 'error', 'warning', 'info').
 * @param string $text    The text content of the toast.
 * @param string $title   The title of the toast.
 *
 * @return true
 */
if (!function_exists('withToast')) {
    function withToast($icon, $text, $title = "") {

        // Prepare the toast data
        $toastData = [
            'class' => $icon === 'error' ? 'danger' : $icon,
            'icon'  => $icon,
            'title' => $title,
            'text'  => $text,
        ];

        // Set the toast data as flashdata in the session
        session()->setFlashdata('toast', $toastData);

        return true;
    }
}

