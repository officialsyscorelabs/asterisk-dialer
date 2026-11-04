 function reloadStats(username){    
        var dataString = 'username='+username;

        document.getElementById("responsecode").innerHTML = '';

        if((username.length < 5)){
            document.getElementById("responsecode").innerHTML = 'Invalid Input';
            return;
        }else{

        //alert(newpath);
        $.ajax({
            type: "POST",
            url: "append.php",
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
                $(this).parent().replaceWith(html);
                //$(this).parent().remove();

             },
            failure: function(html) {
                document.getElementById("responsecode").innerHTML = 'error';
                console.log(html);
            }        
       });
         event.preventDefault();
      }
    
}

