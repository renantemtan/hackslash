<?php  
	include('../model/Classes/ConnectDb.php');
	include('../model/Classes/CrudUser.php');
	$crud = new CrudUser();

	if(isset($_POST['edit_user_form'])) {
		$crud->editSpecificUser($_POST['id'], $_POST['f_name'], $_POST['l_name'], $_POST['gender'], $_POST['reward_db']);
	}


	if(isset($_POST['add_user_form'])) {
		// echo $_POST['gender'];
		$crud->addUser($_POST['f_name'], $_POST['l_name'], $_POST['gender'], $_POST['reward']);
	}

	if(isset($_POST['del_user_form'])) {
		$crud->delSpecificUser($_POST['id_del']);
	}

	if(isset($_POST['add_point_form'])) {
		$date_time_now = date("Y-m-d H:i:s");
		$num_to_be_added = $_POST['add_this_num'] + $_POST['reward_db'];
		$crud->addRewardPoints($_POST['id_del'], $num_to_be_added);
		$crud->addHistory($_POST['id_del'], $_POST['username'],  $_POST['add_this_num'] , 0, $date_time_now);
	}

	if(isset($_POST['dd_point_form'])) {
		$date_time_now = date("Y-m-d H:i:s");
		$num_to_be_dd = $_POST['reward_db'] - $_POST['dd_this_num'] ;
		$crud->ddRewardPoints($_POST['id_del'], $num_to_be_dd);
		$crud->deductHistory($_POST['id_del'], $_POST['username'], 0, $_POST['dd_this_num'] , $date_time_now);
	}


	
	header('location: ../views/user.php');


?>