<?php
/*
Plugin Name: Site Reviews - Reviews Carousel Addon
Plugin URI: https://gabrielcastillo.net/
Description: Site Review Plugin Addon for reviews carousel.
Author: Gabriel Castillo
Author URI: https://gabrielcastillo.net
Version: 1.0.2
Text Domain: ttb-testimonial-carousel
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') || exit;

/**
 * site_reviews_testimonial_carousel.
 *
 * @param array   {
 *     Attributes of the shortcode.
 *
 *     @type string $id ID of...
 * }
 *
 * @return string HTML content to display the shortcode.
 */
function site_reviews_testimonial_carousel($atts = array()): string {

    $html = '';

    $atts = shortcode_atts(array(
        'id' => null,
    ), $atts, 'site-reviews-carousel');


    if (function_exists('glsr_get_reviews')) {
            global $wpdb;

            $posts_table    = $wpdb->prefix . 'posts';
            $ratings_table  = $wpdb->prefix . 'glsr_ratings';

            $sql = sprintf( /** @lang sql */ "SELECT %s.*, %s.*
					FROM %s 
					    JOIN %s ON %s.review_id = %s.ID 
					WHERE %s.ID IN (SELECT %s.review_id FROM %s WHERE is_approved = 1)", $posts_table, $ratings_table, $posts_table, $ratings_table, $ratings_table, $posts_table, $posts_table, $ratings_table, $ratings_table );

            $query = $wpdb->get_results($sql);

        if ($query) {
			if ( $atts['id'] !== null ) {
				$id = 'id="'.$atts['id'].'"';
			} else {
				$id = '';
			}
            $html = '<div '.$id.' class="site-reviews-carousel-container glsr">';

            $html .= '<div class="testimonial-slideshow-container">';
            foreach ($query as $result) {
                $html .= '<div class="testimonial-slide">';

                if (function_exists('glsr_star_rating')) {
                    $html .= '<div class="glsr-review-rating">';
                    $html .= glsr_star_rating($result->rating);
                    $html .= '</div>';
                }

                $html .= '<p>' . $result->post_content . '</p>';
                $html .= '<p class="author">'.$result->name.'</p>';
                $html .= '</div>';
            }
            $html .= '<a class="prev">&#10094;</a>';
            $html .= '<a class="next">&#10095;</a>';

            $html .= '</div>';
            $html .= '</div>';
        }
    }

    return $html;
}
add_shortcode('site-reviews-carousel', 'site_reviews_testimonial_carousel');

/**
 * Register Assets
 * @return void
 */
function site_reviews_testimonial_carousel_register_assets()
{
    wp_enqueue_script('site-reviews-carousel-js', plugin_dir_url(__FILE__) . 'scripts.js', false, false, true);
    wp_enqueue_style('site-reviews-carousel-css', plugin_dir_url(__FILE__) . 'styles.css', false, false, 'all');
}
add_action('wp_enqueue_scripts', 'site_reviews_testimonial_carousel_register_assets');
