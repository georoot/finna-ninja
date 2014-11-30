<?php

// /*
// Further examples available at the link below:
// http://allowhtml.com/get-started/
// */


// //load allowhtml
// include_once('../allowHTML.php');

// //raw html
// $raw_html = '<p align="left" style="background:#000; border:1px solid #EEE;">Hello world!</p><script>alert(\'danger!\');</script>';

// //set options
// $options = array(
// 	'allowed_tags' => array( "p", "br", "a" ), //allowing <p><br /><a> html tags only
// 	'allowed_attr'=> array( "align", "style" ), //allowing 'align' and 'style' html arrtibutes only
// 	'allowed_css' => array( "background" ), //allowing 'background' css property only
// );

// //set method
// $method = "sanitize"; //choose between 'sanitize' and 'validate'

// //use class wrapper function
// $safe_html = allowHTML($raw_html, $options, $method);

// //view source
// echo htmlentities($safe_html, ENT_QUOTES, "UTF-8");

print "!23";
