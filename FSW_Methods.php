<?php
//-----------------------------------------------------------------------------------------------------------
$FSW_Houses = array('None', 'Masters 4', 'Masters 7', 'Masters 22', 'Legends 10', 'Legends 11', 'Woods 36', 'Woods 15', 'Copper Springs 215', 'Copper Springs 227', 'The Complex', 'Off-Site');
$FSW_Beds = array('None', 'King', 'Queen', 'Twin', 'Bunk', 'Sleeper', 'Single', 'Double');
$FSW_Airlines = array('', 'Air Canada', 'Alaskan', 'American', 'Delta', 'Frontier', 'Jet Blue', 'Other', 'Southwest', 'Spirit', 'United', 'Virgin', 'West Jet');
$FSW_AttendanceTypes = array('Full Event', "Daypass");
//-----------------------------------------------------------------------------------------------------------
function FSW_Registration_Year()
{
	return (date("m") > 2) ? date("Y") + 1 : date("Y");
}
//-----------------------------------------------------------------------------------------------------------
function Is_FSW_Registration_Open()
{
	return ((date("m") <= 2) || (date("m") >= 9));
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Can_Register($userID)
{
	$status = get_user_meta($userID, 'fsw_status', true );
	return ($status == 'Not Registered') && (Is_FSW_Registration_Open());
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Set_Default_Status_If_Needed($userID)
{
	$status = get_user_meta($userID, 'fsw_status', true );
	if(($status == '') || ($status == 'Please Select'))
		update_user_meta($userID, 'fsw_status', 'Not Registered');
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Can_Request_Refund($userID)
{
	return (get_user_meta($userID, 'fsw_status', true ) == "Approved - Paid");
}
//-----------------------------------------------------------------------------------------------------------
function Change_Role($userID, $newRole)
{
	$user = new WP_User($userID);
	$currentRole = $user->roles[0];

	if($currentRole != 'administrator')
	{
 		$user->remove_role($currentRole);
 		$user->add_role($newRole);
	}
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Email($email_to, $subject, $message)
{
	$to = $email_to;
	$subject = $subject;
	$message = $message;
	$headers = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
	$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
	$additional = '-f registration@furryskiweekend.com';
	mail($to, $subject, $message, $headers, $additional);
}
//-----------------------------------------------------------------------------------------------------------
function FSW_HTML_Email($email_to, $subject, $message)
{
	$to = $email_to;
	$subject = $subject;
	$message = $message;
	$headers = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$additional = '-f registration@furryskiweekend.com';
	mail($to, $subject, $message, $headers, $additional);
}
//-----------------------------------------------------------------------------------------------------------
function FSW_BCC_Email($emails, $subject, $message)
{
	$to = "registration@furryskiweekend.com";
	$subject = $subject;
	$message = $message;
	$headers .= "Bcc: $emails \r\n";
	$headers = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
	$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
	$additional = '-f registration@furryskiweekend.com';
	mail($to, $subject, $message, $headers, $additional);
}
//-----------------------------------------------------------------------------------------------------------
function Create_Header_Row($name, $value)
{
	$html .= '<tr>';
	$html .= '<th>' . $name . '</th>';
	$html .= '<td>' . $value . '</td>';
	$html .= '</tr>';
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
//This is for the preferences page
function Get_House_Prefs($userID)
{
    $house = get_user_meta($userID, 'fsw_house_preference', true);
    return Get_FSW_Select($GLOBALS['FSW_Houses'], $house , 'select_house_pref', 'house_pref');
}
//-----------------------------------------------------------------------------------------------------------
//This is for the Admin page
function Get_Houses_Select($userID)
{
	$id = 'select_house_' . $userID;
	$house = get_user_meta($userID, 'fsw_house', true);
	return Get_FSW_Select($GLOBALS['FSW_Houses'], $house , $id, 'houses');
}
//-----------------------------------------------------------------------------------------------------------
function Get_Airline_Select($userID)
{
	$airline = get_user_meta($userID, 'FSW_Airline', true);
	return Get_FSW_Select($GLOBALS['FSW_Airlines'], $airline, 'travel_airline_select', 'airline');
}
//-----------------------------------------------------------------------------------------------------------
function Get_Attendance_Select($userID)
{
	$attendance = get_user_meta($userID, 'FSW_AttendanceType', true);
	return Get_FSW_Select($GLOBALS['FSW_AttendanceTypes'], $attendance, 'attendance_select', 'airline');
}
//-----------------------------------------------------------------------------------------------------------
function Get_Beds_Select($userID)
{
	$id = 'select_bed_' . $userID;
	$bed = get_user_meta($userID, 'fsw_bed', true);
	return Get_FSW_Select($GLOBALS['FSW_Beds'], $bed, $id, 'beds');
}
//-----------------------------------------------------------------------------------------------------------
function Get_Roommates_Select($userID)
{
	$id = 'select_roommate_' . $userID;
	$roommate = get_user_meta($userID, 'FSW_Roommate', true);
        $filter = array('fields' => array('display_name'), 
                        'meta_key' => 'fsw_status',  
                        'meta_value' => 'Approved - Paid',
                        'order' => 'ASC',
                        'orderby' => 'display_name'
                        );
        
        $html .= '<select id="' . $id .'">';
        $html .= '<option value="None">None</option>';
	foreach(get_users($filter) as $user)
        {
            $displayName = $user->display_name;
            $selected = ($roommate == $displayName) ? "selected" : "";
            $html .= '<option value="' . $displayName . '" ' . $selected . '>' . $displayName . '</option>';
        }
	$html .= '</select>';
        
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Select($values, $currentValue, $id, $name, $disabled = false)
{
	$html .= '<select id=' . $id . ' name=' . $name . ' ' . ($disabled ? "disabled" : "") . '>';

	foreach($values as $value)
	{
		$selected = ($currentValue == $value) ? "selected" : "";
		$html .= '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
	}
	
	$html .= '</select>';
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_User_Select()
{
	$filter = array('fields' => array('display_name'),
			'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'fsw_status', 
							'value' => 'Approved - Paid'
							),
        					array(
							'key' => 'fsw_status', 
							'value' => 'Approved - Payment Required'
							)
						)
			);


	$html .= '<select id="select_roommates">';
	foreach(get_users($filter) as $user)
		$html .= '<option value="' . $user->display_name . '">' . $user->display_name . '</option>';
	$html .= '</select>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_User_Email_Select($id)
{
	$filter = array('order' => 'ASC','orderby' => 'display_name','fields' => array('display_name','user_email'));
	$html .= "<select id=$id>";
	foreach(get_users($filter) as $user)
		$html .= "<option value='$user->display_name|$user->user_email'>$user->display_name</option>";
	$html .= '</select>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Emails()
{
	$emails = array();
	$filter = array('fields' => array('user_email'));
	foreach(get_users($filter) as $user)
		array_push($emails, $user->user_email);
	return implode(",",$emails);
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Status_Count($status)
{
	$user_query 
		= new WP_User_Query(array('meta_key' => 'fsw_status', 
				   	  'meta_value' => $status, 
				          'exclude' => array('1','5','7'), 
					  'fields' => array('ID')));
	return $user_query->get_total();
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_StatusMessage($status)
{
	//-----------------------------------------------------------------------------------------------------------
	$fsw = "FSW-" . FSW_Registration_Year();
	//-----------------------------------------------------------------------------------------------------------
	switch($status)
	{
		case "Pending":
                    return "Your request to attend " . $fsw . " has been received and is being reviewed";
		case "Waitlist":
                    return $fsw . " is currently full. You have been added to our waitlist and will be notified if a space becomes available.";
		case "Approved - Payment Required":
                    return "You have been approved for " . $fsw . ". You can now pay to secure your spot. (http://furryskiweekend.com/shop/)";
                case "Approved for Daypass - Payment Required":
                    return  "You have been approved to purchase a " . $fsw . " daypass. (http://furryskiweekend.com/shop/)";
		case "Approved - Paid":
                    return "You are approved and paid for " . $fsw . ". We look forward to having you. ^^";
		case "Declined":
                    return "We regret to inform you that you will not be able to attend $fsw";
		case "Not Registered":
                    return "You have not yet requested to attend " . $fsw;
		case "Refund Requested":
                    return "Your request for a refund is currently being evaluated.";
		default:
                    return "N/A";
	}
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_MilitaryTime_Select($id, $currentValue)
{
	$html .= '<select id=' . $id . '>';
	$html .= "<option value=''></option>";
	for($i = 0; $i <= 24; $i++)
	{
		for($j = 0; $j < 60; $j+=15)
		{
			$value = sprintf("%02d", $i) . ':' . sprintf("%02d", $j);
			$html .= '<option value="' . $value . '" ' . (($currentValue == $value) ? "selected" : "") . '>' . $value . '</option>';
		}
	}

	$html .= '</select>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
?>