<?php
//-----------------------------------------------------------------------------------------------------------
//Includes the methods
require_once(plugin_dir_path(__FILE__) . 'FSW_Methods.php');
//Includes a number of WP functions. We use this for email
include('/wordpress/core/' . $wp_version . '/wp-includes/pluggable.php');
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
    $role = 'subscriber';
    $count = Get_FSW_Status_Count($status, $role);

    $html .= '<form class="pending" method="post">';
    $html .= '<table class="FSW_Users">';
    $html .= "<caption>Pending Users - $count</caption>";
    $html .= '<tr>';
    $html .= '<th>Display Name</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Approve</th>';
    $html .= '<th>Approve Daypass</th>';
    $html .= '<th>Waitlist</th>';
    $html .= '<th>Decline</th>';
    $html .= '<th>Send Questionnaire</th>';
    $html .= '</tr>';
    $html .= Build_FSW_Users($status, $role, 'p');
    $html .= '</table>';
    $html .= Get_FSW_Table_Input('p');
    $html .= '</form>';

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Approved_Daypass_Table()
{
    $status = 'Approved for Daypass - Payment Required';
    $role = 'customer';
    $count = Get_FSW_Status_Count($status, $role);

    $html .= '<form class="approved" method="post">';
    $html .= '<table class="FSW_Users">';
    $html .= "<caption>Approved for Daypass Users - $count</caption>";
    $html .= '<tr>';
    $html .= '<th>Display Name</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Paid</th>';
    $html .= '<th>Waitlist</th>';
    $html .= '</tr>';
    $html .= Build_FSW_Users($status, $role, 'ad');
    $html .= '</table>';
    $html .= Get_FSW_Table_Input('ad');
    $html .= '</form>';

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Approved_Table()
{
    $status = 'Approved - Payment Required';
    $role = 'customer';
    $count = Get_FSW_Status_Count($status, $role);

    $html .= '<form class="approved" method="post">';
    $html .= '<table class="FSW_Users">';
    $html .= "<caption>Approved Users - $count</caption>";
    $html .= '<tr>';
    $html .= '<th>Display Name</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Paid</th>';
    $html .= '<th>Waitlist</th>';
    $html .= '</tr>';
    $html .= Build_FSW_Users($status, $role, 'a');
    $html .= '</table>';
    $html .= Get_FSW_Table_Input('a');
    $html .= '</form>';

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Paid_Table()
{
    $status = 'Approved - Paid';
    $role = 'subscriber';
    $count = Get_FSW_Status_Count($status, $role);

    $html .= '<form class="approved" method="post">';
    $html .= '<table class="FSW_Users">';
    $html .= "<caption>Paid Users - $count</caption>";
    $html .= '<tr>';
    $html .= '<th>Display Name</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>House Preference</th>';
    $html .= '<th>Roommate Preference</th>';
    $html .= '<th>Significan Otter</th>';
    $html .= '<th>Roommate</th>';
    $html .= '<th>House</th>';
    $html .= '<th>Bed</th>';
    $html .= '<th>Update</th>';
    $html .= '</tr>';
    $html .= Build_FSW_Users($status, $role, 'h');
    $html .= '</table>';
    $html .= Get_FSW_Table_Input('h');
    $html .= '</form>';

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Waitlist_Table()
{
    $status = 'Waitlist';
    $role = 'subscriber';
    $count = Get_FSW_Status_Count($status, $role);

    $html .= '<form class="approved" method="post">';
    $html .= '<table class="FSW_Users">';
    $html .= "<caption>Waitlist - $count</caption>";
    $html .= '<tr>';
    $html .= '<th>Display Name</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Approve</th>';
    $html .= '<th>Decline</th>';
    $html .= '</tr>';
    $html .= Build_FSW_Users($status, $role, 'w');
    $html .= '</table>';
    $html .= Get_FSW_Table_Input('w');
    $html .= '</form>';

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Refund_Table()
{
    $status = 'Refund Requested';
    $role = 'subscriber';
    $count = Get_FSW_Status_Count($status, $role);

    $html .= '<form class="approved" method="post">';
    $html .= '<table class="FSW_Users">';
    $html .= "<caption>Requesting Refunds - $count</caption>";
    $html .= '<tr>';
    $html .= '<th>Display Name</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Refunded</th>';
    $html .= '<th>Rescinded</th>';
    $html .= '</tr>';
    $html .= Build_FSW_Users($status, $role, 'r');
    $html .= '</table>';
    $html .= Get_FSW_Table_Input('r');
    $html .= '</form>';

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Build_FSW_Users($status, $role, $buttonType)
{
    foreach(Get_FSW_Users($status, $role) as $user)
    {
        $html .= '<tr>';
        $html .= "<td><a href='https://furryskiweekend.com/profile/$user->ID' target='_blank'>$user->display_name</a></td>";
        $html .= '<td>' . $user->user_email . '</td>';
        $html .=  Get_FSW_User_Buttons($buttonType, $user->ID, $user->display_name, $user->user_email);
        $html .= '</tr>';
    }
    return $html;
}

function Get_FSW_Table_Input($prefix)
{
    $html .= '<input type="hidden" name="i" id="' . $prefix . '_i" value="">'; //ID
    $html .= '<input type="hidden" name="d" id="' . $prefix . '_d" value="">'; //Display Name
    $html .= '<input type="hidden" name="e" id="' . $prefix . '_e" value="">'; //Email
    $html .= '<input type="hidden" name="h" id="' . $prefix . '_h" value="">'; //House
    $html .= '<input type="hidden" name="b" id="' . $prefix . '_b" value="">'; //Bed
    $html .= '<input type="hidden" name="r" id="' . $prefix . '_r" value="">'; //Roommate
    
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
            case "ad":
                    return Get_FSW_Approved_Buttons($parameters);
            case "h":
                    return Get_FSW_Paid_Buttons($userID, $parameters);
            case "w":
                    return Get_FSW_Waitlist_Buttons($parameters);
            case "r":
                    return Get_FSW_Refund_Buttons($parameters);
            default:
                    return "";
    }
    //-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Pending_Buttons($parameters, $userID)
{
    $html .= Get_FSW_Status_Button('Approve', $parameters);
    $html .= Get_FSW_Status_Button('ApproveDayPass', $parameters);
    $html .= Get_FSW_Status_Button('Waitlist', $parameters);
    $html .= Get_FSW_Status_Button('Decline', $parameters);

    if(get_user_meta($userID, 'fsw_qsent', true ) != 'true')
    {
        $html .= '<td><input type="submit" name="questionnaire" value="Send" onclick="Update_FSW_Hidden(' . $parameters . ')"/></td>';
    }
    else
    {
        $html .= '<td>Sent</td>';
    }
    
    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Waitlist_Buttons($parameters)
{
    $html .= Get_FSW_Status_Button('Approve', $parameters);
    $html .= Get_FSW_Status_Button('Decline', $parameters);

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Paid_Buttons($userID, $parameters)
{
    $html .= '<td>' . get_user_meta($userID, 'fsw_house_preference', true) . '</td>';
    $html .= '<td>' . get_user_meta($userID, 'fsw_roommates', true) . '</td>';
    $html .= '<td>' . get_user_meta($userID, 'FSW_SO', true) . '</td>';
    $html .= '<td>' . Get_Roommates_Select($userID) . '</td>';
    $html .= '<td>' . Get_Houses_Select($userID) . '</td>';
    $html .= '<td>' . Get_Beds_Select($userID) . '</td>';
    $html .= Get_FSW_Status_Button('Update', $parameters);

    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Approved_Buttons($parameters)
{
    $html .= Get_FSW_Status_Button('Paid', $parameters);
    $html .= Get_FSW_Status_Button('Waitlist', $parameters);
    return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_Refund_Buttons($parameters)
{
    $html .= Get_FSW_Status_Button('Refunded', $parameters);
    $html .= Get_FSW_Status_Button('Rescinded', $parameters);
    return $html;
}
//-----------------------------------------------------------------------------------------------------------
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
//-----------------------------------------------------------------------------------------------------------
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
                    .sectionHeader { text-decoration: underline; }
                </style>
            </head>
            <body>
                <h1>FSW Questionnaire</h1>
                <p> 
                    Thank you for applying to FSW!<br>
                    The purpose of this questionnaire is to determine if you would be a good fit for our event. 
                    We have very limited space, and work hard to create a comfortable, close-knit environment where everyone attending can have a fantastic, unique, and memorable experience.
                    We want to accept new people who will give and get the most out of the event.
                    Please answer the following questions and email them back to us as soon as possible.
                </p>
                <ul style='list-style-type:disc'>
                    <li class='sectionHeader'>About You</li>
                        <ul>
                        <li>Why do you want to attend FSW?</li>
                        <li>We want to get to know you better. Tell us about yourself.</li>
                        <li>Can we trust you to be responsible and respectful towards all other attendees, the houses, and Copper Mountain?</li>
                        <li>Who do you know who plans to attend, or has attended in past years, who can vouch for you personally?</li>
                        <li>Is there anyone attending who you have had a negative experiences with, or has had a negative experience with you?</li>
                        <li>Alcohol, and other recreational substances, are stronger at altitude, and FSW is at ~10,000ft. Will you partake responsibly?
                        <li>Do you have any concerns or reservations about attending that we can address?</li>
                        <li>Recreational cannabis is legal in CO. Would its isolated use be an issue for you?</li>
                        </ul>
                    <li class='sectionHeader'>Administrative</li>
                        <ul>
                        <li>Have you applied in previous years?</li>
                        <li>Will you be at least 21 years old by the first day of FSW?</li>
                        <li>Have you fully read through the About section? This is required. (https://furryskiweekend.com/about/)</li>
                        <li>Have you fully filled in your profile? This helps us and others to know you better.</li>
                        </ul>
                    <li class='sectionHeader'>Transportation</li>
                        <ul>
                        <li>You are responsible for getting yourself to and from the event. Are you willing and able to do this?</li>
                        <li>If you are driving (rented or not), are you interested in letting otheres attendess carpool with you to and from FSW?</li>
                        </ul>
                    <li class='sectionHeader'>Skiing</li>
                        <ul>
                        <li>Do you ski, snowboard, both, or neither?</li>
                        <li>Rate your skill level on the mountain: Bunny, Green, Blue, Black, Double-Black</li>
                        <li>Do you have a fursuit?</li>
                        <li>Skiing in fursuit is very challenging. Do you plan on joining in, and if so, how will you prepare for it?</li>
                        </ul>
                    <li class='sectionHeader'>Helping Out and Giving Back</li>
                        <ul>
                        <li>FSW is a communal and paticipatory event. How might you exemplify these values in little ways?</li>
                        <li>Are you a photographer or videographer? Are you interested in taking video/pics of the fursuit skiing for our use? Compensation is available.</li>
                        <li>We are always looking for ways to improve our event. Are you willing to provide honest and constructive feedback to us?</li>
                        </ul>
                </ul>
                Thank you for taking the time to respond<br>
                FSW Staff<br>
                www.furryskiweekend.com
            </body>
        </html>
    ";
    //-----------------------------------------------------------------------------------------------------------
    //FSW_HTML_Email($to, $subject, $message);
    FSW_HTML_WP_Email($to, $subject, $message);
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
                    $name listed you as someone who could vouch for them personally.<br>
                    Please answer the following questions for us honestly and candidly.<br>
                    (All responses will remain strictly confidential)
                </p>
                <ul style='list-style-type:disc'>
                    <li>Do you personally know $name, and vouch for them?</li>
                    <li>Do you trust $name to act responsibly and respectfully towards all other attendees, the houses, and Copper Mountain?</li>
                    <li>Do you trust that $name can partake responsibly in all recreational substances?</li>
                    <li>Do you feel $name would be a good fit for FSW, and get a lot out of the experience?</li>
                    <li>Can you tell us a bit about $name in your own words?</li>
                    <li>As far as you know, does $name have any issues with anyone at FSW, or does anyone have any issues with them?</li>
                    <li>Do you have any reservations or concerns of any kind regarding us inviting $name?</li>
                </ul>
                Thank you for taking the time to respond<br>
                FSW Staff<br>
                www.furryskiweekend.com
            </body>
        </html>
    ";
    //-----------------------------------------------------------------------------------------------------------
    FSW_HTML_WP_Email($to, $subject, $message);
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
    {
        $house = base64_decode($_REQUEST['h']);
    }

    if(!is_null($_REQUEST['b']))
    {
        $bed = base64_decode($_REQUEST['b']);
    }

    if(!is_null($_REQUEST['r']))
    {
        $roommate = base64_decode($_REQUEST['r']);
    }

    $type = $_REQUEST['approval'];
    //-----------------------------------------------------------------------------------------------------------
    switch($type)
    {
        case "Approve":
                update_user_meta($userID, 'fsw_status', 'Approved - Payment Required');
                Change_Role($userID,'customer');
                break;
        case "ApproveDayPass":
                update_user_meta($userID, 'fsw_status', 'Approved for Daypass - Payment Required');
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
                update_user_meta($userID, 'FSW_Roommate', $roommate);
                update_user_meta($userID, 'fsw_house', $house);
                update_user_meta($userID, 'fsw_bed', $bed);
                Send_Updated_Housing_Email($userID, $displayName, $email, $roommate, $house, $bed);
                return;
        case "Refunded":
                update_user_meta($userID, 'fsw_status', 'Not Registered');
                break;
        case "Rescinded":
                update_user_meta($userID, 'fsw_status', 'Approved - Paid');
                break;
    }
    //-----------------------------------------------------------------------------------------------------------
    Send_Updated_Status_Email($userID, $displayName, $email);
    //-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Send_Updated_Housing_Email($userID, $displayName, $email, $roommate, $house, $bed)
{
    //-----------------------------------------------------------------------------------------------------------
    $to = $email;
    $subject = $displayName . ', your FSW-' . FSW_Registration_Year() . ' housing info has been updated';
    //-----------------------------------------------------------------------------------------------------------
    $message .= 'User: ' . $displayName . "\r\n";
    $message .= 'Roommate: ' . $roommate . "\r\n";
    $message .= 'House: ' . $house . "\r\n";
    $message .= 'Bed: ' . $bed . "\r\n";
    $message .= "\r\n" . 'https://furryskiweekend.com/registration-and-status';
    //-----------------------------------------------------------------------------------------------------------
    FSW_WP_Email($to, $subject, $message);
    //-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Send_Updated_Status_Email($userID, $displayName, $email)
{
    //-----------------------------------------------------------------------------------------------------------
    $newStatus = get_user_meta($userID, 'fsw_status', true);
    //-----------------------------------------------------------------------------------------------------------
    $to = $email;
    $subject = $displayName . ', your new status for FSW-' . FSW_Registration_Year() . ' is: ' . $newStatus;
    //-----------------------------------------------------------------------------------------------------------
    $message .= '<html><body>';
    $message .= '<u><b>User:</b></u> ' . $displayName;
    $message .= '<br><u><b>New Status:</b></u> ' . $newStatus;
    $message .= '<br><u><b>Description:</b></u> ' . Get_FSW_StatusMessage($newStatus);
    $message .= '<br>https://furryskiweekend.com/registration-and-status';
    $message .= "</body></html>";
    //-----------------------------------------------------------------------------------------------------------
    FSW_HTML_WP_Email($to, $subject, $message);
    //-----------------------------------------------------------------------------------------------------------
} 
//-----------------------------------------------------------------------------------------------------------
function Reset_FSW_Registration_Status()
{	
    //-----------------------------------------------------------------------------------------------------------
    //Exclude admins Tek, Dire, Tuaolo
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
        update_user_meta($user->ID, 'FSW_ArrivalDate', '');
        update_user_meta($user->ID, 'FSW_ArrivalTime', 'None');
        update_user_meta($user->ID, 'FSW_DepartureDate', '');
        update_user_meta($user->ID, 'FSW_DepartureTime', 'None');
        update_user_meta($user->ID, 'FSW_Airline', '');
        update_user_meta($user->ID, 'FSW_Roommate', '');
        update_user_meta($user->ID, 'FSW_AttendenceType', '');
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
    {
        FSW_WP_Email($email, $subject, $message);
    }
    //-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_DietaryRestrictionGrid()
{
    //-----------------------------------------------------------------------------------------------------------
    $restrictions = array();
    //-----------------------------------------------------------------------------------------------------------
    foreach ($GLOBALS['FSW_DietaryRestrictions'] as $item)
    {
        $restrictions[$item] = 0;
    }
    //-----------------------------------------------------------------------------------------------------------
    //Remove "None"
    unset($restrictions['None']);
    //-----------------------------------------------------------------------------------------------------------
    foreach ( Get_AttendingUsers() as $user )
    {
        $restrictionItem = get_user_meta($user->ID, 'FSW_Dietary_Restrictions', true);
        
        if($restrictionItem != '' && $restrictionItem != 'None')
        {
            $restrictions[$restrictionItem] += 1;
        }
    }
    //-----------------------------------------------------------------------------------------------------------
    $html .= '<table class="FSW_DietaryRestrictions">';
    $html .= '<tr>';
    $html .= '<th>Restriction</th>';
    $html .= '<th>Count</th>';
    $html .= '</tr>';
    
    foreach($restrictions as $key => $item)
    {
        $html .= '<tr>';
        $html .= '<td>' . $key . '</td>';
        $html .= '<td>' . $item . '</td>';
        $html .= '</tr>';  
    }

    $html .= '</table>';
    //-----------------------------------------------------------------------------------------------------------
    return $html;
    //-----------------------------------------------------------------------------------------------------------
}
?>