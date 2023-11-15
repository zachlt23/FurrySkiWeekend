<?php

$FSW_Houses = array('None', '1 - Murr Purr Prime (22)', '2 - The Softest Spot (6)', '3 - Far Space Spice Outpost (9)', '4 - Convergence Station Annex (7)', '5 - Only Fire Lives Here (8)', '6 - The House of Screams (5)', '7 - ASB Dorms (6)');

$FSW_Beds = array('None', 'King', 'Queen', 'Twin', 'Bunk', 'Sleeper', 'Single', 'Double');

$FSW_Airlines = array('', 'Air Canada', 'Alaskan', 'American', 'Delta', 'Frontier', 'Jet Blue', 'Other', 'Southwest', 'Spirit', 'United', 'Virgin', 'West Jet');

$FSW_AttendanceTypes = array('Full Event', "Daypass");

$FSW_DietaryRestrictions = array('None','Allergy - Dairy','Allergy - Eggs','Allergy - Fish','Allergy - Gluten','Allergy - Peanuts','Allergy - Shellfish','Allergy - Soy','Allergy - Tree Nuts','Allergy - Other',
    'Restriction - Kosher','Restriction - Pescatarian','Restriction - Vegetarian','Restriction - Keto','Restriction - Vegan');

function FSW_Registration_Year()
{
    return (date("m") > 2) ? date("Y") + 1 : date("Y");
}

function Is_FSW_Registration_Open()
{
    return ((date("m") <= 2) || (date("m") >= 9));
}

function FSW_Can_Register($userID)
{
    $status = get_user_meta($userID, 'fsw_status', true );
    return ($status == 'Not Registered') && (Is_FSW_Registration_Open());
}

function FSW_Set_Default_Status_If_Needed($userID)
{
    $status = get_user_meta($userID, 'fsw_status', true );
    if(($status == '') || ($status == 'Please Select'))
            update_user_meta($userID, 'fsw_status', 'Not Registered');
}

function FSW_Can_Request_Refund($userID)
{
    return (get_user_meta($userID, 'fsw_status', true ) == "Approved - Paid");
}

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

function FSW_Email($email_to, $subject, $message)
{
    $headers = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
    $headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
    $additional = '-f registration@furryskiweekend.com';

    mail($email_to, $subject, $message, $headers, $additional);
}

function FSW_WP_Email($email_to, $subject, $message)
{
    $headers[] = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
    $headers[] = "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";

    wp_mail($email_to, $subject, $message, $headers);
}

function FSW_HTML_Email($email_to, $subject, $message)
{
    $headers = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $additional = '-f registration@furryskiweekend.com';

    mail($email_to, $subject, $message, $headers, $additional);
}

function FSW_HTML_WP_Email($email_to, $subject, $message)
{
    $headers[] = 'From: FSW Registration <registration@furryskiweekend.com>';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    $response = wp_mail($email_to, $subject, $message, $headers);
}

function FSW_BCC_Email($emails, $subject, $message)
{
    $to = "registration@furryskiweekend.com";
    $headers .= "Bcc: $emails \r\n";
    $headers = 'From: FSW Admin <registration@furryskiweekend.com>' . "\r\n";
    $headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
    $additional = '-f registration@furryskiweekend.com';
    
    mail($to, $subject, $message, $headers, $additional);
}

function Create_Header_Row($name, $value)
{
    $html .= '<tr>';
    $html .= '<th>' . $name . '</th>';
    $html .= '<td>' . $value . '</td>';
    $html .= '</tr>';
    return $html;
}

function Get_DietaryRestrictions($userID)
{
    $restriction = get_user_meta($userID, 'FSW_Dietary_Restrictions', true);
    return Get_FSW_Select($GLOBALS['FSW_DietaryRestrictions'],$restriction, 'select_restriction_pref','restriction_pref');
}

//This is for the preferences page
function Get_House_Prefs($userID)
{
    $house = get_user_meta($userID, 'fsw_house_preference', true);
    return Get_FSW_Select($GLOBALS['FSW_Houses'], $house , 'select_house_pref', 'house_pref');
}

//This is for the Admin page
function Get_Houses_Select($userID)
{
    $id = 'select_house_' . $userID;
    $house = get_user_meta($userID, 'fsw_house', true);
    return Get_FSW_Select($GLOBALS['FSW_Houses'], $house , $id, 'houses');
}

function Get_Airline_Select($userID)
{
    $airline = get_user_meta($userID, 'FSW_Airline', true);
    return Get_FSW_Select($GLOBALS['FSW_Airlines'], $airline, 'travel_airline_select', 'airline');
}

function Get_Attendance_Select($userID)
{
    $attendance = get_user_meta($userID, 'FSW_AttendanceType', true);
    return Get_FSW_Select($GLOBALS['FSW_AttendanceTypes'], $attendance, 'attendance_select', 'attendance');
}

function Get_Beds_Select($userID)
{
    $id = 'select_bed_' . $userID;
    $bed = get_user_meta($userID, 'fsw_bed', true);
    return Get_FSW_Select($GLOBALS['FSW_Beds'], $bed, $id, 'beds');
}

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

function Get_SO_Select($userID)
{
    $filter = array('fields' => array('display_name'));

    $values = array('none');
    
    foreach(get_users($filter) as $user)
    {
        array_push($values, $user->display_name);
    }
    
    $so = get_user_meta($userID, 'FSW_SO', true);
    return Get_FSW_Select($values, $so, "select_so", "significantOtter");
}

function Get_User_Select()
{
    $html .= '<select id="select_roommates">';
    
    foreach(Get_AttendingUsers() as $user)
    {
            $html .= '<option value="' . $user->display_name . '">' . $user->display_name . '</option>';
    }
    $html .= '</select>';

    return $html;
}

function Get_AttendingUsers()
{
    $filter = array('fields' => array('display_name','ID'),
                    'meta_query' => array('relation' => 'OR',
                                            array('key' => 'fsw_status', 'value' => 'Approved - Paid'),
                                            array('key' => 'fsw_status', 'value' => 'Approved - Payment Required')
                                        )
                    );
    
    return get_users($filter);
}

function Get_FSW_Users($status, $role)
{
    $user_query = Get_FSW_UserFilter($status, $role);
    return get_users($user_query);
}

function Get_FSW_UserFilter($status, $role)
{
    return  array('role' => $role,
                  'meta_key' => 'fsw_status', 
                  'meta_value' => $status,
                  'exclude' => array('1','5','7'),
                  'orderby' => 'display_name',
                  'order' => 'ASC', 
                  'fields' => array('ID','display_name','user_email'));
}

function Get_User_Email_Select($id)
{
    $filter = array('order' => 'ASC','orderby' => 'display_name','fields' => array('display_name','user_email'));
    $html .= "<select id=$id>";
    foreach(get_users($filter) as $user)
    {
            $html .= "<option value='$user->display_name|$user->user_email'>$user->display_name</option>";
    }
    $html .= '</select>';

    return $html;
}

function Get_FSW_Emails()
{
    $emails = array();
    $filter = array('fields' => array('user_email'));
    foreach(get_users($filter) as $user)
    {
            array_push($emails, $user->user_email);
    }
    return implode(",",$emails);
}

function Get_FSW_Status_Count($status, $role)
{
    $filter = Get_FSW_UserFilter($status, $role);
    $user_query = new WP_User_Query($filter); 
    return $user_query->get_total();
}

function Get_FSW_StatusMessage($status)
{

    $fsw = "FSW-" . FSW_Registration_Year();

    switch($status)
    {
            case "Pending":
                return "Your request to attend " . $fsw . " has been received and is being reviewed";
            case "Waitlist":
                return "You were not selected for ". $fsw . ", but you have been added to our waitlist."
                    . "<br><br><b><u>What to expect:</u></b>"
                    . "<ul style='list-style-type:disc'>"
                    . "<li>Every year, for a variety of reasons, people who have been approved cannot attend. As those spaces become available we will fill them from the waitlist."
                    . "<li>Most cancelations will happen in the first four weeks after approvals have been sent out, which will include anyone who has not paid in that time."
                    . "<li>Once that window has passed, we do still tend to have a few people drop out, so there is still a chance of being selected."
                    . "<li>Note: Unless approved, you will remain on the wait-list indefinitely."
                    . "</ul>"
                    . "<br>No matter the outcome, we want to thank you for applying, and please know that you can apply again next year."
                    . "<br>- FSW Staff";
            case "Approved - Payment Required":
                return "You have been approved for " . $fsw . ". You have four weeks to complete your paymet to secure your spot. (https://furryskiweekend.com/shop/)";
            case "Approved for Daypass - Payment Required":
                return  "You have been approved to purchase a " . $fsw . " daypass. (https://furryskiweekend.com/shop/)";
            case "Approved - Paid":
                return "You are approved and paid for " . $fsw . ". We look forward to having you! Please join our private FSW telegram chat: https://t.me/+2Em2YQa7VrpjOGVh";
            case "Declined":
                return "You were not selected for " . $fsw . ". Thank you for applying.";
            case "Not Registered":
                return "You have not yet requested to attend " . $fsw;
            case "Refund Requested":
                return "Your request for a refund is currently being evaluated.";
            default:
                return "N/A";
    }
}

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

function Write_FSW_Log($log)
{
    if (is_array($log) || is_object($log)) 
    {
       error_log(print_r($log, true), 0);
    } 
    else 
    {
       error_log($log, 0);
    }
 }

?>
