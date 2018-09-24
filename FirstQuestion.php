<?php

################################ First Task Fibonacci number validation#########################


// Function to input the number , it will check whether number is fibonacci or not
function isFibonacci($n){
    $dRes1 = sqrt((5*pow($n, 2))-4);    // get sqrt of (5* number square)-4
    $nRes1 = (int)$dRes1;                // get integer value of the above line
    $dDecPoint1 = $dRes1 - $nRes1; ;  // subtract the two values above
    $dRes2 = sqrt((5*pow($n, 2))+4); // get sqrt of (5* number square)+4
    $nRes2 = (int)$dRes2;              // get integer value of the above line
    $dDecPoint2 = $dRes2 - $nRes2;   // subtract the two values above
    if( !$dDecPoint1 || !$dDecPoint2 ) // check for the two results after subtration
    {
    return true;    // Number is Fibonacci number
    }
    else
    {

    return false; // Number is not a Fibonacci number
    } 
}

$number =  5 ;                  // Input number to check
$check = isFibonacci($number);  //  call the function with input number
if($check){
    echo $number." provided argument was valid";
}
else{
    echo $number." provided argument was not valid";
}
echo "<br>";

################################ First Task Fibonacci number validation#########################

 
	 ?>