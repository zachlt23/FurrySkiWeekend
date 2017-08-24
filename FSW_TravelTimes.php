<?php
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_TravelTimes()
{
	$html .= FSW_Get_Arrival_Table();
	$html .= '<br>/';
	$html .= '<br>/';
	$html .= FSW_Get_Departure_Table();

	return $html;
}

function FSW_Get_Arrival_Table()
{
	$ArrivalFields = array( 'display_name', 'FSW_ArrivalDate', 'FSW_ArrivalTime', 'FSW_Airline' );
	$ArrivalOrderbyFields = array( 'FSW_ArrivalDate', 'FSW_ArrivalTime' );
	$ArrivalFilter = array('order' => 'ASC', $ArrivalOrderbyFields, 'fields' => $ArrivalFields);
	
	$html .= '<table>';
	$html .= '<caption>Arrivals</caption>';
	$html .= '<tr>';
	$html .= '<th>Name</th>';
	$html .= '<th>Date</th>';
	$html .= '<th>Time</th>';
	$html .= '<th>Airline</th>';
	$html .= '</tr>';
	foreach(get_users($ArrivalFilter) as $user)
	{
		$html .= '<tr>';
		$html .= "<td><a href='http://furryskiweekend.com/profile/$user->ID' target='_blank'>$user->display_name</a></td>";
		$html .= '<td>' . $user->FSW_ArrivalDate . '</td>';
		$html .= '<td>' . $user->FSW_ArrivalTime . '</td>';
		$html .= '<td>' . $user->FSW_Airline . '</td>';
		$html .= '</tr>';
	}
	$html .= '</table>';
	
	return $html;
}

function FSW_Get_Departure_Table()
{
	$DepartureFields = array( 'display_name', 'FSW_DepartureDate', 'FSW_DepartureTime', 'FSW_Airline' );
	$DepartureOrderbyFields = array( 'FSW_DepartureDate', 'FSW_DepartureTime' );
	$DepartureFilter = array('order' => 'ASC', 'orderby' => $DepartureOrderbyFields, 'fields' => $DepartureFields);
	
	$html .= '<table>';
	$html .= '<caption>Departures</caption>';
	$html .= '<tr>';
	$html .= '<th>Name</th>';
	$html .= '<th>Date</th>';
	$html .= '<th>Time</th>';
	$html .= '<th>Airline</th>';
	$html .= '</tr>';
	foreach(get_users($DepartureFilter) as $user)
	{
		$html .= '<tr>';
		$html .= "<td><a href='http://furryskiweekend.com/profile/$user->ID' target='_blank'>$user->display_name</a></td>";
		$html .= '<td>' . $user->FSW_DepartureDate . '</td>';
		$html .= '<td>' . $user->FSW_DepartureTime . '</td>';
		$html .= '<td>' . $user->FSW_Airline . '</td>';
		$html .= '</tr>';
	}
	$html .= '</table>';
	
	return $html;
}
//-----------------------------------------------------------------------------------------------------------
?>
