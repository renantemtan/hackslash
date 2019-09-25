<?php 
	Class CrudUser {
		private $con;
		private $list_of_employees;
		private $points_history;

		public function __construct() {
			$timezone = date_default_timezone_set('Asia/Manila');
			$connection = new ConnectDb();
			$this->con = $connection->dbConnection();
			$this->list_of_employees = mysqli_query($this->con, "SELECT * FROM users ORDER BY user_id DESC");
			$this->points_history = mysqli_query($this->con, "SELECT * FROM points_history ORDER BY points_id DESC");
			// var_dump($this->list_of_employees);
		}

		

		public function delSpecificUser($id) {
			$query = mysqli_query($this->con, "DELETE FROM users WHERE user_id='$id'");
			return;
		}

		public function editSpecificUser($id, $f_name, $l_name, $sex, $reward_u) {
			$query = mysqli_query($this->con, "UPDATE users SET first_name = '$f_name', last_name = '$l_name', sex = '$sex', remaining_points = '$reward_u' WHERE user_id='$id'");
			return;
		}

		public function addUser($f_name, $l_name, $sex, $reward) {
			$query = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$f_name', '$l_name', '$sex', '$reward')");
			return;
		}

		public function addHistory($user_id, $username, $num_added, $num_dd, $date) {
			$query = mysqli_query($this->con, "INSERT INTO points_history VALUES ('', '$user_id', '$username', '$num_added', '$num_dd', 'Recieved', '$date')");
			return;
		}

		public function deductHistory($user_id, $username, $num_added, $num_dd, $date) {
			$query = mysqli_query($this->con, "INSERT INTO points_history VALUES ('', '$user_id', '$username', '$num_added', '$num_dd', 'Deducted', '$date')");
			return;
		}

		public function getModal() {
			foreach($this->list_of_employees as $index => $emp) {
				?>
					<!-- Edit Modal -->
					<div class="modal fade" id="edit_<?php echo $emp['user_id'] ?>_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel" style="color: #b29758">Edit User Details</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form action="../controller/crud_endpoint.php" method="POST">
										<input type="number" hidden name="id" value="<?php echo $emp['user_id'];?>" class="form-control">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1" style="color: #b29758">Reward Points</label>
													<input type="number" name="reward_db" value="<?php echo $emp['remaining_points'];?>" class="form-control">
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1">First name</label>
													<input type="text" name="f_name" value="<?php echo $emp['first_name'];?>" class="form-control">
												</div>
											</div>
										
											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1">Last name</label>
													<input type="text" name="l_name" value="<?php echo $emp['last_name'];?>" class="form-control">
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1">Gender</label>
													<select class="custom-select" name="gender">
														<option value="<?php 
															if($emp['sex']=='Male') {
																echo "Male";
															} else {
																echo "Female";															}
														?>" 
														selected><?php echo $emp['sex'] ?></option>
														<?php 
															if($emp['sex']=='Male'){
																?>
																	<option value="Female">Female</option>

																<?php
															} else {
																?>
																	<option value="Male">Male</option>

																<?php
															}
														?>
													</select>
												</div>
											</div>

											
										</div>

										<div class="modal-footer">
											<button type="submit" name="edit_user_form" class="btn btn-gold">Update</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
										</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>

					<!-- Delete modal -->
					<div class="modal fade" id="del_<?php echo $emp['user_id'] ?>_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel"><img class="add_points mx-2" data-toggle="tooltip" title="Tap to add rewards" data-id="<?php echo $emp['user_id'] ?>" src="../assets/img/icons/brake.png" height="20" width="20" alt="">Deletion</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Are you sure you want to delete this user (<?php echo $emp['first_name'] ?>)? </p>
								</div>
								<div class="modal-footer">
									<form action="../controller/crud_endpoint.php" method="POST">
										<input type="text" name="id_del" value="<?php echo $emp['user_id'] ?>" hidden>
										<button type="submit" name="del_user_form" class="btn btn-gold">Proceed</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Add_user_modal -->
					<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel" style="color: #b29758">Add User</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form action="../controller/crud_endpoint.php" method="POST">
										<input type="number" hidden name="id" value="<?php echo $emp['user_id'];?>" class="form-control">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1" style="color: #b29758">Reward Points</label>
													<input type="number" name="reward" value="" class="form-control">
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1">First name</label>
													<input type="text" name="f_name" value="" class="form-control">
												</div>
											</div>
										
											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1">Last name</label>
													<input type="text" name="l_name" value="" class="form-control">
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group">
													<label for="exampleInputPassword1">Gender</label>
													<select class="custom-select" name="gender" required>
														<option selected></option>
														<option value="Male">Male</option>
														<option value="Female">Female</option>
													</select>
												</div>
											</div>

											
										</div>

										<div class="modal-footer">
											<button type="submit" name="add_user_form" class="btn btn-gold">Add</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
										</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>

					

					<!-- add points -->
					<div class="modal fade" id="add_points_<?php echo $emp['user_id'] ?>_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header text-center">
									<h5 class="modal-title" id="exampleModalLabel" style="color: #b29758">Add Rewards</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body text-center">
									<p>How much would you like to add?</p>
										<form action="../controller/crud_endpoint.php" method="POST">
											<input type="number" class="form-control" name="add_this_num" value="" required>
											<input type="text" class="form-control" name="username" value="<?php echo $emp['first_name'] ?>" hidden>
											<input type="text" name="id_del" value="<?php echo $emp['user_id'] ?>" hidden>
											<input type="number" name="reward_db" value="<?php echo $emp['remaining_points'] ?>" hidden><br>
											<button type="submit" name="add_point_form" class="btn btn-gold">Proceed</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- deduct points -->
					<div class="modal fade" id="dd_points_<?php echo $emp['user_id'] ?>_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header text-center">
									<h5 class="modal-title" id="exampleModalLabel" style="color: #b29758">Reedeem Rewards</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body text-center">
									<p>How much would you like to Reedeem?</p>
										<form action="../controller/crud_endpoint.php" method="POST">
											<input type="number" class="form-control" name="dd_this_num" value="" max="<?php echo $emp['remaining_points'] ?>" required>
											<input type="text" class="form-control" name="username" value="<?php echo $emp['first_name'] ?>" hidden>
											<input type="text" name="id_del" value="<?php echo $emp['user_id'] ?>" hidden>
											<input type="number" name="reward_db" value="<?php echo $emp['remaining_points'] ?>" hidden><br>
											<button type="submit" name="dd_point_form" class="btn btn-gold">Proceed</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
			} 
			return;
		}


		public function getTableUsers() {
			foreach ($this->list_of_employees as $index => $emp) {
				?>
					<tr>
						<td><?php echo ++$index ?></td>
						<td><?php echo $emp['first_name']?></td>
						<td><?php echo $emp['last_name']?></td>
						<td><?php echo $emp['sex'] ?></td>
						<td class="text-center"><?php echo $emp['remaining_points'] ?></td>
						
					</tr>
				<?php 
			}
		}

		public function getTableHistory() {
			foreach ($this->points_history as $index => $emp) {
				?>
					<tr>
						<td><?php echo ++$index ?></td>
						<td><?php echo $emp['username']?></td>
						<td><?php echo $emp['user_id']?></td>
						<td><?php echo $emp['added_points']?></td>
						<td><?php echo $emp['deducted_points'] ?></td>
						<td><?php echo $emp['remarks'] ?></td>
						<td><?php echo $emp['created_at'] ?></td>
						
					</tr>
				<?php 
			}
		}

		public function getEmployeeCard() {
			foreach ($this->list_of_employees as $index => $emp) {
				?>
					
					<div class="col-lg-3">
						<div class="card card_user my-2" style="width: 10rem;">
						<div class="del_user delete" data-id="<?php echo $emp['user_id'] ?>">
							<img class="img_card_custom" src="../assets/img/icons/deluser.png" data-toggle="tooltip" title="Tap to delete this user" height="20" width="20" alt="Card image cap">
						</div>
						
							<?php 
								if($emp['sex']=='Male') {
									?>
										<img class="img_card_custom" src="../assets/img/icons/malecasual.png" height="150" width="150" alt="Card image cap">
									<?php
								} else {
									?>
										<img class="img_card_custom" src="../assets/img/icons/femalecorp.PNG" height="150" width="150" alt="Card image cap">
									<?php
								}
							?>
							<div class="card-body">
								<h6 style="margin-top: -18px; margin-left:7px;"><img data-toggle="tooltip" title="Click to edit user" data-id="<?php echo $emp['user_id'] ?>" class="img_card_custom edit_user edit" src="../assets/img/icons/edituser.png" height="20" width="20" alt="Card image cap"><strong><?php echo $emp['first_name'] ?></strong></h6>
								<h6 class="info_card text-center"><em>Wallet: <?php echo $emp['remaining_points']; ?></em></h6>
								<div class="row text-center">
									<div class="col-lg-12">
										<img class="add_points mx-2" data-toggle="tooltip" title="Tap to add rewards" data-id="<?php echo $emp['user_id'] ?>" src="../assets/img/icons/wal.png" height="30" width="30" alt=""> 
										<img class="deduct_points mx-2" data-toggle="tooltip" title="Tap to deduct rewards" data-id="<?php echo $emp['user_id'] ?>" src="../assets/img/icons/addwa.png" height="30" width="30" alt="">
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php 
			}
		}

		public function addRewardPoints($id, $num_of_added) {
			$query = mysqli_query($this->con, "UPDATE users SET remaining_points='$num_of_added' WHERE user_id='$id'");
			return;
		}
		
		public function ddRewardPoints($id, $num_of_dd) {
			$query = mysqli_query($this->con, "UPDATE users SET remaining_points='$num_of_dd' WHERE user_id='$id'");
			return;
		}

		public function getPointsHistory() {
				foreach($this->points_history as $index => $record) {
                    $created_at_date=new DateTime($record['created_at']);
                    $date_time_now = date("Y-m-d H:i:s");
                    $current_time = new DateTime($date_time_now);
                    $interval = $created_at_date->diff($current_time);
                    if($interval->y >= 1){
                        if($interval->y == 1){
                            $time_message = $interval->y . " year ago"; //1 yr ago
                        } else {
                            $time_message = $interval->y . " years ago"; //1+ yr ago
                        }
                    } else if($interval->m >= 1) {
                        if($interval->d == 0){
                            $days = " ago";
                        } else if($interval->d == 1) {
                            $days = $interval->d . " ago";
                        } else {
                            $days = $interval->d . " ago";
                        }

                        if($interval->m==1){
                            $time_message = $interval->m . " month". $days;      
                        } else {
                            $time_message = $interval->m . " months". $days;
                        }
                    } else if($interval->d >=1) {
                        if($interval->d ==1){
                            $time_message = "Yesterday";
                        } else {
                            $time_message = $interval->d . " days ago";
                       }
                    } else if($interval->h >=1){
                        if($interval->h ==1){
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    } else if($interval->i >=1){
                        if($interval->i ==1){
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    } else {
                        if($interval->s < 30){
                            $time_message = "Just ago";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
					}

					?>
					
                    <div class="card-body" style="">
                        <div class="row justify-content">
							<?php 
								if($record['remarks'] == 'Recieved'){
								?>
									<div class="col-md-1 mr-3"><img src="../assets/img/icons/recieved.png" height="20" width="20" alt=""></div>
									<div class="col-md-7" style="padding: 0 0 0 0 !important;">
										<h6 class="history_h" style="margin: 0 0 3px 0 !important;"><?php echo $record['added_points'] ?> <strong>points</strong> has been <strong>Added</strong> to <strong><?php echo $record['username']?></strong> </h6>
										<h6 class="history_h"><em style="font-size: 10px; "><?php echo $time_message?></em><h6>
									</div>
								<?php 
								} else {
									?>
										<div class="col-md-1 mr-3"><img src="../assets/img/icons/redeem.png" height="20" width="20" alt=""></div>
										<div class="col-md-7" style="padding: 0 0 0 0 !important;">
											<h6 class="history_h" style="margin: 0 0 3px 0 !important;"><?php echo $record['deducted_points'] ?> <strong>points</strong> has been <strong>Deducted</strong> to <strong><?php echo $record['username']?></strong> </h6>
											<h6 class="history_h"><em style="font-size: 10px; "><?php echo $time_message?></em><h6>
										</div>
									<?php
								}
							?>
                        </div>
					</div>
					<hr style="margin:0; padding:0;">
				<?php
                }
		}
	}

?>