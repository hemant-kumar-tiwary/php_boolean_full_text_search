<?php

/**
 * This function is used to return array in a string format.
*/

 function convertAsString($data = NULL){
	$str = implode(" ", $data);
	return $str;
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
	//sample data 
	//$str = "AND AND PHP AND MYSQl OR  JAVA and go AND linux NOT python NOt and Or";
	
    $boolean_string = $operator = $temp = "";
	$str_array = $temp_stack = array();
	
	if(empty($str)) 
		return $boolean_string; 
	
	$str = strtolower($str);
	$str_array = explode(" ", $str);
	$str_array = array_values(array_filter($str_array));
		
	do{
		$temp = array_pop($str_array); 
		switch($temp){
			case 'and':
					setOperator($temp_stack, $operator, $temp);
					break;
			case 'or':
					setOperator($temp_stack, $operator, $temp);
					break;
			case 'not':
					setOperator($temp_stack, $operator, $temp);
					break;
			default:
				updateStack($temp_stack, $operator);
				array_push($temp_stack,  $temp);
		}
	}while(!empty($str_array));
				
	if($operator == 'and')
		updateStack($temp_stack, $operator);
	
	$temp_stack = array_reverse($temp_stack);
	$boolean_string = convertAsString($temp_stack);
	return $boolean_string;
}
