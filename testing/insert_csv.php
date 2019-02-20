<?php
ini_set("display_errors", 1);

$csv_file = "north.csv";

$handle= fopen($csv_file,"r");
        $data= array();
        $line=0;
        while (($row = fgetcsv( $handle, 0, ",")) !== FALSE) {
                if($line==0){
                        $data["header"] = $row;
                } else {
                        $tmp = array();
                        foreach($data["header"] as $col => $heading) {
                                $tmp[$heading] = $row[$col];
                        }
                        $data["data"][] = $tmp;
                        unset($tmp);
                }
                $line++;
        }
        fclose($handle);

        echo "<pre>";
        //print_r($data); die;
        
        //die;
        

$servername = "localhost";
$username = "db";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO easyday_stores (code,name,city,latitude,longitude)
VALUES ";
$sql_temp = "";
foreach($data['data'] as $csv){
    $sql_temp.="<br>";
    $sql_temp.="('".$csv['code']."','".$csv['name']."','".$csv['city']."','".$csv['latitude']."','".$csv['longitude']."'),";
}

$sql_temp = rtrim($sql_temp, ",");
echo $sql.$sql_temp; die;


if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();