<?php
################################ Second Task Read Csv File################################


$filename = 'delete.csv'; // Input  path of the csv file, currently it is in same folder

$sum = parsecsv($filename); // call the parsecsv() function with the filename
echo "Sum: ".$sum;  // display the sum 




function parsecsv($filename){

$sum=0; // Initialize the sum with 0 value


$the_big_array = []; // Initalize an array to store contents of the csv

//Open the file for reading
if (($h = fopen("{$filename}", "r")) !== FALSE) // read the csv
{
 //Each line in the file is converted into an individual array that we call $data
 //The items of the array are comma separated
 while (($data = fgetcsv($h, 1000, ",")) !== FALSE) // iterate over the csv rows one by one
 {
     
     if(count($data)!=3){ // If the row count is not equal to 3 then brak the loop 
         
        
         break;
     }
	 
	  $the_big_array[] = $data; // push the content of each row in the array 
 }

 //Close the file
 fclose($h);
}

/* echo "<pre>";

print_r($the_big_array);
echo "</pre>"; */


//Display the code in a readable format
for($i=0;$i<count($the_big_array);$i++){
    
// check for the columns for the validations (first column value pattern(e'g ERF-67) and second column for valid unix time stamp )
        if (!preg_match("#^([A-Z]{3,5})(-)([0-9]+)$#", $the_big_array[$i][0]) || !isValidTimeStamp($the_big_array[$i][1]) ) {
            continue;
        }
        
        if(preg_match("([+-]?\d+(?:\.\d+)?)",$the_big_array[$i][2])){
            $sum = $sum + $the_big_array[$i][2]; // add the third column to the sum variable
        }
        
        
        
    
    }
    
    return  $sum; // return the sum of the third columns value
    
    }
    
    
############## Function to check ValidTimeStamp ################################
    
    function isValidTimeStamp($strTimestamp) {
    return ((string) (int) $strTimestamp === $strTimestamp) 
        && ($strTimestamp <= PHP_INT_MAX)
        && ($strTimestamp >= ~PHP_INT_MAX);
}


    
############## Function to check ValidTimeStamp ################################


    
    
################################ Second Task Read Csv File Ends################################

?>