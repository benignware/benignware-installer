<?php

/**
* Template Name: Sidebar Layout
* Template Post Type: post, page, girl
*
* @package WordPress
* @subpackage Sitekick
* @since Sitekick 1.0
*/

add_filter('is_active_sidebar', function($is_active) {
  return true;
}, 20);

include 'page.php';
