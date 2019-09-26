<?php 
	Class ConnectDb {
		private $con;

		public function dbConnection() {
			// iflocal
			$this->con = mysqli_connect("72.52.168.2", "avail4t_tron", "TITDeS0TAELL", "avail4t_tron");
			return $this->con;
		}
	}
?>