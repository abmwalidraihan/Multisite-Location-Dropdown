<?php
/*
Plugin Name: Multisite Location Dropdown
Description: Displays a dropdown of all multisite network sites using [multisite_dropdown] shortcode.
Version: 1.1
Author: Walid Raihan
*/

function multisite_dropdown_shortcode() {
    if (!is_multisite()) return '';

    $sites = get_sites([
        'public' => 1,
        'deleted' => 0,
        'archived' => 0
    ]);

    $output = '<select id="multisite-dropdown" style="font-size:12px; color:black; padding:6px; border:1px solid #ccc; border-radius:4px;" onchange="if(this.value) window.location.href=this.value;">';
    $output .= '<option value="">Sign In Location</option>';

    foreach ($sites as $site) {
        // Skip the main site
        if ((int)$site->blog_id === 1) {
            continue;
        }

        $details = get_blog_details($site->blog_id);
        $signin_url = trailingslashit($details->siteurl) . 'sign-in/';
        $output .= '<option value="' . esc_url($signin_url) . '">' . esc_html($details->blogname) . '</option>';
    }

    $output .= '</select>';
    return $output;
}
add_shortcode('multisite_dropdown', 'multisite_dropdown_shortcode');
