<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    use \App\Controllers\Partials\Header;
    use \App\Controllers\Partials\Footer;
    use \App\Controllers\Partials\PagePartials;
    use \App\Controllers\Partials\LoginForm;
    private static $redux_demo;
    public function __construct() {
        global $redux_demo;
        self::$redux_demo = $redux_demo;

        add_action('wp_ajax_login_form', array($this, 'login_form'));
        add_action( 'wp_ajax_nopriv_login_form', array($this, 'login_form'));

        add_action('wp_ajax_link_type', array($this, 'link_type'));
        add_action( 'wp_ajax_nopriv_link_type', array($this, 'link_type'));

        add_action('wp_ajax_logout_ajax', array($this, 'logout_ajax'));
        add_action( 'wp_ajax_nopriv_logout_ajax', array($this, 'logout_ajax'));
    }

    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

}
