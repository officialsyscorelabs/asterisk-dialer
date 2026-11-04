var auto_refresh = setInterval(function ()
{$('#activediv').load('core_active_camp.php').fadeIn("slow");}, 10000);


var auto_refresh = setInterval(function ()
{$('#recentdiv').load('core_recent_camp.php').fadeIn("slow");}, 10000);


//---------------------------------------TEST ALERT-----------------------------//
function action_click(clicked_id)
{
	alert(clicked_id);
}

function delete_camp2(clicked_id){
	document.getElementById(clicked_id).innerHTML = 'Deleting..';
}


//------- DYNAMIC MODAL FORM 1---------------------------------------------------------------------------------//

function exampleOnclick(btn,divid) {
	var name = btn.innerHTML;
	var dataid=btn.id;
        var numberchannel="numberchannel"+dataid;
        var duration="duration"+dataid;
        var modifycamp="modifycamp"+dataid;

	//alert(dataid);

	var exampleModal = getExampleModal();

	// Init the modal if it hasn't been already.
	if (!exampleModal) { exampleModal = initExampleModal(); }

	var html =
      '<div class="modal-header">' +
        '<h5 class="modal-title" id="exampleModalLabel">Modify Campaign</h5>' +
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
          '<span aria-hidden="true">&times;</span>' +
        '</button>' +
      '</div>' +
      '<div class="modal-body" id="'+modifycamp+'">' +
		'	<form>' +
				'<div class="form-group">' +
					'<label for="numberchannel">Number of Channels</label>' +
					'<input type="text" class="form-control" id="'+numberchannel+'">' +
				'</div>' +
				'<div class="form-group">' +
					'<label for="duration">Call Duration</label>' +
					'<input type="text" class="form-control" id="'+duration+'">' +
				'</div>' +
			'</form>' +

      '</div>' +
      '<div class="modal-footer">' +
        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
        '<button type="button" onClick=modify_camp('+dataid+') class="btn btn-custom-tomato">Save changes</button>' +
      '</div>';

	setExampleModalContent(html);

	// Show the modal.
	jQuery(exampleModal).modal('show');
}

function getExampleModal() {
	return document.getElementById('exampleModal');
}

function setExampleModalContent(html) {
  getExampleModal().querySelector('.modal-content').innerHTML = html;
}

function initExampleModal() {
  var modal = document.createElement('div');
  modal.classList.add('modal', 'fade');
  modal.setAttribute('id', 'exampleModal');
  modal.setAttribute('tabindex', '-1');
  modal.setAttribute('role', 'dialog');
  modal.setAttribute('aria-labelledby', 'exampleModalLabel');
  modal.setAttribute('aria-hidden', 'true');
  modal.innerHTML =
        '<div class="modal-dialog" role="document">' +
          '<div class="modal-content"></div>' +
        '</div>';
  document.body.appendChild(modal);
  return modal;
}

//------- DYNAMIC MODAL FORM 2 (startcamp form)---------------------------------------------------------------------------------//

function exampleOnclick2(btn,divid) {
	var name = btn.innerHTML;
	var dataid=btn.id;
        var numberchannel="numberchannel"+dataid;
        var duration="duration"+dataid;
        var modifycamp="modifycamp"+dataid;

	//alert(dataid);

	var exampleModal = getExampleModal();

	// Init the modal if it hasn't been already.
	if (!exampleModal) { exampleModal = initExampleModal(); }

	var html =
      '<div class="modal-header">' +
        '<h5 class="modal-title" id="exampleModalLabel">Modify Campaign</h5>' +
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
          '<span aria-hidden="true">&times;</span>' +
        '</button>' +
      '</div>' +
      '<div class="modal-body" id="'+modifycamp+'">' +
		'	<form>' +
				'<div class="form-group">' +
					'<label for="numberchannel">Number of Channels</label>' +
					'<input type="text" class="form-control" id="'+numberchannel+'">' +
				'</div>' +
				'<div class="form-group">' +
					'<label for="duration">Call Duration</label>' +
					'<input type="text" class="form-control" id="'+duration+'">' +
				'</div>' +
			'</form>' +
      '</div>' +
      '<div class="modal-footer">' +
        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
        '<button type="button" onClick=start_camp('+dataid+','+divid+') class="btn btn-custom-tomato">Start Campaign</button>' +
      '</div>';

	setExampleModalContent(html);

	// Show the modal.
	jQuery(exampleModal).modal('show');
}


//------------------------------------------MODIFY CAMP--------------------------------------------------------------//

function modify_camp(clicked_id)
{
    var numberchannel="#numberchannel"+clicked_id;
    var duration="#duration"+clicked_id;
    var modifycamp="#modifycamp"+clicked_id;

    var channelvalue = $(numberchannel).val();
    var durationvalue = $(duration).val();
    var dataString = 'id='+clicked_id+'&channelvalue='+channelvalue+'&durationvalue='+durationvalue;

    if((clicked_id=='')||(channelvalue=='')||(durationvalue=='')){
		alert("please complete the form");
	}
	else
	{
		$.ajax({
				type: "POST",
				url: "core_modify_camp.php",
				data: dataString,
				cache: false,
				beforeSend: function(html) {
										document.getElementById("active_response_camp").innerHTML = ''; 
									},
				success: function(html){
										$("#active_response_camp").append(html);  
										$(modifycamp).append(html);  

									}
				});
		
	}
		return false;

}


//------------------------------------------HANGUP CAMP--------------------------------------------------------------//

function hangup_camp(clicked_id,divid)
{
    var dataString = 'id='+clicked_id;

    if(clicked_id==''){
		alert("please complete the form");
	}
	else
	{
		$.ajax({
				type: "POST",
				url: "core_hangup_camp.php",
				data: dataString,
				cache: false,
				beforeSend: function(html) {
										document.getElementById("active_response_camp").innerHTML = ''; 
									},
				success: function(html){
										$("#active_response_camp").append(html);  
                                                                                document.getElementById(divid).innerHTML = '';
									}
				});
		
	}
		return false;
}

//------------------------------------------START CAMP--------------------------------------------------------------//

function start_camp(clicked_id,divid)
{
    var numberchannel="#numberchannel"+clicked_id;
    var duration="#duration"+clicked_id;
    var modifycamp="#modifycamp"+clicked_id;
    var modifycampname="modifycamp"+clicked_id;

    var channelvalue = $(numberchannel).val();
    var durationvalue = $(duration).val();

    var dataString = 'id='+clicked_id+'&channelvalue='+channelvalue+'&durationvalue='+durationvalue;
    if((clicked_id=='')||(channelvalue=='')||(durationvalue=='')){
		alert("please complete the form");
	}
	else 
	{
		$.ajax({
				type: "POST",
				url: "core_dial_camp.php",
				data: dataString,
				cache: false,
				beforeSend: function(html) {
										document.getElementById("recent_response_camp").innerHTML = '';
									},
				success: function(html){
										$("#recent_response_camp").append(html);  
                                                                        	$(modifycamp).append(html);  

									}
				});
		
	}
		return false;
}

//------------------------------------------DELETE CAMP--------------------------------------------------------------//

function delete_camp(clicked_id,divid)
{
    var dataString = 'id='+clicked_id;

    if(clicked_id==''){
		alert("please complete the form");
	}
	else
	{
		$.ajax({
				type: "POST",
				url: "core_delete_camp.php",
				data: dataString,
				cache: false,
				beforeSend: function(html) {
										document.getElementById("recent_response_camp").innerHTML = ''; 
									},
				success: function(html){
										$("#recent_response_camp").append(html);  
                                                                                document.getElementById(divid).innerHTML = '';
									}
				});
		
	}
		return false;
}

