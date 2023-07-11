<?php 
/**
 * @package tripadvisorPlugin
 */

 /* 
 
    Plugin Name: TripAdvisor Review Plugin
    Plugin URI: http://tripreview.com/plugin
    Description: TripAdvisor Review Plugin
    Version: 1.0.0
    Author: Georgios Samopoulos
    Author URI: http://GS.com
    License: GPLv2 or later

 */
require_once ('simple_html_dom.php');

function removeElementById($html, $elementId) {
    // Create a new instance of the HTML parser
    $dom = new simple_html_dom();
    
    // Load the HTML content
    $dom->load($html);
    
    // Find the element by its ID
    $element = $dom->getElementById($elementId);
    
    // Check if the element exists
    if ($element) {
        // Remove the element from its parent
        $element->outertext = '';
    }
    
    // Return the modified HTML
    return $dom->save();
}
 
 if ( ! defined('ABSPATH') ){
    die;
 }

function crawlWebsite() {

    $url = 'https://www.tripadvisor.com/Restaurant_Review-g255060-d17758138-Reviews-Franca_Brasserie-Sydney_New_South_Wales.html';
    // Initialize cURL session
   $ch = curl_init($url); 
    
    // // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'); // Set a user agent to mimic a browser
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set a timeout value (in seconds)
    
    // // Execute the cURL request
    $response = curl_exec($ch);
    
    // // Check for errors
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "Error: " . $error;
    }
    
    // // Close cURL session
    curl_close($ch);
    
    // // Return the response
    return $response;
}

function get_reviews() {
    // Custom function logic goes here
    $ret = crawlWebsite();
    $ret = removeElementById($ret, 'taplc_global_nav_0');
    $ret = removeElementById($ret, 'atf_header_wrap');
    $ret = removeElementById($ret, 'atf_meta');
    $ret = removeElementById($ret, 'taplc_detail_overview_cards_0');
    $ret = removeElementById($ret, 'taplc_location_detail_tag_questions_rr_responsive_0');
    $ret = removeElementById($ret, 'taplc_detail_filters_rr_resp_0');
    $ret = removeElementById($ret, 'taplc_details_card_0');
    $ret = removeElementById($ret, 'taplc_claim_listing_rr_resp_bottom_0');
    $ret = removeElementById($ret, 'taplc_location_qa_resp_rr_responsive_0');
    $ret = removeElementById($ret, 'taplc_restaurant_review_faqs_rr_responsive_0');
    $ret = removeElementById($ret, 'taplc_masthead_h1_lower_rr_resp_0');
    $ret = removeElementById($ret, 'taplc_resp_hr_nearby_rr_responsive_0');
    $ret = removeElementById($ret, 'taplc_restaurants_xsell_resp_0');
    $ret = removeElementById($ret, 'taplc_restaurant_review_content_as_feature_in_widget_0');
    $ret = removeElementById($ret, 'taplc_global_footer_components_0');
    $ret = removeElementById($ret, 'component_12');






    return $ret;
}
add_shortcode('my_short', 'get_reviews');


