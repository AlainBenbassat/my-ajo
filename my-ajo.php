<?php

/*
 * Plugin Name: Mijn AJO
 * Plugin URI:        https://github.com/AlainBenbassat/my-ajo
 * Description:       Smoelenboek e.a. functionaliteit
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Alain Benbassat
 * Author URI:        https://www.businessandcode.eu
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-ajo
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


function my_ajo_smoelenboek($atts, $content = null) {
  require_once __DIR__ . '/includes/class-my-ajo-smoelenboek.php';
  wp_enqueue_style('my_ajo', plugin_dir_url( __FILE__ ) . 'public/css/my-ajo-public.css');

  return My_Ajo_Smoelenboek::get();
}

add_shortcode('smoelenboek', 'my_ajo_smoelenboek');