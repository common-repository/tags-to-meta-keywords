<?php
/* 
Plugin Name: Tags To Keywords 
Plugin URI: http://chegevara29.ru/?p=797
Description: Add tags to head's meta keywords
Version: 1.0.1
Author: CheGevara
Author URI: http://chegevara29.ru/
*/

function tagstokeywords() {
    if (is_front_page() or is_single() ) {
	
		echo '<meta name="keywords" content="';  

		if ( !is_front_page() ) {
			echo implode( ', ', wp_list_pluck( (array) get_the_tags(), 'name' ) );
			echo '">';
			} else {
			echo get_option('ttk_main_tags');
			echo '">';	
		}
	}
}


add_action('admin_menu', 'ttk_admin_page');

function ttk_admin_page() {
    add_options_page('Tags to keywords', 'Tags to keywords', 8, __FILE__, 'ttk_options_page');
}

function ttk_options_page() {
    echo "<h1>Tags to Keywords</h1><p>Keys for maim page";
    add_option('ttk_main_tags', '');
    if (isset($_POST['keywords_edit'])){
    $_get_ttk = $_POST['keywords_edit'];
    update_option('ttk_main_tags', $_get_ttk);}
    $_temp_ttk = "<br><form action=\"\" method=\"post\"><p><textarea rows=\"10\" cols=\"45\" name=\"keywords_edit\">".get_option('ttk_main_tags')." </textarea></p> <p><input type=\"submit\" value=\"Сохранить\"></p>";
    echo $_temp_ttk;
}

if (function_exists('_activation_hook')) {
  register_activation_hook(__FILE__, ‘ttk_set_options’);
}
function ttk_set_options() {
    add_option('ttk_main_tags', 'Главная страница');
}


if (function_exists('register_uninstall_hook')) {
  register_uninstall_hook(__FILE__, 'ttk_deinstall');
}
function ttk_deinstall() {
  delete_option('main_tags');
}

add_action('wp_head', 'tagstokeywords');
?>