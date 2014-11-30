<?php
include "allowHTML.php";
class sanitizer{
	var $tags;
	var $attr;
	var $css;
	public function __construct($tags,$attr,$css){
		$this -> tags = $tags;
		$this -> attr = $attr;
		$this -> css = $css;
	}

	public function get($html){
		$options = array(
			'allowed_tags' => $this -> tags, //allowing <p><br /><a> html tags only
			'allowed_attr'=> $this -> attr, //allowing 'align' and 'style' html arrtibutes only
			'allowed_css' => $this -> css, //allowing 'background' css property only
		);
		$method = "sanitize";
		return allowHTML($html, $options, $method);;
	}
}
