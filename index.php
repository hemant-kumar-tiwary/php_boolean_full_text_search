<?php

/*
Author : Hemant Kr Tiwari
Email : t.hemantkumar@gmail.com
contact : +91-9818664766
licence : GNU General Public License
*/

class GenerateBooleanQueryString{

	public $boolean_string;
	/*
	* default cunstructor to this class
	*/
	function __construct($data) {
		$this->boolean_string = "";
		$this->getStringForBooleanSearch($data);
	}

	
	/**
	 * This function is used to return array in a string format.
	*/

	function convertAsString($data = NULL, $spcialWord= NULL) {
		$str = "";
		if(!empty($spcialWord)){
			foreach($spcialWord as $value)
				$str .= $value;
				$str .= " ";
		}
		$str .= implode(" ", $data);
		return addslashes($str);
	}
	 

	 /**
	 * This function is used to set the operator.
	 */

	function setOperator($temp_stack, &$operator, $temp) {
		$operator = ((count($temp_stack) > 0) ? $temp : "");
	}

	/**
	 * This function is used to update the keyword according to boolean operator.
	 */

	function updateStack(&$temp_stack, $operator) {
		$temp = array_pop($temp_stack);
		if($operator == 'and'){
			$temp = '+'.$temp;	
		} else if($operator == 'not'){
			$temp = '-'.$temp;
		}
		array_push($temp_stack,  $temp);	
	}

	/**
	 * This function is used to generate boolean search string on the basis of AND OR  NOT operator.
	*/
	 
	function getStringForBooleanSearch($str = "") {
		
		$boolean_string = $operator = $temp = "";
		$str_array = $temp_stack = array();
		
		if(empty($str)) 
			return $boolean_string; 
		
		$str = strtolower($str);
		
		$tempStr = explode("\"",$str);
		$replaceWord = array();
		$replaceWith = array();

		for($i=1;$i<=count($tempStr)-1;$i+=2){
			$replaceWord[] = '"'.$tempStr[$i].'"';
			$replaceWith[] = "";
		}
		$str = str_replace($replaceWord, $replaceWith,$str);
		
		
		$str_array = explode(" ", $str);
		$str_array = array_values(array_filter($str_array));
			
		do{
			$temp = array_pop($str_array); 
			switch($temp){
				case 'and':
						$this->setOperator($temp_stack, $operator, $temp);
						break;
				case 'or':
						$this->setOperator($temp_stack, $operator, $temp);
						break;
				case 'not':
						$this->setOperator($temp_stack, $operator, $temp);
						break;
				default:
					$this->updateStack($temp_stack, $operator);
					array_push($temp_stack,  $temp);
			}
		}while(!empty($str_array));
					
		if($operator == 'and')
			$this->updateStack($temp_stack, $operator);
		
		$temp_stack = array_reverse($temp_stack);
		$this->boolean_string = $this->convertAsString($temp_stack, $replaceWord);
	}

}

## String that need to convert it into boolean search string that finally used in query
$data = '"account manager" or python and linux';
$obj  = new GenerateBooleanQueryString($data);
echo $obj->boolean_string;