<?php 
header("Access-Control-Allow-Origin: *");

// This file will be used for php 7 or more


//get the HTTP method, path and body of the request
Class myaccessdata{
	
	private $keys_array; // array of keys of request data
	private $db ; // db connection object for mongodb
	
	
		  public function isValidTimeStamp($strTimestamp) {
			  
			return ((string) (int) $strTimestamp === $strTimestamp) 
				&& ($strTimestamp <= PHP_INT_MAX)
				&& ($strTimestamp >= ~PHP_INT_MAX);
		}

			public function __construct() {

					$this->keys_array = array('ID','Title','Score','Timestamp'); // initialize array with keys (post should be only witht he keys defined in this array)
					
					$this->db= new MongoDB\Driver\Manager("mongodb://localhost:27017"); // make connection to mongodb
			}

			// Function to run when we hit the api
			public function score($data,$args){
									
				// IF there is POST request					
				if($_SERVER['REQUEST_METHOD']=='POST'){
					
					$bulk = new MongoDB\Driver\BulkWrite; // Inserting operation cursor of mongodb
				
					$flag=0; // flag for checking the validation of data
				
				if(array_diff_key(array_flip($this->keys_array), $data)){ // checking for the keys in post request
					$flag=1;
					
				}
				
				if($flag==0){ // If keys are valid
					
					if(is_int($data['ID']) && is_string ($data['Title']) && is_float($data['Score']) && !$this->isValidTimeStamp($data['Timestamp'])   ){ // check for the validation of the values in the post request
						
						try {
							
							$bulk->insert($data); // insert the data
							$this->db->executeBulkWrite('scores.info', $bulk);  // database and document name 
							$arr['message'] = 'Data inserted successfully';
							$arr['error'] = 0;
							
						}
						catch(MongoDB\Driver\Exception\Exception $e) { // catching if there is an exception
						$arr['message'] = "There was some error in data insertion";
						$arr['error'] = 1;
						}
					
					}
				else{ // If values are not valid
					$arr['message'] = "There is some problem in values";
					$arr['error'] = 1;
				}
				}
				else{ // If the keys are not same as in the array_keys array above
					$arr['message'] ="Data not in proper format";
					$arr['error'] = 0;
					
				}
				// send response back with json encoded
				echo json_encode($arr);

				}

				elseif($_SERVER['REQUEST_METHOD']=='GET'){ // IF there is GET request	
				
					if($args[0]=='score' && count($args)==1) // check if there is simple GET request without the ID
					{
					
					 $query = new MongoDB\Driver\Query([]);  // Query object for mongodb
					  $rows =$this->db->executeQuery("scores.info", $query); // get the data from mongodb
					  $i=0;
					  $array = array();
						foreach ($rows as $row) { // make array in this loop of all recorrds
							$array[$i]['ID'] = $row->ID;
							$array[$i]['Title'] = $row->Title;
							$array[$i]['Score'] = $row->Score;
							$array[$i]['Timestamp'] = $row->Timestamp;
							
							$i++;
						}
						// json encode the array returned
						echo json_encode($array);
				
						
					}
					elseif(count($args)==2){ // if there is an id passed after the api url
						
						
						$filter = [ 'ID' => intval($args[1]) ]; // for getting the specified row
						
						$query = new MongoDB\Driver\Query($filter);      // defining the query with the filter array
    
						$res = $this->db->executeQuery("scores.info", $query); // executing the query
						
						$scores = current($res->toArray()); // getting the results in the array
						$arr =array();
						
						if(!empty($scores)){
							// Adding the returned result form the array
							$arr['ID'] =$scores->ID;
							$arr['Title'] =$scores->Title;
							$arr['Score'] =$scores->Score;
							$arr['TimeStamp'] =$scores->Timestamp;
							
						}
						else{
							// For no results found
							$arr[] = 'No record found';
							
						}
						// sending response back json encoded
						echo json_encode($arr);
						
						
											
					}
					 
				}
			}

}
$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input') , true);
$using_classes = new myaccessdata();
$switching_data = $request[0]; 


switch ($switching_data)
{

case "score":
$using_classes->score($input,$request);
break;

default:
http_response_code(404);
}



?>