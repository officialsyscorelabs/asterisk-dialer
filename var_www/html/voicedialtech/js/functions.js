$(function() {
 $("#createcampaign").click(function() {
    var campaign_name = $("#campaign").val();
    var camp_desc = $("#description").val();
    var carrier_ip = $("#carrierip").val();
    var carrier_prefix = $("#carrierprefix").val();
    var leadid = $("#leadset option:selected").val();
    var leadname = $("#leadset option:selected").text();
	
    var dataString = 'leadname='+leadname+'&campaign_name='+campaign_name+'&camp_desc='+camp_desc+'&carrier_ip='+carrier_ip+'&carrier_prefix='+carrier_prefix+'&leadid='+leadid;

    if((campaign_name=='')||(carrier_ip=='')||(leadid=='')){
		alert("please complete the form");
	}
	else
	{
		$.ajax({
				type: "POST",
				url: "core_campaign.php",
				data: dataString,
				cache: false,
				beforeSend: function(html) {
										document.getElementById("response_camp").innerHTML = ''; 
									},
				success: function(html){
										$("#response_camp").append(html);  
									}
				});
		
	}
		return false;
	});	
});