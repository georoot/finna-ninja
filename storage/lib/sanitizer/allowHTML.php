<?php

/**
 * @package allowHTML
 * @version 1.0.0
 * @author Simon Emery
 * @copyright (c) 2010 allowHTML
 * @link http://allowhtml.com
 * @license http://allowhtml.com/download/license
 * @depends http://www.owasp.org/index.php/Category:OWASP_AntiSamy_Project
**/


//php5 check
if(version_compare(PHP_VERSION, '5.0.0', '<')) {
    echo 'Your web server must be running php5 in order to use allowHTML. Please contact your web host regarding php5.';
    die();
}


//core class
class allowHTML {

	//charset to use when processing input
	protected $charset;

	//attempts to remove any invalid characters
	protected $check_charset = true;

	//convert non-ascii characters to html number entities
	protected $convert_entities = false;

	//path to policy file (relative to allowHTML file)
	protected $policy_file = 'xml/antisamy.xml';

	//list of html tags to allow, along with attribute lists for individual tags
	protected $allowed_tags = array( 'div', 'p', 'span', 'br', 'ul', 'ol', 'li', 'a[href|title|target]', 'img[src|alt|title|width|height]', 'font[size|face|color]', 'b', 'strong', 'i', 'em', 'u', 's', 'strike', 'blockquote', 'cite', 'caption', 'code', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'table', 'tr', 'td', 'th', 'thead', 'tbody', 'tfoot' );

	//list of attributes to allow globally (use * to allow all)
	protected $allowed_attr = array( 'align', 'class', 'style' );

	//list of properties to allow in css styling (use * to allow all)
	protected $allowed_css = array( '*' );

	//list of uri schemes to allow
	protected $allowed_schemes = array( 'http', 'https', 'ftp', 'ftps', 'mailto' );

	//list of unsafe strings (an additional check, after the real work has been done)
	protected $unsafe_text = array( ':alert', 'behavior:', 'behaviour:', 'content:', 'data:', ':expression', 'include-source:', 'mocha:', 'moz-binding:', 'script:' );

	//constructor
	public function __construct(array $options=array()) {
		//set options
		foreach($options as $key=>$val) {
			if(property_exists($this, $key)) {
				$this->$key = $val;
			}
		}
		//internal options
		$this->valid = true;
		$this->html = false;
		$this->fragment = false;
		$this->mbstring = (bool) extension_loaded('mbstring');
		//build whitelist
		$this->build_whitelist();
	}

	//read-only properties
	public function __get($key) {
		//list of read-only properties
		$allowed = array( 'charset', 'allowed_tags', 'allowed_attr', 'allowed_css' );
		//check requested property
		if(in_array($key, $allowed)) {
			return $this->$key;
		}
	}

	//validate
	public function validate($input) {
		//run through sanitizer
		$this->sanitize($input);
		//valid result?
		return (bool) $this->valid;
	}

	//sanitize
	public function sanitize($input) {
		//format input
		if(!$input = $this->format_input($input)) {
			return '';
		}
		//create node
		$node = new DOMDocument('1.0', $this->charset);
		//load html
		@$node->loadHTML($input);
		//strip attributes
		$this->strip_attr($node);
		//save html
		$input = $node->saveXML($node->documentElement);
		//strip tags
		$input = $this->strip_tags($input);
		//return
		return $this->format_output($input);
	}

	//build whitelist
	protected function build_whitelist() {
		//set vars
		$format = true;
		//check attributes
		foreach($this->allowed_attr as $attr) {
			if(is_array($attr)) {
				$format = false;
				break;
			}
		}
		//set global attributes
		if(!isset($this->allowed_attr['*'])) {
			if($format) {
				$this->allowed_attr = array( '*' => array_values($this->allowed_attr) );
			} else {
				$this->allowed_attr['*'] = array();
			}
		}
		//format tags / attributes
		foreach($this->allowed_tags as $tag) {
			//set tag
			$exp = array_map('trim', explode("[", $tag));
			$tags[] = $tag = $exp[0];
			//set attributes?
			if(isset($exp[1]) && $exp[1][strlen($exp[1])-1] == "]") {
				$a = trim($exp[1], "]");
				$this->allowed_attr[$tag] = array_map('trim', explode("|", $a));
			}
		}
		//update allowed tags
		$this->allowed_tags = $tags;
	}

	//format input
	protected function format_input($input) {
		//trim input
		$input = trim($input);
		//anything to process?
		if(!$input) return '';
		//get charset?
		if(!$this->charset) {
			$encoding = $this->mbstring ? mb_detect_encoding($input) : "UTF-8";
			$encoding = $encoding == "ASCII" ? "UTF-8" : $encoding;
			$this->charset = $encoding ? $encoding : "UTF-8";
		}
		//encode entities?
		if($this->mbstring) {
			$input = mb_convert_encoding($input, "HTML-ENTITIES", "UTF-8");
		}
		//remove invalid characters?
		if($this->check_charset && function_exists('iconv')) {
			$input = @iconv($this->charset, $this->charset . "//IGNORE", $input);
		}
		//add doctype
		if(stripos($input, "</html>") === false || !in_array('html', $this->allowed_tags)) {
			$this->fragment = true;
			$input = preg_replace(array('/<\?xml.*?\?>/i', '/<\!DOCTYPE.*?>/i', '/<html.*?>/i', '/<\/html>/i', '/<head>.*?<\/head>/i', '/<body.*?>/i', '/<\/body>/i'), '', $input);
			$input = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=' . strtolower($this->charset) . '" /></head><body>' . $input . '</body></html>';
		} else {
			$this->fragment = false;
			$input = preg_replace(array('/<\?xml.*?\?>/i', '/<\!DOCTYPE.*?>/i'), '', $input);
			$input = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . $input;
		}
		//return
		return $input;
	}

	//format output
	protected function format_output($input) {
		//remove double encoding
		$rand = mt_rand(100000,999999);
		$input = str_replace(array("&amp; ", "&amp;", "%[" . $rand . "]%", "&#13;"), array("%[" . $rand . "]%", "&", "&amp; ", ""), $input);
		//add doctype?
		if(!$this->fragment) {
			$input = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . $input;
		}
		//remove empty tags
		$input = preg_replace('/<\w+[^br|hr$] \/>/U', '', $input);
		//return
		return trim($input);
	}

	//strip tags
	protected function strip_tags($input) {
		//fragment?
		if($this->fragment) {
			$input = preg_replace(array('/<\?xml.*?\?>/i', '/<\!DOCTYPE.*?>/i', '/<html.*?>/i', '/<\/html>/i', '/<head>.*?<\/head>/i', '/<body.*?>/i', '/<\/body>/i'), '', $input);
		}
		//tag list
		$tags = "<" . implode("><", $this->allowed_tags) . ">";
		//strip tags
		$output = strip_tags($input, $tags);
		//valid html?
		if($output !== $input) {
			$this->valid = false;
		}
		//return
		return trim($output);
	}

	//strip attributes
	protected function strip_attr($node, $level=0) {
		//set vars
		static $remove_nodes = array();
		//valid node?
		if(!$node->hasChildNodes()) {
			return;
		}
		//set node
		$node = $node->firstChild;
		//process
		do {
			//any html submitted?
			if(!$this->html && $node->nodeType == XML_ELEMENT_NODE) {
				if(isset($node->parentNode->tagName) && $node->parentNode->tagName == "body") {
					$this->html = true;
				}
			}
			//list of tags to remove completely (including all children)
			if($node->nodeType == XML_ELEMENT_NODE && in_array($node->tagName, array( 'script', 'style' ))) {
				if(!in_array($node->tagName, $this->allowed_tags)) {
					//mark for removal
					$remove_nodes[] = $node;
					//invalid
					$this->valid = false;
				}
			}
			//clean text
			if($node->nodeType == XML_TEXT_NODE) {
				$node->nodeValue = $this->clean_text($node->nodeValue);
			}
			//look for element with attributes and on the whitelist
			if($node->hasAttributes() && in_array($node->tagName, $this->allowed_tags)) {
				//set vars
				$remove = array();
				//loop through node list
				foreach($node->attributes as $attr) {
					//check attribute whitelist
					if(in_array('*', $this->allowed_attr['*']) || in_array($attr->name, $this->allowed_attr['*'])) {
						//global
						$allowed = true;
					} elseif(isset($this->allowed_attr[$node->tagName]) && in_array($attr->name, $this->allowed_attr[$node->tagName])) {
						//local
						$allowed = true;
					} else {
						//none
						$allowed = false;
					}
					//clean attribute value
					$clean = $allowed ? $this->clean_attr($node->tagName, $attr->name, $attr->value) : false;
					//value valid?
					if($clean !== false) {
						//update attribute
						$node->setAttribute($attr->name, $clean);
					} else {
						//mark for removal
						$remove[] = $attr->name;
						//invalid
						$this->valid = false;
					}
				}
				//remove attributes
				foreach($remove as $attr) {
					$node->removeAttribute($attr);
				}
				//add alt attribute?
				if($node->tagName == "img" && !$node->hasAttribute('alt')) {
					if($node->hasAttribute('src')) {
						$node->setAttribute('alt', "");
					}
				}
			}
			//next level
			$this->strip_attr($node, $level+1);
			//next sibling
		} while($node = $node->nextSibling);
		//remove nodes
		if($level == 0) {
			foreach($remove_nodes as $node) {
				$node->parentNode->removeChild($node);
			}
		}
	}

	//clean attribute
	protected function clean_attr($tag, $name, $value) {
		//check attribute name is valid
		if(!preg_match('/^[a-z0-9\-\_\.\:]+$/iD', $name)) {
			return false;
		}
		//remove excess space
		if(!$value = preg_replace('/\s+/', ' ', $value)) {
			return '';
		}
		//style attribute
		if($name == "style") {
			//validate css
			if(!$value = $this->clean_css($tag, $value)) {
				return false;
			}
		}
		//anything else
		if($name != "style") {
			//validate attribute
			if(!$value = $this->apply_rules($tag, 'attribute', $name, $value)) {
				return false;
			}
		}
		//just in case...
		$value_ns = str_replace(array('\\', '%20', ' '), '', $value);
		//loop through blacklist
		foreach($this->unsafe_text as $unsafe) {
			//check whether string exists
			if(stripos($value_ns, trim($unsafe, ':')) !== false) {
				return false;
			}
		}
		//encode special characters
		return htmlspecialchars(trim($value), ENT_QUOTES, $this->charset, false);
	}

	//clean css
	protected function clean_css($tag, $input) {
		//set vars
		$output = "";
		$properties = array();
		//format input
		$input = preg_replace('/\s+/', ' ', $input);
		$input = preg_replace('/\s+[^\s]+\:/', ';$0', $input);
		$input = str_replace(array(';;', ':;', '; url', '!important'), array(';', ':', ' url', ''), $input);
		//search for comments
		if(strpos($input, "/*") !== false || strpos($input, "*/") !== false) {
			return false;
		}
		//explode into sections
		$sections = explode(";", strtolower($input));
		//loop through sections
		foreach($sections as $s) {
			//anything to process?
			if(strpos($s, ":") === false) {
				continue;
			}
			//extract name and value
			list($name, $value) = array_map('trim', explode(":", trim($s), 2));
			//duplicate check
			if(isset($properties[$name])) {
				continue;
			}
			//property name, whitelist check
			if(!in_array('*', $this->allowed_css) && !in_array($name, $this->allowed_css)) {
				continue;
			}
			//property name, character check
			if(!preg_match('/^[a-z0-9\-\_]+$/iD', $name)) {
				continue;
			}
			//property value, rule check
			if(!$value = $this->apply_rules($tag, 'property', $name, $value)) {
				continue;
			}
			//add to output
			$output .= $name . ":" . $value . "; ";
			//property used
			$properties[$name] = true;
		}
		//return
		return trim($output);
	}

	//clean text
	protected function clean_text($input) {
		//strip tags
		$input = strip_tags($input);
		//remove unsafe text
		foreach($this->unsafe_text as $unsafe) {
			$unsafe = trim(str_replace(":", "(\s+)?\:(\s+)?", $unsafe), '/');
			$input = preg_replace('/' . $unsafe . '/i', '', $input);
		}
		//encode entities?
		if($this->mbstring && $this->convert_entities) {
			$input = mb_convert_encoding($input, "HTML-ENTITIES", "UTF-8");
		}
		//encode special characters
		return htmlspecialchars($input, ENT_QUOTES, $this->charset, false);
	}

	//apply rules
	protected function apply_rules($tag, $type, $name, $value) {
		//check for url
		if($type == 'property' && preg_match("/url\((.*)\)/", $value, $matches)) {
			$url = $matches[1];
		} elseif($type == 'attribute' && in_array($name, array('action', 'codebase', 'dynsrc', 'href', 'lowsrc', 'src', 'xmlns'))) {
			$url = $value;
		}
		//url handler
		if(isset($url)) {
			//inpsect url
			if(!$url = $this->inspect_url($url, true)) {
				return false;
			}
			//update property?
			if(isset($matches[1])) {
				//escape url characters
				$list = array( "(" => "\(", ")" => "\)", "'" => "\'", "," => "\," );
				$url = str_replace('\\\\', '\\', strtr($url, $list));
				$url = str_replace('%5c\\', '\\', $url);
			}
			//url checks passed
			return (isset($matches[1]) ? "url('" . $url . "')" : $url);
		}
		//find rules
		if(!$rules = $this->find_rules($tag, $type, $name)) {
			return false;
		}
		//loop through rules
		foreach($rules as $rule) {
			foreach($rule as $key=>$val) {
				//literal match found?
				if($val == "literal" && $key === (string) $value) {
					return $value;
				}
				//regex match found?
				if($val == "regex" && preg_match('/^' . str_replace('/', '\/', $key) . '$/uD', $value)) {
					return $value;
				}
			}
		}
		//no match
		return false;
	}

	//find rules (using anti-samy)
	protected function find_rules($tag, $type, $name) {
		//set vars
		$rules = array();
		$hash = $type == 'attribute' ? ($tag . "_" . $name) : $name;
		//static vars
		static $xml = null;
		static $rule_cache = array();
		static $regex_cache = array();
		//check rule cache
		if(isset($rule_cache[$type][$hash])) {
			return $rule_cache[$type][$hash];
		} else {
			$rule_cache[$type][$hash] = array();
		}
		//xpath routes
		$routes = array(
			'attribute' => "tag-rules/tag[@name='" . $tag . "']/attribute",
			'attribute-common' => "common-attributes/attribute",
			'property' => "css-rules/property",
		);
		//valid route?
		if(!isset($routes[$type])) {
			return false;
		}
		//create xml object
		if(!$xml && !$xml = @simplexml_load_file(str_replace('\\', '/', dirname(__FILE__)) . "/" . $this->policy_file)) {
			throw new Exception("Unable to load policy file - " . $this->policy_file);
		}
		//literal rule matches
		if(!$results = $xml->xpath("//" . $routes[$type] . "[@name='" . $name . "']/literal-list/literal")) {
			if($type == 'attribute') {
				$results = $xml->xpath("//" . $routes['attribute-common'] . "[@name='" . $name . "']/literal-list/literal");
			}
		}
		//continue?
		if($results) {
			//loop through results
			foreach($results as $row) {
				//get attributes
				$attr = (array) $row->attributes();
				//update cache
				$rule_cache[$type][$hash][] = array( $attr['@attributes']['value'] => "literal" );
			}
		}
		//regex rule matches
		if(!$results = $xml->xpath("//" . $routes[$type] . "[@name='" . $name . "']/regexp-list/regexp")) {
			if($type == 'attribute') {
				$results = $xml->xpath("//" . $routes['attribute-common'] . "[@name='" . $name . "']/regexp-list/regexp");
			}
		}
		//continue?
		if($results) {
			//loop through results
			foreach($results as $row) {
				//set regex name
				$regex = array();
				$regex_name = (string) $row['name'];
				//extract regex pattern
				if(empty($regex_name)) {
					//regex in key
					$attr = (array) $row->attributes();
					$rule_cache[$type][$hash][] = array( $attr['@attributes']['value'] => "regex" );
				} elseif(isset($regex_cache[$regex_name])) {
					//regex cached
					$rule_cache[$type][$hash] = array_merge($rule_cache[$type][$hash], $regex_cache[$regex_name]);
				} elseif($results2 = $xml->xpath("//common-regexps/regexp[@name='" . $regex_name . "']")) {
					//xpath query
					foreach($results2 as $row2) {
						$attr = (array) $row2->attributes();
						$regex[] = array( $attr['@attributes']['value'] => "regex" );
					}
					//update cache
					$regex_cache[$regex_name] = $regex;
					$rule_cache[$type][$hash] = array_merge($rule_cache[$type][$hash], $regex);
				}
			}
		}
		//shorthand rule matches
		if($type == 'property' && $results = $xml->xpath("//" . $routes[$type] . "[@name='" . $name . "']/shorthand-list/shorthand")) {
			//loop through results
			foreach($results as $row) {
				//get attributes
				$attr = (array) $row->attributes();
				//add shorthand results to cache
				if($shorthand = $this->find_rules($tag, $type, $attr['@attributes']['name'])) {
					$rule_cache[$type][$hash] = array_merge($rule_cache[$type][$hash], $shorthand);
				}
			}
		}
		//all done
		return $rule_cache[$type][$hash];
	}

	//inspect url
	protected function inspect_url($input, $relative=false) {
		//remove surrounding ' characters?
		if(substr($input, 0, 1) == "'" && substr($input, -1) == "'") {
			$input = substr($input, 1, -1);
		}
		//check for unwanted characters
		if(substr($input, 0, 2) == "//" || strpos($input, '"') !== false) {
			return false;
		}
		//encode url characters
		$list = array( " " => "%20", "%" => "%25", "\\" => "%5c", "^" => "%5e", "|" => "%7c", "`" => "%60", "[" => "%5b", "]" => "%5d", "{" => "%7b", "}" => "%7d" );
		$input = strtr(trim($input), $list);
		//parse url
		$parse = @parse_url($input);
		//valid parsed array?
		if(!$parse || !is_array($parse)) {
			return false;
		}
		//allow relative url?
		if($relative && !isset($parse['scheme']) && !isset($parse['host'])) {
			//add dummy scheme / host
			$parse['scheme'] = "http";
			$parse['host'] = "relative.com";
			//path required still
			if(!isset($parse['path'])) {
				return false;
			}
		}
		//scheme: allow http, https, ftp, ftps
		if(!isset($parse['scheme']) || !in_array($parse['scheme'], $this->allowed_schemes)) {
			return false;
		}
		//scheme: should only appear once
		if($exp = explode("?", $input)) {
			if(preg_match_all('/' . $parse['scheme'] . ':\/\//', $exp[0], $matches)) {
				//multiple matches?
				if(count($matches[0]) > 1) {
					return false;
				}
			}
		}
		//no host for mailto
		if($parse['scheme'] != "mailto" || isset($parse['host'])) {
			//domain: allow letters, numbers and - . characters
			if(!isset($parse['host']) || !preg_match('/^[a-z0-9\x2d\x2e]+$/iD', $parse['host'])) {
				return false;
			}
			//domain: check for proper use of . characters
			if(strpos($parse['host'], "..") !== false || trim($parse['host'], ".") != $parse['host'] || strpos($parse['host'], ".") === false) {
				return false;
			}
			//domain: check for proper use of - characters
			if(trim($parse['host'], "-") != $parse['host']) {
				return false;
			}
			//domain: check for other encodings
			if(!preg_match('/[^0-9]/', str_replace(array("x", "."), "", $parse['host']))) {
				return false;
			}
		}
		//success
		return trim($input);
	}

}


//wrapper function
function allowHTML($input, array $config=array(), $method='sanitize') {
	//create new object
	$allowHTML = new allowHTML($config);
	//process input
	return $allowHTML->$method($input);
}
