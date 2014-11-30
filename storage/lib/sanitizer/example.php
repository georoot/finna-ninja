<?php
include "sanitizer.php";
$s = new sanitizer(array( "p", "br", "a" ),array( "align", "style" ),array( "background" ));
$html = <<<ABC
	<html>
		<p>this is a para</p>
				<br><br>
					<a href = "#" align=left>fdkj</a>


ABC;
print $s -> get($html);
