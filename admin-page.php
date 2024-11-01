<?php
# Регистрируем новую страницу на вкладке "Параметры":
add_action('admin_menu', 'wrp_admin_menu');
function wrp_admin_menu() {
  add_options_page( __('Hide pages', 'wrp'), __('Hide pages', 'wrp'), 'manage_options', 'wrp-options.php', 'wrp_form' );
}

# Показываем форму:
function wrp_form() {
  echo '<div class="wrap">';
  screen_icon();
  echo '<h2>'. __('Hide pages', 'wrp'). '</h2>';
  echo '<form method="post" action="options.php">';
  do_settings_sections('wrp_page');
  settings_fields('wrp_fields');
  submit_button();
  echo '</form>';
  echo '</div>';
}

# Регистрируем поля в БД и оформляем их отображение.
add_action('admin_init', 'snap_options_fields');
function snap_options_fields() {
  register_setting('wrp_fields', 'wrp_array');
  add_settings_section('wrp_section_id', '', 'wrp_section_call', 'wrp_page');
  add_settings_field('wrp_attachments_id', __('Pages attachments', 'wrp'), 'wrp_attachments_call', 'wrp_page', 'wrp_section_id');
  add_settings_field('wrp_authors_id', __('Author Archives', 'wrp'), 'wrp_authors_call', 'wrp_page', 'wrp_section_id');
  add_settings_field('wrp_day_id', __('Archives of the day', 'wrp'), 'wrp_day_call', 'wrp_page', 'wrp_section_id');
  add_settings_field('wrp_month_id', __('Archives month', 'wrp'), 'wrp_month_call', 'wrp_page', 'wrp_section_id');
  add_settings_field('wrp_year_id', __('Archives years', 'wrp'), 'wrp_year_call', 'wrp_page', 'wrp_section_id');
}

# Функции вывода элементов формы на экран:
function wrp_section_call() {
  echo '<p>'. __('Note the pages generated by WordPress, which you want to remove.', 'wrp'). '</p>';
}
function wrp_attachments_call() {
  $p = get_option('wrp_array');
  echo '<input name="wrp_array[attachments]" id="wrp_attachments" type="checkbox" value="1" class="code" '. checked(1, $p['attachments'], false). ' /> '. __('For example', 'wrp'). ': http://example.com/?attachment_id=123';
}
function wrp_authors_call() {
  $p = get_option('wrp_array');
  echo '<input name="wrp_array[authors]" id="wrp_authors" type="checkbox" value="1" class="code" '. checked(1, $p['authors'], false). ' /> '. __('For example', 'wrp'). ': http://example.com/author/user-name';
}
function wrp_day_call() {
  $p = get_option('wrp_array');
  echo '<input name="wrp_array[day]" id="wrp_day" type="checkbox" value="1" class="code" '. checked(1, $p['day'], false). ' /> '. __('For example', 'wrp'). ': http://example.com/2013/02/01';
}
function wrp_month_call() {
  $p = get_option('wrp_array');
  echo '<input name="wrp_array[month]" id="wrp_month" type="checkbox" value="1" class="code" '. checked(1, $p['month'], false). ' /> '. __('For example', 'wrp'). ': http://example.com/2013/02';
}
function wrp_year_call() {
  $p = get_option('wrp_array');
  echo '<input name="wrp_array[year]" id="wrp_year" type="checkbox" value="1" class="code" '. checked(1, $p['year'], false). ' /> '. __('For example', 'wrp'). ': http://example.com/2013';
}

# Хук деисталляции:
register_uninstall_hook(__FILE__, 'wrp_deinstall');
function wrp_deinstall() {
  delete_option('wrp_array');
}
?>