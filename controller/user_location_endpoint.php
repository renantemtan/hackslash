<?php 
    include('../model/Classes/ConnectDb.php');
    $connection = new ConnectDb();
    $con = $connection->dbConnection();
    $list_of_users = mysqli_query($con, "SELECT * FROM users WHERE id = 2");
    $user_details = mysqli_fetch_assoc($list_of_users);
    // $users = [];
    // foreach( $list_of_users as $user){
    //     array_push($users, $user);
    // }


    echo json_encode($user_details);

?>