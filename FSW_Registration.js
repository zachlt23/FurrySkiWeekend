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
	var pref_roommates = document.getElementById('pref_roommates');
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
	var sHouse = house.options[house.selectedIndex].text;
	//-----------------------------------------------------------------------------------------------------------
	document.getElementById('pref_roommates').value = window.btoa(roommates);
	document.getElementById('pref_house').value = window.btoa(sHouse);
	//-----------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------