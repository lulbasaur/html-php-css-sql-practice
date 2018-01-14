<!DOCTYPE html>
<html>
 <head>
   <title>Simple PHP Calculator</title>
   <link rel="stylesheet" type="text/css" href= "calcCSS22.css">

 </head>
 <body>
   <?php

     function isNumber($num){
    if ($num == '/'){
	return false;
    }
    else if ($num == '*'){
	return false;
    }
    else if ($num == '+'){
	return false;
    }
    else if ($num == '-'){
	return false;
    }
    else if ($num == '(' || $num == ')'){
	return false;
    }
    else{
	return true;
    }
     }

 

function isOp($num){
    if ($num == '/'){
	return true;
    }
    else if ($num == '*'){
	return true;
    }
    else if ($num == '+'){
	return true;
    }
    else if ($num == '-'){
	return true;
    }
    else if ($num == '(' || $num == ')'){
	return false;
    }
    else{
	return false;
    }
}


function operation($op1,$op2,$oper){
    if ($oper == '/'){
	return floatval($op1) / floatval($op2);
    }
    else if ($oper == '*'){
	return floatval($op1) * floatval($op2);
    }
    else if ($oper == '+'){
	return floatval($op1) + floatval($op2);
    }
    else if ($oper == '-'){
	return floatval($op1) - floatval($op2);
    }
    else{
	return 1337; //should not happen
    }
}

     

     
function getNextNumber($numString,$index){

    $returnNumber = "";
    $minusCount = 0;
    
    for($i = $index; $i < strlen($numString); $i++){

	if (isNumber($numString[$i]) == false){
	    
	    if ($numString[$i] == '-' && $index == 0 && $minusCount < 1) {
		$returnNumber = $returnNumber."-";
		$minusCount++;
	    }
	    
	    else if($numString[$i] == '-' && isNumber($numString[$i+1]) && $minusCount < 1){
		$returnNumber = $returnNumber.substr($numString,$i,$i+1);
		$minusCount++;
	    }
	    
	    else{
		break;
	    }
	}
	else if(isNumber($numString[$i]) && isNumber($numString[$i+1]) == false){
	    $returnNumber  = $returnNumber.$numString[$i];
	    break;
	}
	else if(isNumber($numString[$i]) && isNumber(numString[$i+1]) == true){
	    $returnNumber  = $returnNumber.$numString[$i];
	}
	
    }
    return $returnNumber;
}



function getNextExpression($numString,$index){
    $expression = "";
    
    for($i = $index; $i < strlen($numString); $i++) {
	if($numString[$i] == ')'){
	    return $expression;
	}
	else{
	    $expression = $expression.$numString[$i];
	}
    }
}



function arrayAddSub($array){
    $result = '0';
    $len = count($array);	  
    for($i = 0; $i < $len; $i++) {
	if($i == 0 && isNumber($array[$i])){
	    $result = operation($result,$array[$i],'+');
	}
	else if (isNumber($array[$i])) {
	    $result = operation($result,$array[$i],$array[$i-1]);
	}
	else if ($i == $len-1){
	    $result = operation($result,$array[$i],$array[$i-1]);
	}
    }
    
    return $result;
}


function traverseCalc($input){
    $expressionList = array();
    $nextNum = "";
    $nextOp = "";
    //parse to array
    $exp = "";
    for($i = 0; $i < strlen($input); $i++) {
	if ($input[$i] == ')') {
	    if ($i != strlen($input)-1 && (isNumber($input[$i+1]) || $input[$i+1] == '(')){
		$expressionList[] = '*';
	    }
	}
	else if ($input[$i] == '(') {
	    if ($i != 0){
		if (isNumber($input[$i-1])) {
		     $expressionList[] = '*';
		}
		$exp = getNextExpression($input,$i+1);		
		$expressionList[] = traverseCalc($exp);
		$i = $i + strlen($exp);		
	    }
	    else{
		$exp = getNextExpression($input,$i+1);
		$expressionList[] = traverseCalc($exp);
		$i = $i + strlen($exp);		
	    }
	}
	else{
	    $nextNum = getNextNumber($input,$i);
    	    if($nextNum != ""){
		$expressionList[] = $nextNum;
		$i = $i + strlen($nextNum);
	    }
	    if ($i < strlen($input)-1) {
		$nextOp = $input[$i];
		if (isOp($nextOp)) {
    		    $expressionList[] = $nextOp;
		}
	    }
	}
    }



    
    //end parse    
    $additionSubtraction = array();
    $current = '0';
    for($i = 0; $i < count($expressionList); $i++) {
	if ($expressionList[$i] == ')') {
	    break;
	}
	else if (isOp($expressionList[$i])) {
	    
	    if($expressionList[$i] == '+' || $expressionList[$i] == '-'){

		if ($current != 0) {
		    $additionSubtraction[] = (string) $current;		    
		}

		$current = 0;
		if ($i == count($expressionList)-2) {

		    if ($expressionList[$i-1] != null) {
			$additionSubtraction[] = $expressionList[$i-1];
		    }
		    $additionSubtraction[] = $expressionList[$i];
		    $additionSubtraction[] = $expressionList[$i+1];

		}
		else if($expressionList[$i-1] != null){
		    $additionSubtraction[] = $expressionList[$i-1];
		    $additionSubtraction[] = $expressionList[$i];
		    
		}
		else{
		    $additionSubtraction[] = $expressionList[$i];
		    		    
		}
		
	    }
	    else if($expressionList[$i] == '*' || $expressionList[$i] == '/'){
		if ($i == count($expressionList) - 2) {
		    if ($expressionList[$i-1] != null) {
			$current = operation($expressionList[$i-1],$expressionList[$i+1],$expressionList[$i]);
		    }
		    else{
			$current = operation($current,$expressionList[$i+1],$expressionList[$i]);
		    }
		    $additionSubtraction[] = $current;
		}
		else if($expressionList[$i-1] != null){
		    
		    $current = operation($expressionList[$i-1],$expressionList[$i+1],$expressionList[$i]);
		    $expressionList[$i-1] = null;
		    $expressionList[$i+1] = null;

		}
		else if ($expressionList[$i-1] == null) {
		    $current = operation($current,$expressionList[$i+1],$expressionList[$i]);
		    $expressionList[$i+1] = null;
		}
	    }
	}
	
    }

    $current = arrayAddSub($additionSubtraction);	
    return $current;
}

     
 /*    $isNumber = isNumber(1);
     echo "isNumber: ".$isNumber." ";
     $isOPtest = isOP('/');
     echo "isOPtest: ".$isOPtest." ";
     $operationtest = operation("4.4","2.2",'/');
     echo "operationtest: ".$operationtest." ";
     $getNextNumbertest = getNextNumber("4.4+1",0);
     echo "getNextNumbertest: ".$getNextNumbertest." ";
     $getNextExpressiontest = getNextExpression("4.4+1)",0);
     echo "getNextExpressiontest: ".$getNextExpressiontest." ";
     $array = array("12", "+", "13");
     $arrayAddSubtest = arrayAddSub($array);
     echo "arrayAddSubtest: ".$arrayAddSubtest." ";
     $traverseCalctest = traverseCalc("3+4-1");
     echo "traverseCalctest: ".$traverseCalctest." ";
*/


	$result =0;
	if (isset($_POST['='])) {
        $result = traverseCalc($_POST['screen']);
	}
		     

?>

		         <form action="" name="calculator" method="post" >
      <table summary="" align="center">
	<tr>
          <td colspan="2"><input type="text" name="screen" size="20"></td>
    	  <td colspan="2"><input type="text" name="result" size="20" value="<?php echo htmlspecialchars($result); ?>"></td>
	</tr>
	<tr>
    	  <td><input type="button" class="operator" name="." value="." onclick="calculator.screen.value += '.' "></td>

          <td><input type="button" class="operator" name="par1" value="(" onclick="calculator.screen.value += '(' "></td>
	  <td><input type="button" class="operator" name="par2" value=")" onclick="calculator.screen.value += ')' "></td>
	  <td><input type="button" class="operator" name="back" value="delete" onclick="calculator.screen.value = calculator.screen.value.substring(0,calculator.screen.value.length-1) "></td>

	</tr>
	<tr>
	  <td><input type="button" class="number"   name="7" value="7" onclick="calculator.screen.value += '7' "></td>
	  <td><input type="button" class="number"   name="8" value="8" onclick="calculator.screen.value += '8' "></td>
	  <td><input type="button" class="number"   name="9" value="9" onclick="calculator.screen.value += '9' "></td>
	  <td><input type="button" class="operator" name="/" value="/" onclick="calculator.screen.value += '/' "></td>
	</tr>
	<tr>
	  <td><input type="button" class="number"   name="4"  value="4" onclick="calculator.screen.value += '4' "></td>
	  <td><input type="button" class="number"   name="5"  value="5" onclick="calculator.screen.value += '5' "></td>
	  <td><input type="button" class="number"   name="6"  value="6" onclick="calculator.screen.value += '6' "></td>
	  <td><input type="button" class="operator" name="+"  value="+" onclick="calculator.screen.value += '+' "></td>

	</tr>
	<tr>
	  <td><input type="button" class="number"   name="1"  value="1" onclick="calculator.screen.value += '1' "></td>
	  <td><input type="button" class="number"   name="2"  value="2" onclick="calculator.screen.value += '2' "></td>
	  <td><input type="button" class="number"   name="3"  value="3" onclick="calculator.screen.value += '3' "></td>
	  <td><input type="button" class="operator" name="-"  value="-" onclick="calculator.screen.value += '-' "></td>
	</tr>
	<tr>
    <td><input type="button" class="number"   name="0" value="0" onclick="calculator.screen.value += '0' "></td>
        <td><input type="button" class="w3-btn" id="clear" name="C" value="C" onclick="calculator.screen.value = ''"></td>
	  <td><input type="submit" class="equals"   id="equals" name="=" value="=" ></td>
	  <td><input type="button" class="operator" name="X" value="X" onclick="calculator.screen.value += '*' "></td>
	</tr>
      </table>
			 </form>


 </body>
</html>
