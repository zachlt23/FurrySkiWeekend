<?php
//-----------------------------------------------------------------------------------------------------------
require_once(plugin_dir_path(__FILE__) . 'FSW_Methods.php');
//-----------------------------------------------------------------------------------------------------------
function Set_FSW_Preferences()
{
	//---------------------------
	$roommates = base64_decode($_REQUEST['r']);
	$house = base64_decode($_REQUEST['h']);
	$userID = base64_decode($_REQUEST['i']);
        $restriction = base64_decode($_REQUEST['dr']);
        $attendance = base64_decode($_REQUEST['a']);
        $so = base64_decode($_REQUEST['so']);
	//---------------------------
	update_user_meta($userID, 'fsw_roommates', $roommates);
	update_user_meta($userID, 'fsw_house_preference', $house);
        update_user_meta($userID, 'FSW_Dietary_Restrictions', $restriction);
        update_user_meta($userID, 'FSW_AttendanceType', $attendance);
        update_user_meta($userID, 'FSW_SO', $so);
	//---------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Preferences($userID)
{
	$html .= '<form method="post">';
	
        $html .= '<div id="pref_div">';
	$html .= 'Prefered House:';
        $html .= '<br>';
	$html .= Get_House_Prefs($userID);
        $html .= '</div>';
        $html .= '<br>';
        
        $html .= '<div id="dietary_div">';
        $html .= 'Dietary Restriction:';
        $html .= '<br>';
	$html .= Get_DietaryRestrictions($userID);
        $html .= '</div>';
        $html .= '<br>';
        
        $html .= '<div id="attendance_div">';
        $html .= 'Attendance Type:';
        $html .= '<br>';
        $html .= Get_Attendance_Select($userID);
        $html .= '</div>';
        $html .= '<br>';
        
        $html .= '<div id="significantOtter_div">';
        $html .= 'Significant Otter:';
        $html .= '<br>';
        $html .= Get_SO_Select($userID);
        $html .= '</div>';
        $html .= '<br>';
        
        $html .= '<div id="roommates_div">';
	$html .= 'Add Prefered Roommate(s):';
        $html .= '<br>';
	$html .= Get_User_Select();
	$html .= '<input type="button" name="add_roommate" id="add_roommate" value="Add" onclick="Add_Roommate()">';
	$html .= Get_Roommate_Table($userID);
	$html .= '</div>';
        
	$html .= '<input type="submit" name="preferences" id="save_prefs" value="Save" onclick="Set_Preferences()"/>';
	$html .= '<input type="hidden" name="r" id="pref_roommates" value="">';
	$html .= '<input type="hidden" name="h" id="pref_house" value="">';
        $html .= '<input type="hidden" name="dr" id="pref_restriction" value="">';
        $html .= '<input type="hidden" name="a" id="pref_attendance" value="">';
        $html .= '<input type="hidden" name="so" id="pref_so" value="">';
	$html .= '<input type="hidden" name="i" id="pref_ID" value="' . base64_encode($userID) . '">';
        
	$html .= '</form>';
	
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_Roommate_Table($userID)
{
	$roomates = get_user_meta($userID, 'fsw_roommates', true);

	$html .= '<table id="roommate_table">';
	$html .= '<caption>Prefered Roommates</caption>';
	foreach(explode(",", $roomates ) as $item)
	{
		if($item != '')
		{
			$html .= '<tr id="roommate_' . $item .'">';
			$html .= '<th>' . $item . '</th>';
			$html .= '<td><input type="button" value="Remove" onclick="Remove_Roommate(\'roommate_' . $item . '\')"/></td>';
			$html .= '</tr>';
		}
	}
	$html .= '</table>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
?>