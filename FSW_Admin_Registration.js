function Update_FSW_Hidden(type, id, name, email)
{
	//-----------------------------------------------------------------------------------------------------------
	document.getElementById(type + '_i').value = id;
	document.getElementById(type + '_d').value = name;
	document.getElementById(type + '_e').value = email;
	//-----------------------------------------------------------------------------------------------------------
	var decrypted_id = window.atob(id);
	//-----------------------------------------------------------------------------------------------------------
	var house_selector = document.getElementById('select_house_' + decrypted_id);

	if(house_selector != null)
		document.getElementById(type + '_h').value = window.btoa(house_selector.value);
	//-----------------------------------------------------------------------------------------------------------
	var bed_selector = document.getElementById('select_bed_' + decrypted_id);

	if(bed_selector != null)
		document.getElementById(type + '_b').value = window.btoa(bed_selector.value);
	//-----------------------------------------------------------------------------------------------------------
        var roommate_selector = document.getElementById('select_roommate_' + decrypted_id);

	if(roommate_selector != null)
		document.getElementById(type + '_r').value = window.btoa(roommate_selector.value);
	//-----------------------------------------------------------------------------------------------------------
}

function Enable_Reset()
{
	document.getElementById('reset_button').disabled = false;
}

function Set_FSW_Hidden_Email_Message()
{
	document.getElementById('FSW_Email_Message').value 
		= document.getElementById('FSW_Email_Message_Text').value 
}

function Set_FSW_Verification()
{
	document.getElementById('FSW_New_Registrant').value
		= document.getElementById('select_new_registrant').value;

	document.getElementById('FSW_Verifier').value
		= document.getElementById('select_verifier').value;
}