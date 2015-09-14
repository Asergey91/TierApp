<?php
//functions that are indented require parent functions
////////////////LEVEL 1/////////////////////
//send query to mysql function returns true false or an array with results
function Query($sql){
	//credentials
	$username="";
	$password="";
	$server="";
	$db="";
	//connect
	$conn = mysqli_connect($server, $username, $password, $db);
	//check connection
	if (!$conn) {
		die("Error:".mysqli_connect_error());
	}
	//send query
	$result = mysqli_query($conn, $sql);
	//error handling
	if (!$result) {
		echo "Error:".mysqli_error($conn);
	}
	//close connection
	mysqli_close($conn);
	//convert result to array
	if (!is_bool($result)){
		$result=mysqli_fetch_array($result, MYSQLI_NUM);
	}
	return $result;	
}
//returns a name string based on charnum
function GetName($charnum){
	if (is_numeric($charnum)){
		switch ($charnum){
		case 0:
			return "Chel";
			break;
		case 1:
			return "Crow";
			break;
		case 2:
			return "Dauntless";
			break;
		case 3:
			return "Edge";
			break;
		case 4:
			return "Talos";
			break;
		case 5:
			return "Vlad";
			break;
		default:
			echo "Error: bad input into GetName()";
			break;
		}
	}
	else {
		echo "Error: bad input into GetName()";
	}
}
////////////////LEVEL 2/////////////////////
	//utility db functions
	function DropTable(){
		Query("
			DROP TABLE tierapptable
		");
	}
	function Install(){
		Query("
			CREATE TABLE tierapptable (
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				matchuptable LONGTEXT NOT NULL
			)
		");
		for ($rows=0; $rows<6; $rows++){
			for ($columns=0; $columns<6; $columns++){
				$matchuptable[$rows.$columns][0]=5;
				$matchuptable[$rows.$columns][1]=5;
			}
		}
		$matchuptable=json_encode($matchuptable);
		Query("
			INSERT INTO tierapptable (
				matchuptable
			)
			VALUES (
				'".$matchuptable."'
			)
		");
	}
	function RetrieveMatchupTable(){
		$matchuptable=Query("
			SELECT matchuptable FROM tierapptable WHERE id = '1'
		");
		return json_decode($matchuptable[0], true);
	}
////////////////LEVEL 3/////////////////////
		function CountVotes(){
			$matchuptable=RetrieveMatchupTable();
			$count=0;
			for ($rows=0; $rows<6; $rows++){
				$count=$count+count($matchuptable[$rows."0"]);
			}
			echo $count;
		}
		function AJAXRetrieveMatchupTableAndAverage(){
			$matchuptable=RetrieveMatchupTable();
			for ($rows=0; $rows<6; $rows++){
				for ($columns=0; $columns<6; $columns++){
					$count=count($matchuptable[$rows.$columns]);
					$sum=0;
					for ($cells=0; $cells<$count; $cells++){
						$sum=$sum+$matchuptable[$rows.$columns][$cells];
					}
					$matchuptable[$rows.$columns]=number_format($sum/$count, 2);
				}
			}
			for ($rows=0; $rows<6; $rows++){
				for ($columns=0; $columns<6; $columns++){
					$sum=$matchuptable[$rows.$columns]+$matchuptable[$columns.$rows];
					$matchuptable[$rows.$columns]=number_format(($matchuptable[$rows.$columns]/$sum*10),2);
					$matchuptable[$columns.$rows]=number_format(($matchuptable[$columns.$rows]/$sum*10),2);
				}
			}
			echo json_encode($matchuptable);
		}
		//needs json array as input
		function UpdateMatchupTable($input){
			//$input=[2, [2, 3, 2, 5, 2, 1]];
			$input=json_decode($input, true);
			//make sure mirrors are 5
			$input[1][$input[0]]=5;
			//push new values
			$matchuptable=RetrieveMatchupTable();
			for ($cell=0; $cell<6; $cell++){
				array_push($matchuptable[$input[0].$cell], $input[1][$cell]);
			}
			$matchuptable=json_encode($matchuptable);
			Query("
			UPDATE tierapptable SET matchuptable='".$matchuptable."' WHERE id = '1'
			");
		}
?>