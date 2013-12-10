// Srinivas Tamada http://9lessons.info
// wall.js

$(document).ready(function() 
{
$.base_url='http://localhost/wall/';
var webcamtotal=6; // Min 2 Max 6 Recommended 
$("a.timeago").livequery(function () { $(this).timeago(); });
$("span.timeago").livequery(function () { $(this).timeago(); });
$(".stcommenttime").livequery(function () { $(this).timeago(); });
// URL Tool Tips	    
$(".stdelete, .small_face, .big_face").livequery(function () { $(this).tipsy({gravity: 's'}); });

$(".stcommentdelete").livequery(function () { $(this).tipsy({gravity: 's'}); });
$("#camera").livequery(function () { $(this).tipsy({gravity: 'n'}); });
$("#webcam_button").livequery(function () { $(this).tipsy({gravity: 'n'}); });


$("textarea").live('mousemove',function(e) {
        var myPos = $(this).offset();
        myPos.bottom = $(this).offset().top + $(this).outerHeight();
        myPos.right = $(this).offset().left + $(this).outerWidth();
        
        if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16) {
            $(this).css({ cursor: "nw-resize" });
        }
        else {
            $(this).css({ cursor: "" });
        }
    })
    //  the following simple make the textbox "Auto-Expand" as it is typed in
    .live('keyup',function(e) {
        //  the following will help the text expand as typing takes place
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });


 
$("#update").focus();

// Update Status
$(".update_button").click(function() 
{
var updateval = $("#update").val();
var uploadvalues=$("#uploadvalues").val();

var X=$('.preview').attr('id');
var Y=$('.webcam_preview').attr('id');
if(X)
{
var Z= X+','+uploadvalues;
}
else if(Y)
{
var Z= uploadvalues;
}
else
{
var Z=0;
}
var dataString = 'update='+ updateval+'&uploads='+Z;
if($.trim(updateval).length==0)
{
alert("Please Enter Some Text");
}
else
{
$("#flash").show();
$("#flash").fadeIn(400).html('Loading Update...');
$.ajax({
type: "POST",
url: "message_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#webcam_container").slideUp('fast');
$("#flash").fadeOut('slow');
$("#content").prepend(html);
$("#update").val('').focus().css("height", "40px");	
$('#preview').html('');
$('#webcam_preview').html('');
$('#uploadvalues').val('');
$('#photoimg').val('');
var c=$('#update_count').html();
$('#update_count').html(parseInt(c)+1);
}
 });
 $("#preview").html();
$('#imageupload').slideUp('fast');
}
return false;
	});

//Share
	$('.share_button').die('click').live("click",function() 
	{
		var sid;
    var KEY = parseInt($(this).attr("data"));
	var ID = $(this).attr("id");

	if(KEY=='1')
	{
	sid=ID.split("shares"); 	
	}
	else
	{
	sid=ID.split("share"); 	
	}
	
	var New_ID=sid[1];
	
	var REL = $(this).attr("rel");
	var URL=$.base_url+'message_share_ajax.php';
	var dataString = 'msg_id=' + New_ID+'&rel='+ REL;
	$.ajax({
	type: "POST",
	url: URL,
	data: dataString,
	cache: false,
	success: function(html){
	if(html)
	{
	if(REL=='Share')
	{
	$('#'+ID).html('Unshare').attr('rel', 'Unshare').attr('title', 'Unshare');
	}
	else
	{
	$('#'+ID).attr('rel', 'Share').attr('title', 'Share').html('Share');
	}
    }

	 }
	 });

	return false;
	});

//Like and Unlike
$('.like_button').die('click').live("click",function() 
{

	var KEY = parseInt($(this).attr("data"));
	var ID = $(this).attr("id");
	if(KEY=='1')
	{
	var sid=ID.split("likes"); 	
	}
	else
	{
	var sid=ID.split("like"); 	
	}


var New_ID=sid[1];
var REL = $(this).attr("rel");
var URL=$.base_url+'message_like_ajax.php';
var dataString = 'msg_id=' + New_ID +'&rel='+ REL;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
if(html)
{
if(REL=='Like')
{
$("#elikes"+New_ID).show('slow').prepend("<span id='you"+New_ID+"'><a href='#'>You</a> like this.</span>");
$("#likes"+New_ID).prepend("<span id='you"+New_ID+"'><a href='#'>You</a>, </span>");
$('#'+ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
}
else
{
$("#elikes"+New_ID).hide('slow');
$("#you"+New_ID).remove();
$('#'+ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
}
}

 }
 });

return false;
});

//Like and Unlike
$('.commentlike').die('click').live("click",function() 
{
var ID = $(this).attr("id");
var sid=ID.split("clike"); 
var New_ID=sid[1];
var REL = $(this).attr("rel");

var URL=$.base_url+'comment_like_ajax.php';
var dataString = 'com_id=' + New_ID +'&rel='+ REL;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){

if(REL=='Like')
{

$('#'+ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
$("#count_container"+New_ID).fadeIn('slow');
$(".comment_count"+New_ID).html(html);

}
else
{
$('#'+ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
if(html>0)
{
$(".comment_count"+New_ID).html(html);	
}
else
{
$("#count_container"+New_ID).fadeOut('slow');	
}

}
 
}
});



return false;
});

	
//Commment Submit

$('.comment_button').die('click').live("click",function() 
{

var ID = $(this).attr("id");
var OID = $(this).attr("rel");
var URL=$.base_url+'comment_ajax.php';
var comment= $("#ctextarea"+ID).val();
var dataString = 'comment='+ comment + '&msg_id=' + OID;

if($.trim(comment).length==0)
{
alert("Please Enter Comment Text");
}
else
{
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
$("#commentload"+ID).append(html);
$("#ctextarea"+ID).val('').css("height", "35px").focus();

 }
 });
}
return false;
});
// commentopen 
$('.commentopen_button').die('click').live("click",function() 
{
var ID = $(this).attr("id");
$("#commentbox"+ID).slideToggle('fast');
$("#ctextarea"+ID).focus();
return false;
});	

// Add button
$('.addbutton').die('click').live('click',function() 
{
var vid = $(this).attr("id");
var sid=vid.split("add"); 
var ID=sid[1];
var dataString = 'fid='+ ID ;

$.ajax({
type: "POST",
url: "friend_add_ajax.php",
data: dataString,
cache: false,
beforeSend: function(){$("#friendstatus").html('<img src="wall_icons/ajaxloader.gif"  />'); },
success: function(html)
{	
if(html)
{
$("#friendstatus").html('');
$("#add"+ID).hide();
$("#remove"+ID).show();
}
}
});
return false;
});

// Remove Friend
$('.removebutton').die('click').live('click',function() 
{

var vid = $(this).attr("id");
var sid=vid.split("remove"); 
var ID=sid[1];
var dataString = 'fid='+ ID ;

$.ajax({
type: "POST",
url: "friend_remove_ajax.php",
data: dataString,
cache: false,
beforeSend: function(){$("#friendstatus").html('<img src="wall_icons/ajaxloader.gif"  />'); },
success: function(html)
{	
if(html)
{
$("#friendstatus").html('');
$("#remove"+ID).hide();
$("#add"+ID).show();
}
}
});
return false;
});


//WebCam 6 clicks
$(".camclick").die('click').live("click",function() 
{
var X=$("#webcam_count").val();
if(X)
var i=X;
else
var i=1;
var j=parseInt(i)+1; 
$("#webcam_count").val(j);

if(j>webcamtotal)
{
$(this).hide();
$("#webcam_count").val(1);
}

});

// delete comment
$('.stcommentdelete').die('click').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'com_id='+ ID;
var URL=$.base_url+'comment_delete_ajax.php';

jConfirm('Sure you want to delete this comment? There is NO undo!', '', 
function(r) 
{
if(r==true)
{

$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
beforeSend: function(){$("#stcommentbody"+ID).animate({'backgroundColor':'#fb6c6c'},300);},
success: function(html){
// $("#stcommentbody"+ID).slideUp('slow');
$("#stcommentbody"+ID).fadeOut(300,function(){$("#stcommentbody"+ID).remove();});
 }
 });

} });
return false;
});


// Camera image
$('#camera').die('click').live("click",function() 
{
$('#webcam_container').slideUp('fast');
$('#imageupload').slideToggle('fast');
return false;
});

//Web Camera image
$('#webcam_button').die('click').live("click",function() 
{
$(".camclick").show();
$('#imageupload').slideUp('fast');
$('#webcam_container').slideToggle('fast');
return false;
});

// Uploading Image

$('#photoimg').die('click').live('change', function()			
{ 
var values=$("#uploadvalues").val();
$("#previeww").html('<img src="wall_icons/loader.gif"/>');
$("#imageform").ajaxForm({target: '#preview', 
     beforeSubmit:function(){ 
	 $("#imageloadstatus").show();
	 $("#imageloadbutton").hide();
	 }, 
	success:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	}, 
	error:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	} }).submit();

var X=$('.preview').attr('id');
var Z= X+','+values;
if(Z!='undefined,')
{
$("#uploadvalues").val(Z);
}

});


// delete update
$('.stdelete').die('click').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;

jConfirm('Sure you want to delete this update? There is NO undo!', '', 
function(r) 
{
if(r==true)
{

$.ajax({
type: "POST",
url: "message_delete_ajax.php",
data: dataString,
cache: false,
beforeSend: function(){ $("#stbody"+ID).animate({'backgroundColor':'#fb6c6c'},300);},
success: function(html){
 //$("#stbody"+ID).slideUp();
 $("#stbody"+ID).fadeOut(300,function(){$("#stbody"+ID).remove();});
var c=$('#update_count').html();
$('#update_count').html(parseInt(c)-1);
 }
 });
	} });
return false;
});
// View all comments
$(".view_comments").die('click').live("click",function()  
{
var ID = $(this).attr("id");
var OID = $(this).attr("rel");
var URL=$.base_url+'comments_view_ajax.php';
$.ajax({
type: "POST",
url: URL,
data: "msg_id="+ OID, 
cache: false,
success: function(html){
$("#commentload"+ID).html(html);
}
});
return false;
});
// Load More


$('.more').die('click').live("click",function() 
{

var ID = $(this).attr("id");
var P_ID = $(this).attr("rel");
var URL=$.base_url+'messages_more_ajax.php';
var dataString = "lastid="+ ID+"&profile_id="+P_ID;
if(ID)
{
$.ajax({
type: "POST",
url: URL,
data: dataString, 
cache: false,
beforeSend: function(){ $("#more"+ID).html('<img src="wall_icons/ajaxloader.gif" />'); },
success: function(html){
$("div#content").append(html);
$("#more"+ID).remove();
}
});
}
else
{
$("#more").html('The End');// no results
}

return false;
});

$("#searchinput").keyup(function() 
{
var searchbox = $(this).val();
var dataString = 'searchword='+ searchbox;

if(searchbox.length>0)
{

$.ajax({
type: "POST",
url: "search_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#display").html(html).show();
}
});
}return false; 
});

$("#display").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$('#display').hide();
$('#searchinput').val("");
});

// Web Cam-----------------------
var pos = 0, ctx = null, saveCB, image = [];
var canvas = document.createElement("canvas");
canvas.setAttribute('width', 320);
canvas.setAttribute('height', 240);
if (canvas.toDataURL) 
{
ctx = canvas.getContext("2d");
image = ctx.getImageData(0, 0, 320, 240);
saveCB = function(data) 
{
var col = data.split(";");
var img = image;
for(var i = 0; i < 320; i++) {
var tmp = parseInt(col[i]);
img.data[pos + 0] = (tmp >> 16) & 0xff;
img.data[pos + 1] = (tmp >> 8) & 0xff;
img.data[pos + 2] = tmp & 0xff;
img.data[pos + 3] = 0xff;
pos+= 4;
}
if (pos >= 4 * 320 * 240)
 {
ctx.putImageData(img, 0, 0);
$.post("webcam_image_ajax.php", {type: "data", image: canvas.toDataURL("image/png")},
function(data)
 {
 
 if($.trim(data) != "false")
{
var dataString = 'webcam='+ 1;
$.ajax({
type: "POST",
url: "webcam_imageload_ajax.php",
data: dataString,
cache: false,
success: function(html){
var values=$("#uploadvalues").val();
$("#webcam_preview").prepend(html);
var X=$('.webcam_preview').attr('id');
var Z= X+','+values;
if(Z!='undefined,')
$("#uploadvalues").val(Z);
 }
 });
 }
 else
{
  $("#webcam").html('<div id="camera_error"><b>Camera Not Found</b><br/>Please turn your camera on or make sure that it <br/>is not in use by another application</div>');
$("#webcam_status").html("<span style='color:#cc0000'>Camera not found please reload this page.</span>");
$("#webcam_takesnap").hide();
	return false;
}
 });
pos = 0;
 }
  else {
saveCB = function(data) {
image.push(data);
pos+= 4 * 320;
 if (pos >= 4 * 320 * 240)
 {
$.post("webcam_image_ajax.php", {type: "pixel", image: image.join('|')},
function(data)
 {
 
var dataString = 'webcam='+ 1;
$.ajax({
type: "POST",
url: "webcam_imageload_ajax.php",
data: dataString,
cache: false,
success: function(html){
var values=$("#uploadvalues").val();
$("#webcam_preview").prepend(html);
var X=$('.webcam_preview').attr('id');
var Z= X+','+values;
if(Z!='undefined,')
$("#uploadvalues").val(Z);
 }
 });
 
 });
 pos = 0;
 }
 };
 }
 };
 } 


$("#webcam").webcam({
width: 320,
height: 240,
mode: "callback",
 swffile: "js/jscam_canvas_only.swf",
onSave: saveCB,
onCapture: function () 
{
webcam.save();
 },
debug: function (type, string) {
 $("#webcam_status").html(type + ": " + string);
}

});
//-------------------
});
 /**
Taking snap
**/
function takeSnap(){
//console.log(webcam.getCameraList());
webcam.capture();
 }
