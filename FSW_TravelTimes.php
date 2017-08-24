<?php
//-----------------------------------------------------------------------------------------------------------
require_once(plugin_dir_path(__FILE__) . 'FSW_Methods.php');
//-----------------------------------------------------------------------------------------------------------
function Get_FSW_TravelTimes()
{
	$ArrivalFields = array( 'display_name', 'FSW_ArrivalDate', 'FSW_ArrivalTime', 'FSW_Airline' );
	$ArrivalOrderybyFields = array( 'FSW_ArrivalDate', 'FSW_ArrivalTime' );

	$DepartureFields = array( 'display_name', 'FSW_DepartureDate', 'FSW_DepartureTime', 'FSW_Airline' );
	$DepartureOrderybyFields = array( 'FSW_DepartureDate', 'FSW_DepartureTime' );

	$ArrivalFilter = array('order' => 'ASC', $ArrivalOrderybyFields, 'fields' => $ArrivalFields);
	$DepartureFilter = array('order' => 'ASC', 'orderby' => $DepartureOrderybyFields, 'fields' => $DepartureFields);

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

	$html .= '<br><br>';

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