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

$(document).ready(function () {
});
