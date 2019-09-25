<?php  
	include('../model/Classes/ConnectDb.php');
	include('../model/Classes/CrudUser.php');
	$crud = new CrudUser();
?>


<!DOCTYPE html>
<html>
<head>
	<title>HeatMap</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
	<?php
		if($_SERVER['REQUEST_URI']=='/views/heatmap.php'){
			// echo '<div class="wrapper">';
		}else{
			echo '<div class="wrapper">';
		}
	?>