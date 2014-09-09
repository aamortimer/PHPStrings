<?php
	class String {
		static function clean_sql($sql){
		  return str_replace("'", "''", $sql);
		}
		
		static function camelize($lowerCaseAndUnderscoredWord) {
			$replace = str_replace(" ", "", ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord)));
			return $replace;
		}
		
		static function underscore($camelCasedWord) {
			$replace = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
			return $replace;
		}
		
		static function humanize($lowerCaseAndUnderscoredWord) {
			$lowerCaseAndUnderscoredWord = str_replace("-", "_", $lowerCaseAndUnderscoredWord);
			$replace = ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord));
			return $replace;
		}	
		
		static function variable($string) {
			$string = String::camelize(String::underscore($string));
			$replace = strtolower(substr($string, 0, 1));
			$variable = preg_replace('/\\w/', $replace, $string, 1);
			return $variable;
		}	
		
		static function safe_url($str, $hyphens = true){
			//accent chars
			$search = array('à','â','ä','è','ê','ë','é','ì','î','ï','ò','ô','ö','ù','û','ü',"'");
			$replace = array('a','a','a','e','e','e','e','i','i','i','o','o','o','u','u','u','');
				
			$str = str_replace($search, $replace, $str);
			$str = preg_replace('/&/', 'and', $str);
			$str = preg_replace('/\./', '', $str);
			$str = str_replace(array('(',')'),'',$str);
			$str = preg_replace('/[^\[\]0-9a-z-\']/i', '-', $str);
			$str = preg_replace('/-{2,}/', '-', $str);
			$str = preg_replace('/-*$/', '', $str);
			$str = html_entity_decode($str);
			
			if(!$hyphens){
			  $str = str_replace('-', '_', $str);
			}
			
			return strToLower($str);
		}			
		
		static function snippet($text, $length=64, $tail="...") {
	    $text = trim($text);
	    $txtl = strlen($text);
	    if($txtl > $length) {
	        for($i=1;$text[$length-$i]!=" ";$i++) {
	            if($i == $length) {
	                return substr($text,0,$length) . $tail;
	            }
	        }
	        $text = substr($text,0,$length-$i+1) . $tail;
	    }
	    return $text;
		}
		
		static function sentence_case($string) {
	    $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
	    $new_string = '';
	    foreach ($sentences as $key => $sentence) {
	        $new_string .= ($key & 1) == 0?
	            ucfirst(strtolower(trim($sentence))) :
	            $sentence.' ';
	    }
	    return trim($new_string);
		} 
	}
?>
