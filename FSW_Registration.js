//-----------------------------------------------------------------------------------------------------------
function Add_Roommate()
{
	//-----------------------------------------------------------------------------------------------------------
	var table = document.getElementById('roommate_table');
	var roommates = document.getElementById('select_roommates');
	var sRoommate = roommates.options[roommates.selectedIndex].text;
	var existingItem = document.getElementById('roommate_' + sRoommate );
	//-----------------------------------------------------------------------------------------------------------
	//If no value is selected or we've already added the name, don't add it
	if((sRoommate == "") || (existingItem != null))
		return;
	//-----------------------------------------------------------------------------------------------------------
	var row = document.createElement('tr');
	var header = document.createElement('th');
	var value = document.createElement('td');

	header.innerHTML = sRoommate;
	value.innerHTML = '<input type="button" value="Remove" onclick="Remove_Roommate(\'roommate_' + sRoommate + '\')"/>';
	row.id = 'roommate_' + sRoommate;

	table.appendChild(row);
	row.appendChild(header);
	row.appendChild(value);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Remove_Roommate(id)
{
	var row = document.getElementById(id);
	row.parentNode.removeChild(row);
}
//-----------------------------------------------------------------------------------------------------------
function Set_Preferences()
{
	//-----------------------------------------------------------------------------------------------------------
	var table = document.getElementById('roommate_table');
	
	var roommates = "";

	for (i = 0; i < table.rows.length ; i++) 
	{
    		if(roommates == "")
			roommates = table.rows[i].cells[0].innerHTML;
		else
			roommates += "," + table.rows[i].cells[0].innerHTML;
	}
	//-----------------------------------------------------------------------------------------------------------
	var house = document.getElementById('select_house_pref');
	var sHouse = house.options[house.selectedIndex].value;
        //-----------------------------------------------------------------------------------------------------------
        //var attendanceSelect = document.getElementById('attendance_select');
        //var attendanceType = attendanceSelect.options[attendanceSelect.selectedIndex].value;
	//-----------------------------------------------------------------------------------------------------------
	document.getElementById('pref_roommates').value = window.btoa(roommates);
	document.getElementById('pref_house').value = window.btoa(sHouse);
        //document.getElementById('pref_attendance').value = window.btoa(attendanceType);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function FSW_Update_Travel()
{
	//-----------------------------------------------------------------------------------------------------------
	var arrivalTime = document.getElementById('travel_arrival_mTime').value;
	var departureTime = document.getElementById('travel_departure_mTime').value;
	var airline = document.getElementById('travel_airline_select').value;
	var arrivalDate = document.getElementById('travel_arrival_date').value;
	var departureDate = document.getElementById('travel_departure_date').value;
	//-----------------------------------------------------------------------------------------------------------
	if(!Validate_Date(arrivalDate))
		document.getElementById('travel_arrival_date').value = "";
	if(!Validate_Date(departureDate))
		document.getElementById('travel_departure_date').value = "";
	//-----------------------------------------------------------------------------------------------------------
	document.getElementById('hidden_arrival_time').value = arrivalTime;
	document.getElementById('hidden_departure_time').value = departureTime;
	document.getElementById('hidden_airline').value = airline;
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------
function Validate_Date(date)
{
	if(date.length != 10)
		return false;
	
	var dateSplit = date.split('-');

	if(dateSplit.length != 3)
		return false;

	if(dateSplit[0].length != 4)
		return false

	var year = parseInt(dateSplit[0]);
	var month = parseInt(dateSplit[1]);
	var day = parseInt(dateSplit[2]);
	
	if(isNaN(year) || isNaN(month) || isNaN(day))
		return false;

	return ((month >= 1 && month <= 12) && (day >= 1 && day <= 31));	
}
//-----------------------------------------------------------------------------------------------------------