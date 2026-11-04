
$(function()
{  
    $("#getstats").click(function () {
        var username = $("#user").val();
        var password = $("#pass").val();
      
        var dataString = 'username='+username+'&password='+password;

        //sessionStorage.removeItem("user_unique_code");
        //sessionStorage.setItem("user_unique_code", number); 

        document.getElementById("responsecode").innerHTML = '';

        if((username.length < 5)||(password == "")){
            alert("Invalid Input");
            document.getElementById("responsecode").innerHTML = 'Invalid Input';
            return;
        }else{

        //alert(newpath);
        $.ajax({
            type: "POST",
            url: "response.php",
            data: dataString,
            //dataType: "json",
      	    //encode: true,
	    beforeSend: function(html) {
		 document.getElementById("responsecode").innerHTML = 'Initiated stats Process'; 
                 console.log(dataString);
		},

            success: function(html) {
               document.getElementById("responsecode").innerHTML = 'Recieving Response from Server';
               console.log(html);
               //$( html ).appendTo( "#responsecode2" );
                $("#responsecode2").append(html);
             },
            failure: function(html) {
                document.getElementById("responsecode").innerHTML = 'error';
                console.log(html);
            }        
       });
         event.preventDefault();
      }
    });
    
});

