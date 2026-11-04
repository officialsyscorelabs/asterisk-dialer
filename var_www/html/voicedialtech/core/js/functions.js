
$(function()
{  


   $("#submit-23846").click(function()
   {
   var cleardata = $("#cleardata-23846").val();
   var listid = $("#submit-23846").val();
   alert(listid); 
   if((cleardata=="")||(listid=="")){}
   else{
   $.get("/unique/core/lib/autofilter.php", {listid: listid, cleardata: cleardata } );}
   alert("Timer Updated");
   window.location.reload();
   });

   $("#submit-23847").click(function()
   {
   var cleardata = $("#cleardata-23847").val();
   var listid = $("#submit-23847").val();
   alert(listid); 
   if((cleardata=="")||(listid=="")){}
   else{
   $.get("/unique/core/lib/autofilter.php", {listid: listid, cleardata: cleardata } );}
   alert("Timer Updated");
   window.location.reload();
   });

   $("#submit-23848").click(function()
   {
   var cleardata = $("#cleardata-23848").val();
   var listid = $("#submit-23848").val();
   if((cleardata=="")||(listid=="")){}
   else{
   $.get("/unique/core/lib/autofilter.php", {listid: listid, cleardata: cleardata } );}
   alert("Timer Updated");
   window.location.reload();
   });

   $("#submit-23849").click(function()
   {
   var cleardata = $("#cleardata-23849").val();
   var listid = $("#submit-23846").val();
   alert(listid); 
   if((cleardata=="")||(listid=="")){}
   else{
   $.get("/unique/core/lib/autofilter.php", {listid: listid, cleardata: cleardata } );}
   alert("Timer Updated");
   window.location.reload();
   });

   $("#submit-23850").click(function()
   {
   var cleardata = $("#cleardata-23850").val();
   var listid = $("#submit-23850").val();
   alert(listid); 
   if((cleardata=="")||(listid=="")){}
   else{
   $.get("/unique/core/lib/autofilter.php", {listid: listid, cleardata: cleardata } );}
   alert("Timer Updated");
   window.location.reload();
   });

   $("#submit-23851").click(function()
   {
   var cleardata = $("#cleardata-23851").val();
   var listid = $("#submit-23851").val();
   alert(listid); 
   if((cleardata=="")||(listid=="")){}
   else{
   $.get("/unique/core/lib/autofilter.php", {listid: listid, cleardata: cleardata } );}
   alert("Timer Updated");
   window.location.reload();
   });

});