function now() 
{
	var d = new Date;
	return sprintf(
		'%04d-%02d-%02d %02d:%02d', 
		d.getFullYear(),
		d.getMonth()+1,
		d.getDate(),
		d.getHours(),
		d.getMinutes()
	);
}

function status_change(partid,field,value,contactid)
{
	var params = new Object;
	var ts = now();
	params[field] = value;
	params['return'] = field;
	params['partid'] = partid;
	$.post(
		'index.php?action=participants/updateajax',
		params,
		function (data) {
			if (data != value) {
				alert(data);
				return;
			}
			$('.'+contactid+'-'+field+'-res').html('<i>saved</i>').show().fadeOut(2000);
			$('#'+contactid+'-'+field+'-reason').val(value);
			$('#'+contactid+'-'+field+'-partcontacted').val(ts);
			$('.'+contactid+'-'+field+'-').show().fadeIn(2000);
		}
	);
}

function status_ts(partid, statusid, ts) 
{
	if (statusid == null || statusid == '') return;

	var value = $('#'+statusid).val();
	if (value == null) return;

	if (ts == null || !ts.match(/^\d{4}-\d{2}-\d{2}/)) {
		alert("bad timestamp "+ts)
		return;
	}

	switch (statusid) {
	case 'eligible':
		field = 'eligiblechanged';
	break;
	case 'status':
		field = 'statuschanged';
	break;
	case 'consent':
		switch (value) {
		case 'verbal consent':
			field = 'verbalconsent';
		break;
		case 'written consent':
			field = 'writtenconsent';
		break;
		case 'verbal consent declined':
		case 'written consent declined':
			field = 'declinedconsent';
		break;
		default: return;
		}
	break;
	default: return;
	}
	var params = new Object;
	params[field] = ts;
	params['partid'] = partid;
	params['return'] = field;
	$.post(
		'index.php?action=participants/updateajax',
		params,
		function (data) {
		}
	);
}

function statusreason_change(partid,field,value,contactid) 
{
	var params = new Object;
	params[field] = value;
	params['return'] = field;
	params['partid'] = partid;
	$.post(
		'index.php?action=participants/updateajax',
		params,
		function(data) {
			if (data == value) {
				$('.'+contactid+'-'+field+'-res').html('<i>saved</i>').show().fadeOut(2000);
			} else {
				alert(data);
			}
		}
	);
}

function save_contactlog(formid,partid,userid,role,rolegroup,statusid)
{
	if (formid != '' && partid != '' && userid != '' && role != '' && rolegroup != '') {
		var ts = $(formid+'partcontacted').val();
		if (ts == null || ts == '') {
			alert("missing contact date and time");
			return;
		}
		// updates participants table status based on contact log message context
		status_ts(partid, statusid, ts);
		var params = {
				partid: partid,
				userid: userid,
				userrole: role,
				usergroup: rolegroup,
				contacted: ts,
				contactedprev: $(formid+'partcontactedprev').val(),
				answered: $(formid+'answered:checked').val(),
				messageleft: $(formid+'messageleft:checked').val(),
				method: $(formid+'method :selected').val(),
				reason: $(formid+'reason').val(),
				statusid: statusid
			};
		$.post(
			'index.php?action=participants/contactlogajax',
			params,
			function (data) {
				if (data == 'OK') location.reload();
				else alert(data);
			}
		);
	} else {
		alert("missing data!");
	}
}

function del_contactlog(formid,partid,userid,role,rolegroup)
{
	if (partid != '' && userid != '' && role != '' && rolegroup != '') {
		if (!confirm('Delete this contact log entry?')) return;
		var params = {
				partid: partid,
				userid: userid,
				userrole: role,
				usergroup: rolegroup,
				contacted: $(formid+'partcontacted').val(),
				method: 'delete',
			};
		if (params['contacted'] == null || params['contacted'] == '') {
			alert("missing contact date");
			return;
		}
		$.post(
			'index.php?action=participants/contactlogajax',
			params,
			function (data) {
				if (data == 'OK') location.reload();
				else alert(data);
			}
		);
	} else {
		alert("missing data!");
	}
}

function assign_part(partid,userid,role,field)
{
	if (userid == null || userid == '') {
		if (!confirm('Remove participant '+partid+' assignment?')) return;
	} else {
		if (!confirm('Assign participant '+partid+' to your participants?')) return;
	}

	if (partid != "") {
		switch (role) {
		case 'admin':
		case 'adminra':
			break;
		case 'NFP':
			if (field == 'nurse') break;
		case 'SFI':
		case 'SFIMGR':
			if (field == 'interviewer') break;
		default:
			alert(role+"s cannot change this type of assignment");
			return;
		}
		var params = {};
		params['partid'] = partid;
		params['return'] = field;
		params[field] = userid;
		$.post(
			'index.php?action=participants/updateajax',
			params,
			function (data) {
				location.reload();
			}
		);
	}
}

function open_parttab(tab,id,me) 
{
	$('.parttablink').css('background-color','white');
	$('.parttab').hide();
	$(id).show();
	$(me).parent().css('background-color','#eee');
	$.get(
		'index.php?action=participants/settabajax&tab='+tab,
		function (data) {
			if (data) alert(data);
		}
	);
}

function show_phn(partid)
{
	if (partid > 0) {
		$.get(
			'index.php?action=participants/getphnajax',
			{partid: partid},
			function (data) {
				alert(data);
			}
		);
	}
}

function send_pw(userid) 
{
	if (!confirm("send password email to "+userid+"?")) return;
	$.get(
		'index.php?action=users/sendpwajax',
		{userid: userid},
		function (data) {
			alert(data);
		}
	);
}

function check_userid(userid,id)
{
	var valid = false;
	$.get(
		'index.php?action=users/checkuseridajax',
		{userid: userid},
		function (data) {
			if (data == 'OK') { 
				valid = true; 
				$(id).removeClass('error').html("user id available").show().fadeOut(3000);
			} else {
				$(id).addClass('error').html("error: "+data).show().fadeOut(3000);
			}
		}
	);
	return valid;
}

function save_notes(partid)
{
	save_partfield(partid,'notes');
}

function save_nursenotes(partid)
{
	save_partfield(partid,'nursenotes');
}

function save_nurse(partid)
{
	$('#partnursetext'+partid).val($('#partnurse'+partid+'sel').val());
	save_partfield(partid,'nurse');
}

function save_partfield(partid,field)
{
	var params = new Object();
	params['partid'] = partid;
	params[field] = $('#part'+field+'text'+partid).val(),
	params['return'] = field;

	$.post(
		'index.php?action=participants/updateajax',
		params,
		function (data) {
			$('#part'+field+'text'+partid).text(data);
			$('#part'+field+'saved'+partid).html('<i>saved</i>').show().fadeOut(2000);
		}
	);
}

function save_visit(partid)
{
	var surveyid = $('#partvisitsurvey'+partid).val();
	var visited = $('#partvisitdate'+partid).val();
	var visittime = $('#partvisittime'+partid).val();
	var userid = $('#partvisitra'+partid).val();
	update_schedule(partid,surveyid,visited,visittime,userid,'partvisit');
}

function save_carevisit(partid)
{
	var surveyid = 0;
	var visited = $('#partcarevisitdate'+partid).val();
	var visittime = $('#partcarevisittime'+partid).val();
	var userid = $('#partcarevisitnurse'+partid).text();
	update_schedule(partid,surveyid,visited,visittime,userid,'partcarevisit');
}

function del_schedule(partid,surveyid)
{
	if (!confirm("Delete this visit?")) return;
	$.post(
		'index.php?action=visits/delajax',
		{
			partid: partid,
			surveyid: surveyid
		},
		function (data) {
			if (data == 'OK') {
				location.reload();
			}
			else alert(data);
		}
	);
}

function update_schedule(partid,surveyid,visited,visittime,loc,userid,domid)
{
	$.post(
		'index.php?action=visits/updateajax',
		{
			partid: partid,
			visited: visited,
			visittime: visittime,
			'location': loc,
			userid: userid,
			surveyid: surveyid
		},
		function (data) {
			if (data == 'OK') {
				location.reload();
			}
			else alert(data);
		}
	);
}

$(document).ready(function () {
	$('.visitdate').datepicker({dateFormat: 'yy-mm-dd'});
	// $('.partcontacted').datepicker({dateFormat: 'yy-mm-dd'});
	$('.dateofbirth').datepicker({dateFormat: 'yy-mm-dd'});
});
