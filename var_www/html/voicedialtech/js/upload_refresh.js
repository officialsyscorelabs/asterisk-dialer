

var auto_refresh = setInterval(
function ()
{
$('#excelfile').load('data.php').fadeIn("slow");
}, 5000);
