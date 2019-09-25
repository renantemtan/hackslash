<?php
	include('../model/Classes/ConnectDb.php');

    function parseToXML($htmlStr){
        $xmlStr=str_replace('<','&lt;',$htmlStr);
        $xmlStr=str_replace('>','&gt;',$xmlStr);
        $xmlStr=str_replace('"','&quot;',$xmlStr);
        $xmlStr=str_replace("'",'&#39;',$xmlStr);
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
        return $xmlStr;
    }

    $connection = new ConnectDb();
    $con = $connection->dbConnection();
    $list_of_users = mysqli_query($con, "SELECT * FROM users WHERE is_active = 'Yes'");


    header("Content-type: text/xml");

    // Start XML file, echo parent node
    echo "<?xml version='1.0' ?>";
    echo '<markers>';
    $ind=0;
    // Iterate through the rows, printing XML nodes for each
    while ($row = mysqli_fetch_assoc($list_of_users)){
        // Add to XML document node
        echo '<marker ';
        echo 'id="' . $row['id'] . '" ';
        echo 'name="' . parseToXML($row['name']) . '" ';
        echo 'lat="' . $row['latitude'] . '" ';
        echo 'lng="' . $row['longitude'] . '" ';
        echo 'dstn="' . $row['destination'] . '" ';
        echo 'type="' . $row['type'] . '" ';
        echo '/>';
        $ind = $ind + 1;
    }

    // End XML file
    echo '</markers>';
?>