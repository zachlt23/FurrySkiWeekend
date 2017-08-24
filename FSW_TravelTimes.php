<?php
//-----------------------------------------------------------------------------------------------------------
function FSW_Display_TravelTimes()
{
	$html .= Get_TravelTimes_Table('Arrivals');
	$html .= '<br>';
	$html .= '<br>';
	$html .= Get_TravelTimes_Table('Departures');

	return $html;
}

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
?>
