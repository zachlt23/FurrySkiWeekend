<?php
//-----------------------------------------------------------------------------------------------------------
function FSW_Display_TravelTimes()
{
	$html .= Get_Travel_Control();
	$html .= Get_TravelTimes_Table('Arrivals');
	$html .= '<br>';
	$html .= '<br>';
	$html .= Get_TravelTimes_Table('Departures');

	return $html;
}
//-----------------------------------------------------------------------------------------------------------
//TableTypes: Arrivals|Departures
function Get_TravelTimes_Table($TableType)
{
	switch($TableType)
	{
		case 'Arrivals':
			$Filter = Get_TravelTimes_Filter('FSW_ArrivalDate', 'FSW_ArrivalTime');
			$Caption = 'Arrivals';
			break;

		case 'Departures':
			$Filter = Get_TravelTimes_Filter('FSW_DepartureDate', 'FSW_DepartureTime');
			$Caption = 'Departures';
			break;
	}
	
	$html .= '<table class="TravelTimes">';
	$html .= '<caption>' . $Caption . '</caption>';
	$html .= '<tr>';
	$html .= '<th>Name</th>';
	$html .= '<th>Date</th>';
	$html .= '<th>Time</th>';
	$html .= '<th>Airline</th>';
	$html .= '</tr>';
	foreach(get_users($Filter) as $user)
	{
		$html .= '<tr>';
		$html .= "<td><a href='http://furryskiweekend.com/profile/$user->ID' target='_blank'>$user->display_name</a></td>";

		switch($TableType)
		{
			case 'Arrivals':
				$html .=  '<td>' . $user->FSW_ArrivalDate . '</td>';
				$html .=  '<td>' . $user->FSW_ArrivalTime . '</td>';
				break;

			case 'Departures':
				$html .=  '<td>' . $user->FSW_DepartureDate . '</td>';
				$html .=  '<td>' . $user->FSW_DepartureTime . '</td>';
				break;
		}

		$html .= '<td>' . $user->FSW_Airline . '</td>';
		$html .= '</tr>';
	}
	$html .= '</table>';
	
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
function Get_TravelTimes_Filter($DateFieldName, $TimeFieldName)
{
	//BUG: sort treats date like txt, so it fails to accurately sort by year

	return array(
			'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => 'fsw_status', 
							'value' => 'Approved - Paid'
							),
        					FSW_Date => array(
            						'key' => $DateFieldName,
                					'compare' => 'EXISTS'
        						),
        					FSW_Time => array(
            						'key' => $TimeFieldName,
                					'compare' => 'EXISTS'
        						)
						),
    			'orderby' => array( 
        					'FSW_Date' => 'ASC',
        					'FSW_Time' => 'ASC'
    						)
			);
}
//-----------------------------------------------------------------------------------------------------------
function Set_Travel_Values()
{
	//---------------------------
	//$userId = wp_get_current_user()->ID;
	//$arrivalTime = base64_decode($_REQUEST['at']);
	//$arrivalDate = base64_decode($_REQUEST['ad']);
	//$departureTime = base64_decode($_REQUEST['dt']);
	//$departureDate = base64_decode($_REQUEST['dd']);
	//$airline = base64_decode($_REQUEST['a']);
	$userID = base64_decode($_REQUEST['i']);
	//---------------------------
	update_user_meta($userID, 'FSW_ArrivalTime', $_REQUEST['at']);
	update_user_meta($userID, 'FSW_ArrivalDate', $_REQUEST['ad']);
	update_user_meta($userID, 'FSW_DepartureTime', $_REQUEST['dt']);
	update_user_meta($userID, 'FSW_DepartureDate', $_REQUEST['dd']);
	update_user_meta($userID, 'FSW_Airline', $_REQUEST['a']);
	//---------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Get_Travel_Control()
{
	//---------------------------
	$userId = wp_get_current_user()->ID;
	$arrivalTime = get_user_meta($userId, 'FSW_ArrivalTime', true );
	$arrivalDate = get_user_meta($userId, 'FSW_ArrivalDate', true );
	$departureTime = get_user_meta($userId, 'FSW_DepartureTime', true );
	$departureDate = get_user_meta($userId, 'FSW_DepartureDate', true );
	$airline = get_user_meta($userId, 'FSW_Airline', true );
	//---------------------------
	//$arrivalDate = Get_Converted_Date($arrivalDate);
	//$departureDate = Get_Converted_Date($departureDate);
	//---------------------------
	$html .= '<form method="post">';
	//---------------------------
	$html .= '<table id="travel_input">';

	$InputArrivalDate = '<input type="date" name="ad" id="travel_arrival_date" value=' . $arrivalDate . '>';
	$InputDepartureDate = '<input type="date" name="dd" id="travel_departure_date" value="' . $departureDate . '">';
	$InputAirline = Get_Airline_Select($userId);
	$ArrivalTimeSelect = Get_MilitaryTime_Select("travel_arrival_mTime", $arrivalTime);
	$DepartureTimeSelect = Get_MilitaryTime_Select("travel_departure_mTime", $departureTime);

	$html .= Create_Header_Row("Arrival Date", $InputArrivalDate); 
	$html .= Create_Header_Row("Arrival Time", $ArrivalTimeSelect);
	$html .= Create_Header_Row("Departure Date", $InputDepartureDate); 
	$html .= Create_Header_Row("Departure Time", $DepartureTimeSelect);
	$html .= Create_Header_Row("Airline", $InputAirline);

	$html .= '</table>';
	//---------------------------
	$html .= '<input type="submit" name="save_travel" id="save_travel" value="Save" onclick="FSW_Update_Travel()"/>';
	$html .= '<input type="hidden" name="at" id="hidden_arrival_time" value="">';
	$html .= '<input type="hidden" name="dt" id="hidden_departure_time" value="">';
	$html .= '<input type="hidden" name="a" id="hidden_airline" value="">';
	$html .= '<input type="hidden" name="i" id="travel_id" value="' . base64_encode($userId) . '">';
	//---------------------------
	$html .= '</form>';
	$html .= '<br/>';
	//---------------------------
	return $html;
	//---------------------------
}
//-----------------------------------------------------------------------------------------------------------
//Input: 02/21/2018
//Output: 2018-02-21
function Get_Converted_Date($date)
{
	if(strlen($date) == 10)
		return substr($date, -4, 4) . "-" . substr($date, 0, 2) . "-" . substr($date, 3, 2);

	return $date;
}
//-----------------------------------------------------------------------------------------------------------
//Input: 2018-02-21
//Output: 02/21/2018
function Get_UPME_Date($date)
{
	if(strlen($date) == 10)
		return substr($date, 5, 2) . "/" . substr($date, 8, 2) . "/" . substr($date, 0, 4);

	return $date;
}
//-----------------------------------------------------------------------------------------------------------
?>
