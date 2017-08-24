<?php
//-----------------------------------------------------------------------------------------------------------
require_once(plugin_dir_path(__FILE__) . 'FSW_Methods.php');
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_UserStatus_Table($userID)
{
	//-----------------------------------------------------------------------------------------------------------
	$status = get_user_meta($userID, 'fsw_status', true );
	$house = get_user_meta($userID, 'fsw_house', true );
	$bed = get_user_meta($userID, 'fsw_bed', true );
	$roommate = get_user_meta($userID, 'FSW_Roommate', true);
	$description = Get_FSW_StatusMessage($status);
	//-----------------------------------------------------------------------------------------------------------
	if(!Is_FSW_Registration_Open())
	{
		$html .= '<div class="FSW_Not_Open">';
		$html .= 'FSW-' . FSW_Registration_Year() . ' registration is not currently open';
		$html .= '</div>';
	}
	//-----------------------------------------------------------------------------------------------------------
	$html .= '<table id="user_status_table">';
	$html .= Create_Header_Row('Status', $status);
	$html .= Create_Header_Row('Description', $description);
	$html .= Create_Header_Row('House', $house);
	$html .= Create_Header_Row('Bed', $bed);
	$html .= Create_Header_Row('Roommate(s)', $roommate);
	$html .= '</table>';
	//-----------------------------------------------------------------------------------------------------------
	return $html;
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Registration_Button($userID, $displayName)
{
	//-----------------------------------------------------------------------------------------------------------
	$encoded_ID = base64_encode($userID);
	$encoded_DisplayName = base64_encode($displayName);
	//-----------------------------------------------------------------------------------------------------------
	$html .= '<form method="post">';
	$html .= '<input type="submit" name="register" value="Register"/>';
	$html .= '<input type="hidden" name="i" value="' . $encoded_ID . '">';
	$html .= '<input type="hidden" name="d" value="' . $encoded_DisplayName . '">';
	$html .= '</form>';
	//-----------------------------------------------------------------------------------------------------------
	return $html;
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Refund_Button($userID, $displayName)
{
	//-----------------------------------------------------------------------------------------------------------
	$encoded_ID = base64_encode($userID);
	$encoded_DisplayName = base64_encode($displayName);
	//-----------------------------------------------------------------------------------------------------------
	$html .= '<form method="post">';
	$html .= '<input type="submit" name="refund" value="Request Refund"/>';
	$html .= '<input type="hidden" name="i" value="' . $encoded_ID . '">';
	$html .= '<input type="hidden" name="d" value="' . $encoded_DisplayName . '">';
	$html .= '</form>';
	//-----------------------------------------------------------------------------------------------------------
	return $html;
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Registration()
{
	//-----------------------------------------------------------------------------------------------------------
	$userID = base64_decode($_REQUEST['i']);
	$displayName = base64_decode($_REQUEST['d']);
	//-----------------------------------------------------------------------------------------------------------
	update_user_meta($userID, 'fsw_status', 'Pending');

	$to = 'furryskiweekend@gmail.com';
	$subject = 'FSW-' . FSW_Registration_Year() . ' registration request for: ' . $displayName;
	$message .= 'Registration Requested';

	FSW_Email($to, $subject, $message);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Refund()
{
	//-----------------------------------------------------------------------------------------------------------
	$userID = base64_decode($_REQUEST['i']);
	$displayName = base64_decode($_REQUEST['d']);
	//-----------------------------------------------------------------------------------------------------------
	update_user_meta($userID, 'fsw_status', 'Refund Requested');

	$to = 'furryskiweekend@gmail.com';
	$subject = 'FSW-' . FSW_Registration_Year() . ' REFUND requested for: ' . $displayName;
	$message .= 'REFUND Requested';

	FSW_Email($to, $subject, $message);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
?>