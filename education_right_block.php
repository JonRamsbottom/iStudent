<div id="right">
			
			<div id="profile-nav">
				<a href="/search-education" id="nav-search" class="navtip"><b><</b><span>Search</span></a>
			</div><!-- end profile navigation-->
			
			<div class="r-box border">
				<span class="rbtitle">Students From This Institute</span>
					<?php
					$faces = $educlass->usergrid($eid, 16);
					 while($data=mysqli_fetch_array($faces)){
					  $fname = $data['firstname'];
					  $lname = $data['lastname'];
					  $sid = $data['dataid'];
					  $profile1 = $user->profilepicture($sid);
                      echo <<<END
<a href='/profile/$sid'><img src='/config/timthumb.php?src=$profile1&w=30&h=30&q=100' title="$fname $lname"></a>
END;
				  }
				  ?>
				
								  <div style="clear:both"></div>

			</div>
			
			<div class="r-box border">
				<span class="rbtitle">Nationality Mix</span>
				
				<div><div class="stat-div"><span style="width: 20%;"></span></div><span class="rb-country">India 20%</span></div>
				<div><div class="stat-div"><span style="width: 17%;"></span></div><span class="rb-country">China 17%</span></div>
				<div><div class="stat-div"><span style="width: 16%;"></span></div><span class="rb-country">Spain 16%</span></div>
				<div><div class="stat-div"><span style="width: 14%;"></span></div><span class="rb-country">Germany 14%</span></div>
				<div><div class="stat-div"><span style="width: 10%;"></span></div><span class="rb-country">Russia 10%</span></div>
				<div><div class="stat-div"><span style="width: 8%;"></span></div><span class="rb-country">Korea 8%</span></div>
				
				
			</div>
				
			
			<div id="right-baner" class="border">
				<img src="/img/advert_top.png" />
				<div></div>
			</div>
				
		</div><!-- right side-->