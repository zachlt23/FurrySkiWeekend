<?php
/*
Plugin Name: FSW_Registration
Plugin URI:
Description: Uses an internally defined status to either show a message or a button to send an email request for registration
Version: 1.0.0.0
Author: Zach Thompson
Author URI: 
License: GPLv2
Copyright 2018 Zach Thompson (email: zachlt23@gmail.com)
*/

register_activation_hook(__FILE__, 'Activate_FSW_Registration');
register_deactivation_hook(__FILE__, 'Deactivate_FSW_Registration');
register_uninstall_hook(__FILE__, 'Uninstall_FSW_Registration');

add_action('admin_menu','FSW_Registration_GenerateMenu');
add_action('admin_enqueue_scripts', 'FSW_Load_Admin_Settings');
add_action('wp_enqueue_scripts', 'FSW_Load_Settings');

add_shortcode('FSW_Registration', 'FSW_Display_Registration');
add_shortcode('FSW_Preferences', 'FSW_Display_Preferences');
add_shortcode('FSW_TravelTimes', 'FSW_Display_TravelTimes');

require_once(plugin_dir_path(__FILE__) . 'php/FSW_Admin.php');
require_once(plugin_dir_path(__FILE__) . 'php/FSW_Status.php');
require_once(plugin_dir_path(__FILE__) . 'php/FSW_Preferences.php');
require_once(plugin_dir_path(__FILE__) . 'php/FSW_Methods.php');
require_once(plugin_dir_path(__FILE__) . 'php/FSW_TravelTimes.php');

include('/wordpress/core/' . $wp_version . '/wp-includes/pluggable.php');

function Activate_FSW_Registration() { }
function Uninstall_FSW_Registration() { }

function Deactivate_FSW_Registration() 
{
	remove_menu_page('FSW_Registration_Console');
}

function FSW_Load_Admin_Settings()
{
	wp_register_script('FSW_Admin_Registration_js', plugins_url('/js/FSW_Admin_Registration.js',__FILE__));

	wp_enqueue_script('FSW_Admin_Registration_js');

	wp_enqueue_style('FSW_Admin_css', plugins_url('/css/FSW_Admin_Style.css',__FILE__));
}

function FSW_Load_Settings()
{
	wp_register_script('FSW_Registration_js', plugins_url('/js/FSW_Registration.js',__FILE__));

	wp_enqueue_script('FSW_Registration_js');

	wp_enqueue_style('FSW_css', plugins_url('/css/FSW_Style.css',__FILE__));
}

function FSW_Registration_GenerateMenu()
{
	add_menu_page('FSW Registration', //Page Title
		          'FSW Registration', //Menu Title
		          'manage_options', //Minimum User Capability to see the menu
		          'FSW_Registration_Console', //Unique slug name
		          'FSW_RegistrationManagement_GeneratePage', //Function that creates the menu page
		          'dashicons-list-view');

	add_submenu_page('FSW_Registration_Console', //parent menu slug name
			         'Mass Email', //Page Title
		             'Mass Email', //Menu Title
			         'manage_options', //the capability required to access
			         'FSW_Mass_Email', //Unique slug name
                    'FSW_Mass_Email_GeneratePage');

	add_submenu_page('FSW_Registration_Console', //parent menu slug name
			         'Tools', //Page Title
		             'Tools', //Menu Title
			         'manage_options', //the capability required to access
			         'FSW_Tools', //Unique slug name
			         'FSW_Tools_GeneratePage');
        
    add_submenu_page('FSW_Registration_Console', //parent menu slug name
			         'User Info', //Page Title
		             'User Info', //Menu Title
			         'manage_options', //the capability required to access
			         'FSW_UserInfo', //Unique slug name
			         'FSW_UserInfo_GeneratePage');
}

function FSW_RegistrationManagement_GeneratePage()
{
	echo Get_FSW_Pending_Table();
	echo Get_FSW_Waitlist_Table();
	echo Get_FSW_Approved_Table();
    echo Get_FSW_Approved_Daypass_Table();
	echo Get_FSW_Paid_Table();
	echo Get_FSW_Refund_Table();
}

function FSW_Mass_Email_GeneratePage()
{
	echo Get_FSW_Mass_Email();
}

function FSW_Tools_GeneratePage()
{
	echo Get_FSW_Verification();
	echo Get_FSW_Reset_Button();
}

function FSW_UserInfo_GeneratePage()
{
    echo Get_FSW_DietaryRestrictionGrid();
}

function FSW_Display_Registration($atts, $content = null)
{
	$current_user = wp_get_current_user();

    FSW_Set_Default_Status_If_Needed($current_user->ID);

    $final .= Get_FSW_UserStatus_Table($current_user->ID);
	
	if(FSW_Can_Register($current_user->ID))
		{ $final .= Get_FSW_Registration_Button($current_user->ID, $current_user->display_name); }

	if(FSW_Can_Request_Refund($current_user->ID))
		{ $final .= Get_FSW_Refund_Button($current_user->ID, $current_user->display_name); }

    return $final;
}

function FSW_Display_Preferences($atts, $content = null)
{
	$current_user = wp_get_current_user();

    $final .= Get_FSW_Preferences($current_user->ID);

    return $final;
}

if(isset($_REQUEST['register']))
{
	FSW_Registration();	
}

if(isset($_REQUEST['reset']))
{	
	Reset_FSW_Registration_Status();	
}

if(isset($_REQUEST['approval']))
{	
	Update_FSW_Status();
}

if(isset($_REQUEST['preferences']))
{	
	Set_FSW_Preferences();
}

if(isset($_REQUEST['questionnaire']))
{	
	Send_Questionnaire();
}

if(isset($_REQUEST['refund']))
{	
	FSW_Refund();
}

//This is somehow getting called when saving profiles
/*
if(isset($_REQUEST['email']))
{	
	Email_FSW_Users();
}
 */

if(isset($_REQUEST['FSW_Verification']))
{
	Send_FSW_Verification();
}

if(isset($_REQUEST['save_travel']))
{
	Set_Travel_Values();
}

?>
