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
        $attendance = base64_decode($_REQUEST['a']);
	//---------------------------
	update_user_meta($userID, 'fsw_roommates', $roommates);
	update_user_meta($userID, 'fsw_house_preference', $house);
        update_user_meta($userID, 'FSW_AttendanceType', $attendance);
	//---------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Preferences($userID)
{
	$html .= '<form method="post">';
	$html .= '<div class="pref_div">';
	$html .= 'Select Prefered House:';
        $html .= '<br>';
	$html .= Get_House_Prefs($userID);
        $html .= '<br><br>';
        $html .= 'Select Attendence Type:';
        $html .= '<br>';
        $html .= Get_Attendance_Select($userID);
        $html .= '<br><br>';
	$html .= 'Add Prefered Roommate(s):';
        $html .= '<br>';
	$html .= Get_User_Select();
	$html .= '<input type="button" name="add_roommate" id="add_roommate" value="Add" onclick="Add_Roommate()">';
	$html .= Get_Roommate_Table($userID);
	$html .= '</div>';
	$html .= '<input type="submit" name="preferences" id="save_prefs" value="Save" onclick="Set_Preferences()"/>';
	$html .= '<input type="hidden" name="r" id="pref_roommates" value="">';
	$html .= '<input type="hidden" name="h" id="pref_house" value="">';
        $html .= '<input type="hidden" name="a" id="pref_attendance" value="">';
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