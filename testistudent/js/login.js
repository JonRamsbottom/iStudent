$(document).ready(function()
{
		
$("#username").change(function() 
{ 

var username = $("#username").val();
var msgbox = $("#status");

if(username.length >= 3)
{
$("#status").html('Checking availability...');

$.ajax({  
    type: "POST",  
    url: "check_username.php",  
    data: "username="+ username,  
    success: function(msg){  
   
   $("#status").ajaxComplete(function(event, request, settings){ 
   
   var d = msg;
var str=msg.substr(0, 2);

    $("#status").html("");
	if(str == 'OK')
	{ 
	    $("#username").removeClass("no");
	    $("#username").addClass("yes");
       // msgbox.html(' <font color="Green"> Available </font>  ');
	}  
	else  
	{  
	     $("#username").removeClass("yes");
		 $("#username").addClass("no");
		msgbox.html(msg);
	}  
   
   });
   } 
   
  }); 

}
else
{
 $("#username").addClass("no");
$("#status").html('<font color="#cc0000">Enter valid User Name</font>');
}



return false;
});

$("#email").change(function() 
{ 

var email = $("#email").val();
var msgbox = $("#estatus");

if(email.length >= 3)
{
$("#estatus").html('Checking availability...');

$.ajax({  
    type: "POST",  
    url: "check_email.php",  
    data: "email="+ email,  
    success: function(msg){  
   
   $("#estatus").ajaxComplete(function(event, request, settings){ 
   
   var d = msg;
var str=msg.substr(0, 2);

    $("#estatus").html('');
	if(str == 'OK')
	{ 
	    $("#email").removeClass("no");
	    $("#email").addClass("yes");
        //msgbox.html('<font color="Green"> Ok </font>  ');
	}  
	else  
	{  
	     $("#email").removeClass("yes");
	     $("#email").addClass("no");
	     msgbox.html(msg);
	}  
   
   });
   } 
   
  }); 

}
else
{
 $("#email").addClass("no");
$("#estatus").html('<font color="#cc0000">Enter valid email</font>');
}



return false;
});



$.validator.addMethod("email", function(value, element) {  
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);  
    }, "Give valid email address.");
     
	 $.validator.addMethod("username",function(value,element){
    return this.optional(element) || /^[a-zA-Z0-9_-]{3,16}$/i.test(value);  
    },"Username are 3-15 characters no spaces");


    $.validator.addMethod("password",function(value,element){
    return this.optional(element) || /^[A-Za-z0-9!@#$%^&*()_]{6,16}$/i.test(value);  
    },"Passwords are 6-16 characters");


    
        // Validate signup form
        $("#signup").validate({
                rules: {
                        email: "required email",
			username: "required username",
                        password: "required password",

                },
				

        });
		
		

});