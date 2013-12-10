<div id="right">
			
			<ul id="profile-icons">
				<a href="/student/my-followers"><li><p>Followers<span ><?php echo $Wall->FollowerCount($uid); ?></span></p></li></a>
				<a href="/student/requests"><li><p>Friend Requests</span><span class="friend-request-span"><?php echo $Wall->FriendRequestCount($uid); ?></span></p></li></a>
				<a href="/student/messages"><li><p>Messages</span><span >0</span></p></li></a>
				<a href="/student/dashboard"><li><p>Unique Views</span><span ><?php echo $Wall->ViewCount($uid, ""); ?></span></p></li></a>
			</ul>
						
			<div id="right-baner">
				<img src="/img/advert_top.png" />
				<div></div>
			</div>
				
		</div><!-- right side-->