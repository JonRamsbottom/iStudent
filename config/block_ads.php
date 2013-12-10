<?php
$exec = mysqli_query($dbc, "SELECT * FROM ads ORDER BY RAND() LIMIT 3;");
while($row=mysqli_fetch_array($exec)){
	$title = $row['title'];
	$id = $row['id'];
	$link = $row['link'];
	$text = $row['text'];
	echo <<<END
	<div class="advert-block border">
				<a href="/advertisements?id=$id" class="blue">$title</a><br />
				<a href="/advertisements?id=$id" class="green">$link</a>
				<p>$text</p>
			</div>

END;
}

?>