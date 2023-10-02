<?php

/** @class: InputFilter (PHP4 & PHP5, with comments)
  * @project: PHP Input Filter
  * @date: 10-05-2005
  * @version: 1.2.2_php8
  * @author: Daniel Morris
  * @contributors: Gianpaolo Racca, Ghislain Picard, Marco Wandschneider, Chris Tobin and Andrew Eddie.
  * @copyright: Daniel Morris
  * @email: dan@rootcube.com
  * @license: GNU General Public License (GPL)
  */

class InputFilter {

	private $tagsArray;	
	private $attrArray;
	private $tagsMethod;
	private $attrMethod;
	private $xssAuto;
	private $tagBlacklist = array('applet', 'body', 'bgsound', 'base', 'basefont', 'embed', 'frame', 'frameset', 'head', 'html', 'id', 'iframe', 'ilayer', 'layer', 'link', 'meta', 'name', 'object', 'script', 'style', 'title', 'xml');
	private $attrBlacklist = array('action', 'background', 'codebase', 'dynsrc', 'lowsrc');
	public function __construct($tagsArray = array(), $attrArray = array(), $tagsMethod = 0, $attrMethod = 0, $xssAuto = 1) {		
		
        for ($i = 0; $i < count($tagsArray); $i++) $tagsArray[$i] = strtolower($tagsArray[$i]);
		for ($i = 0; $i < count($attrArray); $i++) $attrArray[$i] = strtolower($attrArray[$i]);
		$this->tagsArray = $tagsArray;
		$this->attrArray = $attrArray;
		$this->tagsMethod = $tagsMethod;
		$this->attrMethod = $attrMethod;
		$this->xssAuto = $xssAuto;
	}

	public function Process($source) {
		if (is_array($source))	 {
			for ($i = 0; $i < count($source); $i++)
				if (is_string($source[$i])) $source[$i] = $this->remove($this->decode($source[$i]));
			return $source;
		} else if (is_string($source)) return $this->remove($this->decode($source));							
		else return $source;	
	}

	private function remove($source) {
		$loopCounter=0;
		while($source != $this->filterTags($source)) {
			$source = $this->filterTags($source);
			$loopCounter++;
		}
		return $source;
	}	

	private function filterTags($source) {
		$preTag = NULL;
		$postTag = $source;
		$tagOpen_start = strpos($source, '<');
		while($tagOpen_start !== FALSE) {
			$preTag .= substr($postTag, 0, $tagOpen_start);
			$postTag = substr($postTag, $tagOpen_start);
			$fromTagOpen = substr($postTag, 1);
			$tagOpen_end = strpos($fromTagOpen, '>');
			if ($tagOpen_end === false) {
				break;
			}
			$tagOpen_nested = strpos($fromTagOpen, '<');
			if (($tagOpen_nested !== false) && ($tagOpen_nested < $tagOpen_end)) {
				$preTag .= substr($postTag, 0, ($tagOpen_nested+1));
				$postTag = substr($postTag, ($tagOpen_nested+1));
				$tagOpen_start = strpos($postTag, '<');
				continue;
			} 
			$tagOpen_nested = (strpos($fromTagOpen, '<') + $tagOpen_start + 1);
			$currentTag = substr($fromTagOpen, 0, $tagOpen_end);
			$tagLength = strlen($currentTag);
			if (!$tagOpen_end) {
				$preTag .= $postTag;
				$tagOpen_start = strpos($postTag, '<');			
			}
			$tagLeft = $currentTag;
			$attrSet = array();
			$currentSpace = strpos($tagLeft, ' ');
			if (substr($currentTag, 0, 1) == "/") {
				$isCloseTag = TRUE;
				list($tagName) = explode(' ', $currentTag);
				$tagName = substr($tagName, 1);
			} else {
				$isCloseTag = FALSE;
				list($tagName) = explode(' ', $currentTag);
			}		
			if ((!preg_match('/'."^[a-z]*$".'/i',$tagName)) || (!$tagName) || ((in_array(strtolower($tagName), $this->tagBlacklist)) && ($this->xssAuto))) {
				$postTag = substr($postTag, ($tagLength + 2));
				$tagOpen_start = strpos($postTag, '<');
				continue;
			}
			while ($currentSpace !== FALSE) {
				$fromSpace = substr($tagLeft, ($currentSpace+1));
				$nextSpace = strpos($fromSpace, ' ');
				$openQuotes = strpos($fromSpace, '"');
				$closeQuotes = strpos(substr($fromSpace, ($openQuotes+1)), '"') + $openQuotes + 1;
				if (strpos($fromSpace, '=') !== FALSE) {
					if (($openQuotes !== FALSE) && (strpos(substr($fromSpace, ($openQuotes+1)), '"') !== FALSE))
						$attr = substr($fromSpace, 0, ($closeQuotes+1));
					else $attr = substr($fromSpace, 0, $nextSpace);
				} else $attr = substr($fromSpace, 0, $nextSpace);
				if (!$attr) $attr = $fromSpace;
				$attrSet[] = $attr;
				$tagLeft = substr($fromSpace, strlen($attr));
				$currentSpace = strpos($tagLeft, ' ');
			}
			$tagFound = in_array(strtolower($tagName), $this->tagsArray);			
			if ((!$tagFound && $this->tagsMethod) || ($tagFound && !$this->tagsMethod)) {
				if (!$isCloseTag) {
					$attrSet = $this->filterAttr($attrSet);
					$preTag .= '<' . $tagName;
					for ($i = 0; $i < count($attrSet); $i++)
						$preTag .= ' ' . $attrSet[$i];
					if (strpos($fromTagOpen, "</" . $tagName))	$preTag .= '>';
					else																$preTag .= ' />';
			    } else $preTag .= '</' . $tagName . '>';
			}
			$postTag = substr($postTag, ($tagLength + 2));
			$tagOpen_start = strpos($postTag, '<');			
		}
		$preTag .= $postTag;
		return $preTag;
	}

	private function filterAttr($attrSet) {	
		$newSet = array();
		for ($i = 0; $i <count($attrSet); $i++) {
			if (!$attrSet[$i]) continue;
			$attrSubSet = explode('=', $attrSet[$i]);
			list($attrSubSet[0]) = explode(' ', $attrSubSet[0]);
			if ((!preg_match("/^[a-z]*$/",$attrSubSet[0])) || (($this->xssAuto) && ((in_array(strtolower($attrSubSet[0]), $this->attrBlacklist)) || (substr($attrSubSet[0], 0, 2) == 'on')))) 
				continue;
			if ($attrSubSet[1]) {
				$attrSubSet[1] = str_replace('&#', '', $attrSubSet[1]);
				$attrSubSet[1] = preg_replace('/\s+/', '', $attrSubSet[1]);
				$attrSubSet[1] = str_replace('"', '', $attrSubSet[1]);
				$attrSubSet[1] = stripslashes($attrSubSet[1]);
			}
			if (	((strpos(strtolower($attrSubSet[1]), 'expression') !== false) && (strtolower($attrSubSet[0]) == 'style')) ||
					(strpos(strtolower($attrSubSet[1]), 'javascript:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'behaviour:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'vbscript:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'mocha:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'livescript:') !== false) 
			) continue;
			$attrFound = in_array(strtolower($attrSubSet[0]), $this->attrArray);
			if ((!$attrFound && $this->attrMethod) || ($attrFound && !$this->attrMethod)) {
				if ($attrSubSet[1]) $newSet[] = $attrSubSet[0] . '="' . $attrSubSet[1] . '"';
				else $newSet[] = $attrSubSet[0] . '="' . $attrSubSet[0] . '"';
			}	
		}
		return $newSet;
	}

	private function decode($source) {
		$source = html_entity_decode($source, ENT_QUOTES, "ISO-8859-1");
		$source = preg_replace_callback(
			'/&#(\d+);/mi',
			function ($m) {return chr(hexdec($m[1]));},
			$source
		);
		$source = preg_replace_callback(
			'/&#x([a-f0-9]+);/mi',
			function ($m) { return chr(hexdec('0x'.$m[1])); }, // Now a Closure
			$source
		);
		return $source;
	}
}

?>
