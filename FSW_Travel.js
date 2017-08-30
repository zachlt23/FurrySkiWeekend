//-----------------------------------------------------------------------------------------------------------
function FSW_Update_Travel()
{
	//-----------------------------------------------------------------------------------------------------------
	var arrivalTime = document.getElementById('travel_arrival_mTime').value;
	var departureTime = document.getElementById('travel_departure_mTime').value;
	var airline = document.getElementById('travel_airline_select').value;
	//-----------------------------------------------------------------------------------------------------------
	document.getElementById('arrival_time').value = arrivalTime;
	document.getElementById('departure_time').value = departureTime;
	document.getElementById('airline').value = airline;
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
