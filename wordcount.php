<?php
/**
 * Plugin Name:   Word Count Plugin    
 * Plugin URI:    https://onlytarikul.com/    
 * Description:   Post Word Count   
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tarikul Islam
 * Author URI:        https://onlytarikul.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       
 * Domain Path:       /languages
 */

/**
 * Load plugin textdomain.
 */
function textdomain_plugin_loaded(){
    load_plugin_textdomain('wordcount',false, dirname(__FILE__) . "/languages" );
}
add_action('plugin_loaded','textdomain_plugin_loaded');

/*
function textdomain_activation_hook(){}
register_activation_hook(__FILE__,'textdomain_activation_hook');

function textdomain_deactivation_hook(){}
register_deactivation_hook(__FILE__,'textdomain_deactivation_hook');
*/

/**
 * Post Word Count
 */

 function textdomain_the_content($content){
     /**
      * ALl htm tag remove here 
      */
    $stripContent = strip_tags($content);
    /**
     * Post word count Here
     */
    $wordcount = str_word_count($stripContent);
    /**
     * hardcode string 
     */
    $label = __('Total Post Word Count','textdomain');
    /**
     * We give facility to edit Post word count title change 
     * filter hook added
     */
    $label = apply_filters('word_count_title',$label);
    /**
     * We give facility to edit Post word count title change 
     * filter hook added
     */
    $tags = apply_filters('word_count_tag','h2');
    /**
     * Wordcount add after post comtent
     */
    $content.= sprintf('<%s>%s:%s<%s/>',$tags,$label,$wordcount,$tags);

    /**
     * How many words to read in one minutes?
     * We give facility to edit how many word to read in one minutes 
     */
    $per_minute_word = __('200','textdomain');
    $per_minute_word = apply_filters('per_min_word',$per_minute_word);
    $minutes_count = floor($wordcount/$per_minute_word);

    /**
     * Firstly find out reminder if here 
     * Remember reminder 30 words 
     * 200 words reading time takes 60 secs 
     * 1 word reading time takes (60/200)
     * 30 word reading time takes (60/200)*30 
     */

    $second_count = floor(($wordcount%$per_minute_word)*(60/200));  


    /**
     * Post Reading Time Title
     * Here added filter hook to chage for user 
     */
    $reading_time_title = __('Post Reading Time','textdomain');
    $reading_time_title = apply_filters('post_reading_time_title',$reading_time_title);


    /**
     * Post Reading Time Added after content
     */

     $content .= sprintf('<h5>%s: %s mins %s sec<h5/>',$reading_time_title,$minutes_count,$second_count);

    return $content;

 }
 add_filter('the_content','textdomain_the_content');














