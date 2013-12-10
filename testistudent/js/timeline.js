$(function(){
function Arrow_Points()
{ 
var s = $('#container').find('.item');
$.each(s,function(i,obj){
var posLeft = $(obj).css("left");
$(obj).addClass('borderclass');
if(posLeft == "0px")
{
html = "<span class='rightCorner'></span>";
$(obj).prepend(html);			
}
else
{
html = "<span class='leftCorner'></span>";
$(obj).prepend(html);
}
});
}



$('.timeline_container').mousemove(function(e)
{
var topdiv=$("#containertop").height();
var pag= e.pageY - topdiv-26;
$('.plus').css({"top":pag +"px", "background":"url('images/plus.png')","margin-left":"1px"});}).
mouseout(function()
{
$('.plus').css({"background":"url('')"});
});
	
	
				
$("#update_button").live('click',function()
{


var updateval = $("#update").val();

var dataString = 'update='+ updateval;
if($.trim(updateval).length==0)
{
alert("Please Enter Some Text");
}
else
{
$.ajax({
type: "POST",
url: "timeline_message_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#container").prepend(html);

//Reload masonry
$('#container').masonry( 'reload' );

$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();

$("#update").val('');
$("#popup").hide();


}
});
$("#preview").html();
$('#imageupload').slideUp('fast');
}
return false;





});

// Divs
$('#container').masonry({
	
 	singleMode: false,
	        itemSelector: '.item',
	        animate: true
	    });
Arrow_Points();
  
//Mouseup textarea false
$("#popup").mouseup(function() 
{
return false
});
  
$(".timeline_container").click(function(e)
{
var topdiv=$("#containertop").height();
$("#popup").css({'top':(e.pageY-topdiv-33)+'px'});
$("#popup").fadeIn();
$("#update").focus();

	
});  


$(".deletebox").live('click',function()
{

	var ID = $(this).attr("id");
	var dataString = 'msg_id='+ ID;

	if(confirm("Sure you want to delete this update? There is NO undo!"))
	{

	$.ajax({
	type: "POST",
	url: "message_delete_ajax.php",
	data: dataString,
	cache: false,
	success: function(html){
	$("#item"+ID).fadeOut(300,function(){$(this).parent().remove();});  
	//Remove item
	$('#container').masonry( 'remove',$("#item"+ID) );
	
	
	 }
	 });
	}
	
return false;
});


$(".stcommentdelete").live('click',function()
{

	var ID = $(this).attr("id");
	var dataString = 'com_id='+ ID;

	if(confirm("Sure you want to delete this comment? There is NO undo!"))
	{

	$.ajax({
	type: "POST",
	url: "comment_delete_ajax.php",
	data: dataString,
	cache: false,
	success: function(html){
	$("#stcommentbody"+ID).fadeOut(300,function(){$("#stcommentbody"+ID).remove();}); 
	
		 }
	 });
	}
	
return false;
});



//Textarea without editing.
$(document).mouseup(function()
{
$('#popup').hide();

});

// View all comments
$(".view_comments").live("click",function()  
{
var ID = $(this).attr("id");
var V = $(this).attr("vi");


$.ajax({
type: "POST",
url: "comments_view_ajax.php",
data: "msg_id="+ ID, 
cache: false,
success: function(html){
$("#commentload"+ID).html(html);
//----
var b=$("#item"+ID);
var a=b.height();
b.animate({height: a}, 
function(){
$('#container').masonry();
$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();
});
//---

}
});
return false;
});

function more_results()
{

var ID = $('.more:last').attr("id");
if(ID)
{
$.ajax({
type: "POST",
url: "messages_more_ajax_timeline.php",
data: "lastid="+ ID, 
cache: false,
beforeSend: function(){ $("#more"+ID).html('<img src="wall_icons/ajaxloader.gif" />'); },
success: function(html){

var $boxes = $(html);
$('#container').append( $boxes ).masonry( 'appended', $boxes );
Arrow_Points();
$("#more"+ID).remove();
}
});
}
else
{
$("#more").html('The End');// no results
}

//return false;
};


$(window).scroll(function(){
if ($(window).scrollTop() == $(document).height() - $(window).height()){
more_results();
}
});


// commentopen 
$('.commentopen').live("click",function() 
{
var ID = $(this).attr("id");
$("#commentbox"+ID).slideToggle('fast');

var b=$("#item"+ID);
var a=b.height();
if($("#commentbox"+ID).height() > 1)
{
var Z=a-65;	
	
}
else
{
var Z=a+65;		
	
}



b.animate({height: Z }, 
function(){
$('#container').masonry();
$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();
});

return false;
});


//Commment Submit

$('.comment_button').live("click",function() 
{

var ID = $(this).attr("id");

var comment= $("#ctextarea"+ID).val();
var dataString = 'comment='+ comment + '&msg_id=' + ID;

if($.trim(comment).length==0)
{
alert("Please Enter Comment Text");
}
else
{
$.ajax({
type: "POST",
url: "comment_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
//----
var b=$("#item"+ID);
var a=b.height();

b.animate({height: a+60}, function()
{
$('#container').masonry();
$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();
});
//----

$("#commentload"+ID).append(html);
$("#ctextarea"+ID).val('');
$("#ctextarea"+ID).focus();


 }
 });
}
return false;
});

  
});