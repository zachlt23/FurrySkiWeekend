<?php
//-----------------------------------------------------------------------------------------------------------
require_once(plugin_dir_path(__FILE__) . 'FSW_Methods.php');
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Verification()
{
	$html .= '<form class="FSW_Verification" method="post">';
	$html .= '<table>';
	$html .= '<tr>';
	$html .= '<th>New Registrant</th>';
	$html .= '<th>Verifier</th>';
	$html .= '<th>Send Email</th>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td>' . Get_User_Email_Select("select_new_registrant") . '</td>';
	$html .= '<td>' . Get_User_Email_Select("select_verifier") . '</td>';
	$html .= '<td><input type="submit" name="FSW_Verification" value="Send Verification" onclick="Set_FSW_Verification()"/></td>';
	$html .= "<input type='hidden' name='new_registrant' id='FSW_New_Registrant'>";
	$html .= "<input type='hidden' name='verifier' id='FSW_Verifier'>";
	$html .= '</tr>';
	$html .= '</table>';
	$html .= '</form>';
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Mass_Email()
{
	$emails = Get_FSW_Emails();

	$html .= '<form class="FSW_Emails" method="post">';
	$html .= '<table>';
	$html .= '<tr>';
	$html .= '<th>Subject</th>';
	$html .= '<td><input type="text" name="subject" id="FSW_Email_Subject"></td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<th>Message</th>';
	$html .= '<td><textarea id="FSW_Email_Message_Text"></textarea></td>';
	$html .= '</tr>';
	$html .= '</table>';
	$html .= '<input type="submit" name="email" value="Send Emails" onclick="Set_FSW_Hidden_Email_Message()"/>';
	$html .= "<input type='hidden' name='emails' id='FSW_Emails' value=$emails>";
	$html .= "<input type='hidden' name='message' id='FSW_Email_Message'>";
	$html .= '</form>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Pending_Table()
{
	$status = 'Pending';
	$count = Get_FSW_Status_Count($status);

	$html .= '<form class="pending" method="post">';
	$html .= '<table class="FSW_Users">';
	$html .= "<caption>Pending Users - $count</caption>";
	$html .= '<tr>';
	$html .= '<th>Display Name</th>';
	$html .= '<th>Email</th>';
	$html .= '<th>Approve</th>';
	$html .= '<th>Waitlist</th>';
	$html .= '<th>Decline</th>';
	$html .= '<th>Send Questionnaire</th>';
	$html .= '</tr>';
	$html .= Build_FSW_Users('subscriber', $status, 'p');
	$html .= '</table>';
	$html .= Get_FSW_Table_Input('p');
	$html .= '</form>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Approved_Table()
{
	$status = 'Approved - Payment Required';
	$count = Get_FSW_Status_Count($status);

	$html .= '<form class="approved" method="post">';
	$html .= '<table class="FSW_Users">';
	$html .= "<caption>Approved Users - $count</caption>";
	$html .= '<tr>';
	$html .= '<th>Display Name</th>';
	$html .= '<th>Email</th>';
	$html .= '<th>Paid</th>';
	$html .= '<th>Waitlist</th>';
	$html .= '</tr>';
	$html .= Build_FSW_Users('customer', $status, 'a');
	$html .= '</table>';
	$html .= Get_FSW_Table_Input('a');
	$html .= '</form>';

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Housing_Table()
{
	$status = 'Approved - Paid';
	$count = Get_FSW_Status_Count($status);

	$html .= '<form class="approved" method="post">';
	$html .= '<table class="FSW_Users">';
	$html .= "<caption>Paid Users - $count</caption>";
	$html .= '<tr>';
	$html .= '<th>Display Name</th>';
	$html .= '<th>Email</th>';
	$html .= '<th>House Preference</th>';
	$html .= '<th>Roommate Preference</th>';
	$html .= '<th>House</th>';
	$html .= '<th>Bed</th>';
	$html .= '<th>Update</th>';
	$html .= '</tr>';
	$html .= Build_FSW_Users('subscriber', $status, 'h');
	$html .= '</table>';
	$html .= Get_FSW_Table_Input('h');
	$html .= '</form>';
	
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Waitlist_Table()
{
	$status = 'Waitlist';
	$count = Get_FSW_Status_Count($status);

	$html .= '<form class="approved" method="post">';
	$html .= '<table class="FSW_Users">';
	$html .= "<caption>Waitlist - $count</caption>";
	$html .= '<tr>';
	$html .= '<th>Display Name</th>';
	$html .= '<th>Email</th>';
	$html .= '<th>Approve</th>';
	$html .= '<th>Decline</th>';
	$html .= '</tr>';
	$html .= Build_FSW_Users('subscriber', $status, 'w');
	$html .= '</table>';
	$html .= Get_FSW_Table_Input('w');
	$html .= '</form>';
	
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Refund_Table()
{
	$status = 'Refund Requested';
	$count = Get_FSW_Status_Count($status);

	$html .= '<form class="approved" method="post">';
	$html .= '<table class="FSW_Users">';
	$html .= "<caption>Requesting Refunds - $count</caption>";
	$html .= '<tr>';
	$html .= '<th>Display Name</th>';
	$html .= '<th>Email</th>';
	$html .= '<th>Refunded</th>';
	$html .= '<th>Rescinded</th>';
	$html .= '</tr>';
	$html .= Build_FSW_Users('subscriber', $status, 'r');
	$html .= '</table>';
	$html .= Get_FSW_Table_Input('r');
	$html .= '</form>';
	
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Build_FSW_Users($role, $status, $buttonType)
{
	$filter = array('order' => 'ASC', 'orderby' => 'display_name', 'role' => $role, 'meta_key' => 'fsw_status', 'meta_value' => $status);

	foreach(get_users($filter) as $user)
		if(!in_array($user->ID, array('1','5','7')))
		{
			$html .= '<tr>';
			$html .= "<td><a href='http://furryskiweekend.com/profile/$user->ID' target='_blank'>$user->display_name</a></td>";
			$html .= '<td>' . $user->user_email . '</td>';
			$html .=  Get_FSW_User_Buttons($buttonType, $user->ID, $user->display_name, $user->user_email);
			$html .= '</tr>';
		}

	return $html;
}

function Get_FSW_Table_Input($prefix)
{
	$html .= '<input type="hidden" name="i" id="' . $prefix . '_i" value="">';
	$html .= '<input type="hidden" name="d" id="' . $prefix . '_d" value="">';
	$html .= '<input type="hidden" name="e" id="' . $prefix . '_e" value="">';
	$html .= '<input type="hidden" name="h" id="' . $prefix . '_h" value="">';
	$html .= '<input type="hidden" name="b" id="' . $prefix . '_b" value="">';
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_User_Buttons($buttonType, $userID, $displayName, $email)
{
	//-----------------------------------------------------------------------------------------------------------
	$parameters = Get_FSW_Encoded_Parameters($buttonType, $userID, $displayName, $email);
	//-----------------------------------------------------------------------------------------------------------
	switch($buttonType)
	{
		case "p":
			return Get_FSW_Pending_Buttons($parameters, $userID);
		case "a":
			return Get_FSW_Approved_Buttons($parameters);
		case "h":
			return Get_FSW_Housing_Buttons($userID, $parameters);
		case "w":
			return Get_FSW_Waitlist_Buttons($parameters);
		case "r":
			return Get_FSW_Refund_Buttons($parameters);
		default:
			return "";
	}
	//-----------------------------------------------------------------------------------------------------------
}

function Get_FSW_Pending_Buttons($parameters, $userID)
{
	$html .= Get_FSW_Status_Button('Approve', $parameters);
	$html .= Get_FSW_Status_Button('Waitlist', $parameters);
	$html .= Get_FSW_Status_Button('Decline', $parameters);

	if(get_user_meta($userID, 'fsw_qsent', true ) != 'true')
		$html .= '<td><input type="submit" name="questionnaire" value="Send" onclick="Update_FSW_Hidden(' . $parameters . ')"/></td>';
	else
		$html .= '<td>Sent</td>';

	return $html;
}

function Get_FSW_Waitlist_Buttons($parameters)
{
	$html .= Get_FSW_Status_Button('Approve', $parameters);
	$html .= Get_FSW_Status_Button('Decline', $parameters);

	return $html;
}

function Get_FSW_Housing_Buttons($userID, $parameters)
{
	$html .= '<td>' . Get_House_Prefs($userID, true) . '</td>';
	$html .= '<td>' . get_user_meta($userID, 'fsw_roommates', true) . '</td>';
	$html .= '<td>' . Get_Houses($userID) . '</td>';
	$html .= '<td>' . Get_Beds($userID) . '</td>';
	$html .= Get_FSW_Status_Button('Update', $parameters);

	return $html;
}

function Get_FSW_Approved_Buttons($parameters)
{
	$html .= Get_FSW_Status_Button('Paid', $parameters);
	$html .= Get_FSW_Status_Button('Waitlist', $parameters);
	return $html;
}

function Get_FSW_Refund_Buttons($parameters)
{
	$html .= Get_FSW_Status_Button('Refunded', $parameters);
	$html .= Get_FSW_Status_Button('Rescinded', $parameters);
	return $html;
}

function Get_FSW_Encoded_Parameters($type, $userID, $displayName, $email)
{
	$encoded_ID = base64_encode($userID);
	$encoded_DisplayName = base64_encode($displayName);
	$encoded_Email = base64_encode($email);

	$parameters .= "'" . $type . "','";
	$parameters .= $encoded_ID . "','";
	$parameters .= $encoded_DisplayName . "','";
	$parameters .= $encoded_Email . "'";

	return $parameters;
}

function Get_FSW_Status_Button($name, $parameters)
{
	$html .= '<td>';
	$html .= '<input type="submit" name="approval" value="' . $name . '" onclick="Update_FSW_Hidden(' . $parameters . ')"/>';
	$html .= '</td>';
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Reset_Button()
{
	$html .= '<form method="post">';
	$html .= '<table class="Reset">';
	$html .= '<tr>';
	$html .= '<th>This will reset all users to Not Registered</th>';
	$html .= '<td><input type="submit" name="reset" id="reset_button" value="Reset Registration" disabled/></td>';
	$html .= '<td><input type="button" name="enable_reset" id="enable_reset_button" value="Enable Reset" onclick="Enable_Reset()"/></td>';
	$html .= '</tr>';
	$html .= '</table>';
	$html .= '</form>';
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Send_Questionnaire()
{
	//-----------------------------------------------------------------------------------------------------------
	$userID = base64_decode($_REQUEST['i']);
	$displayName = base64_decode($_REQUEST['d']);
	$email = base64_decode($_REQUEST['e']);
	//-----------------------------------------------------------------------------------------------------------
	$to = $email;
	$subject = $displayName . ', FSW would like to know more about you!';
	$message = "
		<html>
			<head>
				<style>
					h1 { text-align:center; text-decoration: underline; }
				</style>
			</head>
			<body>
				<h1>FSW Questionnaire</h1>
				<p> 
					Thanks for applying to FSW!<br>
					The purpose of the this questionnaire is to identify whether or not
					you would be a good fit for our event. We have very limited space 
					and work very hard to create an environment where everyone attending
					can feel comfortable and have a fantastic, unique, and memorable time. 
					Please answer the following questions and email them back to us as soon as possible.
				</p>
				<ul style='list-style-type:disc'>
  					<li>Why do you want to attend FSW?</li>
					<li>Tell us a little bit about yourself.</li>
					<li>Will you be at least 21 years old by the first day of FSW?</li>
  					<li>Who do you know who is attending this year or who has attended in past years?</li>
					<li>Do you ski, snowboard, both, or neither?</li>
					<li>Have you applied or attended in past years?</li>
					<li>Do you have a fursuit?</li>
					<li>Do you want to attend the entire event, or just a single day?</li>
					<li>Are you willing to assist with small tasks around the event?</li>
					<li>Are you interested in taking video/pictures during the event for our use?</li>
					<li>Are you interested in teaching other how to ski/snowboard?</li>
					<li>Is there anyone attending who you have had negative experiences with or do not like?</li>
					<li>Have you read through the About section? (http://furryskiweekend.com/about/)</li>
					<li>Are you renting a vehicle, or will you need transportation to FSW?</li>
					<li>If you rent a vehicle, are you willing to transport other attendees to and from FSW?</li>
					<li>Recreational cannabis is legal in CO. Would its isolated use bother you?</li>
				</ul>
				www.furryskiweekend.com
			</body>
		</html>
	";
	//-----------------------------------------------------------------------------------------------------------
	FSW_HTML_Email($to, $subject, $message);
	//-----------------------------------------------------------------------------------------------------------
	update_user_meta($userID, 'fsw_qsent', 'true');
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Send_FSW_Verification()
{
	//-----------------------------------------------------------------------------------------------------------
	$registrant = explode("|",$_REQUEST['new_registrant']);
	$verifier = explode("|",$_REQUEST['verifier']);
	$name = $registrant[0];
	//-----------------------------------------------------------------------------------------------------------
	$to = $verifier[1];
	$subject = "$verifier[0], can you vouch for $name";
	$message = "
		<html>
			<head>
				<style>
					h1 { text-align:center; text-decoration: underline; }
				</style>
			</head>
			<body>
				<h1>FSW New Registrant Verification</h1>
				<p> 
					$name listed you as a reference. Could you answer the following?
					(All responses will remain confidential)
				</p>
				<ul style='list-style-type:disc'>
  					<li>Do you personally know $name?</li>
					<li>Do you trust $name to act responsibly and respectfully?</li>
					<li>Do you feel $name would fit in well at FSW?</li>
					<li>Can you tell us a bit about $name in your own words?</li>
					<li>Does $name have any issues with anyone you know at FSW?</li>
					<li>Is there any reason you would suggest we not invite $name?</li>
				</ul>
				www.furryskiweekend.com
			</body>
		</html>
	";
	//-----------------------------------------------------------------------------------------------------------
	FSW_HTML_Email($to, $subject, $message);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Update_FSW_Status()
{
	//-----------------------------------------------------------------------------------------------------------
	$userID = base64_decode($_REQUEST['i']);
	$displayName = base64_decode($_REQUEST['d']);
	$email = base64_decode($_REQUEST['e']);

	if(!is_null($_REQUEST['h']))
		$house = base64_decode($_REQUEST['h']);

	if(!is_null($_REQUEST['b']))
		$bed = base64_decode($_REQUEST['b']);

	$type = $_REQUEST['approval'];
	//-----------------------------------------------------------------------------------------------------------
	switch($type)
	{
		case "Approve":
			update_user_meta($userID, 'fsw_status', 'Approved - Payment Required');
			Change_Role($userID,'customer');
			break;
		case "Waitlist":
			update_user_meta($userID, 'fsw_status', 'Waitlist');
			Change_Role($userID,'subscriber');
			break;
		case "Decline":
			update_user_meta($userID, 'fsw_status', 'Declined');
			Change_Role($userID,'subscriber');
			break;
		case "Paid":
			update_user_meta($userID, 'fsw_status', 'Approved - Paid');
			Change_Role($userID,'subscriber');
			break;
		case "Update":
			update_user_meta($userID, 'fsw_house', $house);
			update_user_meta($userID, 'fsw_bed', $bed);
			break;
		case "Refunded":
			update_user_meta($userID, 'fsw_status', 'Not Registered');
			break;
		case "Rescinded":
			update_user_meta($userID, 'fsw_status', 'Approved - Paid');
			break;
	}
	//-----------------------------------------------------------------------------------------------------------
	$newStatus = get_user_meta( $userID, 'fsw_status', true );
	$currentHouse = get_user_meta( $userID, 'fsw_house', true );
	$currentBed = get_user_meta( $userID, 'fsw_bed', true );
	//-----------------------------------------------------------------------------------------------------------
	$to = $email;
	$subject = $displayName . ', your new status for FSW-' . FSW_Registration_Year() . ' is: ' . $newStatus;
	$message = Get_FSW_Email_Message($userID, $displayName, $type);
	//-----------------------------------------------------------------------------------------------------------
	FSW_Email($to, $subject, $message);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Email_Message($userID, $displayName, $type)
{
	//-----------------------------------------------------------------------------------------------------------
	$newStatus = get_user_meta($userID, 'fsw_status', true);
	//-----------------------------------------------------------------------------------------------------------
	$message .= 'User: ' . $displayName . "\r\n";
	$message .= 'New Status: ' . $newStatus . "\r\n";
	$message .= 'Description: ' . Get_FSW_StatusMessage($newStatus)  . "\r\n";
	//-----------------------------------------------------------------------------------------------------------
	if($type == "Update")
	{
		$message .= 'House: ' . get_user_meta( $userID, 'fsw_house', true ) . "\r\n";
		$message .= 'Bed: ' . get_user_meta( $userID, 'fsw_bed', true ) . "\r\n";
	}
	//-----------------------------------------------------------------------------------------------------------
	$message .= "\r\n" . 'www.furryskiweekend.com';
	//-----------------------------------------------------------------------------------------------------------
	return $message;
	//-----------------------------------------------------------------------------------------------------------
} 
//-----------------------------------------------------------------------------------------------------------
function Reset_FSW_Registration_Status()
{	
	//-----------------------------------------------------------------------------------------------------------
	$filter = array('exclude' => array('1','5','7'), 'fields' => array('ID'));
	//-----------------------------------------------------------------------------------------------------------
	foreach ( get_users($filter) as $user )
	{
		update_user_meta($user->ID, 'fsw_status', 'Not Registered');
		update_user_meta($user->ID, 'fsw_roommates', '');
		update_user_meta($user->ID, 'fsw_house_preference', 'None');
		update_user_meta($user->ID, 'fsw_house', 'None');
		update_user_meta($user->ID, 'fsw_bed', 'None');
		update_user_meta($user->ID, 'fsw_qsent', '');
	}
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Email_FSW_Users()
{
	//-----------------------------------------------------------------------------------------------------------
	$subject = $_REQUEST['subject'];
	$message = $_REQUEST['message'];
	$emails = $_REQUEST['emails'];
	//-----------------------------------------------------------------------------------------------------------
	foreach (explode(",", $emails) as $email)
		FSW_Email($email, $subject, $message);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
?>