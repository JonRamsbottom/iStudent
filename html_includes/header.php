<header>
		<div id="head-container">
			<a id="is-logo" href="/" title="iStudent"></a>
			<ul>
				<li><a class="head-tab" href="/search-student">Search<br />Students</a></li>
				<li><a class="head-tab" href="/search-education">Search<br />Education Providers</a></li>
				<li><a class="head-tab" href="/search-home-stay">Search<br />Homestay Families</a></li>
			</ul> <!-- head tabs-->
			<div class="main-search">
				<form action="" type="">
					<button></button><input type="text" placeholder="Search By Keyword" />
				</form>
			</div>
            <?php 
			if(!empty($_SESSION['uid']) && $_SESSION['type'] == 1): ?>
            <?php
			$Wall = new Wall();?>
				<div id="head-right">
				<a href="/student/messages"><p>0</p></a>
				<a href="/student/requests"><p class="friend-top friend-request-span" ></p></a>
				<form>
				<label for="headnavigation" style="background: url('/config/timthumb.php?src=<?php echo $user->profilepicture($_SESSION['uid']); ?>&w=30&h=30&q=90'); background-size: 30px 30px;"></label>
				<div id="head-nav">
                <nav>
				<select name="headnavigation">
						<option value=""></option>
						<option value="/student/home" >My Profile</option>
						<option value="/student/dashboard" >My Dashboard</option>
						<option value="/student/account" >Account Settings</option>
						<option value="/student/privacy" >Privacy Settings</option>
						<option value="/contact" >Contact Us</option>
						<option value="/help" >Help</option>
						<option value="/logoff" class="border" >Sign out</option>
					</select></nav>
				</div>
				</form>
			</div>
            <script>
			
$("nav select").change(function() {
  window.location = $(this).find("option:selected").val();
});
$(document).ready(function() {
setInterval(getfriends,8000);
getfriends();
function getfriends(){
    $.get("/friend_request.php?show=true&studentid="+'<?php echo $_SESSION['uid']; ?>', function (data) {
        $(".friend-request-span").html(data);
    });
	
	  
    
}
});
</script>
            
             <?php endif; ?>
             <?php if(empty($_SESSION['uid']) && $page!="login") {echo "<a href='/login'><button class='logbtn' style='width:140px'><b>Log In</b></button></a>";} ?>
		</div><!-- head container-->
	</header>