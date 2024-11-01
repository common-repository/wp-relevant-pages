<?php
/*
Plugin Name: WP Relevant Pages
Plugin URI: http://druweb.ru/wp-relevant-pages.html
Description: Plugin removes from the site such as all kinds of unnecessary pages the author's archive, archives days / months / years or pages investments. Also concerned and the appropriate RSS feeds.
Version: 1.0
Author: YandexBot
Author URI: http://druweb.ru
License: GPLv2 or later
Text Domain: wrp
Domain Path: /languages
*/

# Подключаем страницу администрирования:
include "admin-page.php";

# Загрузка строк локализации:
load_plugin_textdomain('wrp', false, dirname( plugin_basename( __FILE__ ) ). '/languages/');

# Вешаем 404-ю на ненужные страницы:
add_action('template_redirect', 'wrp_404');

function wrp_404() {
  global $wp_query, $post;

  # Считываем опции:
  $p = get_option('wrp_array');

  # Убираем страницы:
  if ( is_attachment() && $p['attachments'] == 1 )
    $wp_query->set_404();
  if ( is_author() && $p['author'] == 1 )
    $wp_query->set_404();
  if ( is_day() && $p['day'] == 1 )
    $wp_query->set_404();
  if ( is_month() && $p['month'] == 1 )
    $wp_query->set_404();
  if ( is_year() && $p['year'] == 1 )
    $wp_query->set_404();

  # Убираем RSS-ленты:
  if ( is_feed() ) :
    if ( !empty($author) && $p['author'] === 1 ) {
      $author = get_query_var('author_name');
      $wp_query->set_404();
      $wp_query->is_feed = false;
    }

    $author = get_query_var('author_name');
    $attachment = get_query_var('attachment');
    $attachment = ( empty($attachment) ) ? get_query_var('attachment_id') : $attachment;
    $day        = get_query_var('day');
    $month      = get_query_var('month');
    $year       = get_query_var('year');

    if ( !empty($attachment) && $p['attachment'] === 1 ) {
      $wp_query->set_404();
      $wp_query->is_feed = false;
    }

    if ( !empty($day) && $p['day'] === 1 ) {
      $wp_query->set_404();
      $wp_query->is_feed = false;
    }

    if ( !empty($month) && $p['month'] === 1 ) {
      $wp_query->set_404();
      $wp_query->is_feed = false;
    }

    if ( !empty($year) && $p['year'] === 1 ) {
      $wp_query->set_404();
      $wp_query->is_feed = false;
    }
  endif;
}
?>