//-----------------------------------------------------------------------------------------------------------
function FSW_Update_Travel()
{
	//-----------------------------------------------------------------------------------------------------------
	var arrivalTime = document.getElementById('travel_arrival_mTime').value;
	var departureTime = document.getElementById('travel_departure_mTime').value;
	//-----------------------------------------------------------------------------------------------------------
	document.getElementById('arrival_time').value = arrivalTime;
	document.getElementById('departure_time').value = departureTime;
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
