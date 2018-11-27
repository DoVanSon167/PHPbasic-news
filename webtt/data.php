<?php
	class database {
		//khai bao cac thuoc tinh
		private $conn = null;
		private $host = 'localhost';
		private $user = 'root';
		private $pass = '';
		private $data = 'tintuconline';
		private $result =  null;

		//xay dung cac phuong thuc
		private function connect(){
			$this->conn = new mysqli($this->host,$this->user,$this->pass,$this->data)
			or die('ket noi that bai!');
			$this->conn->query('SET NAMES UTF8');
		}

		//phuong thuc select du lieu
		public function select($sql){
			$this->connect();
			$this->result = $this->conn->query($sql);
		}
		public function fetch(){
			if ($this->result->num_rows > 0) {
				$rows = $this->result->fetch_assoc();
			}else{
				$rows = 0;
			}
			return $rows;
		}
		//phuong thuc chung cho insert,delete,update
		public function command($sql){
			$this->connect();
			$this->conn->query($sql);
		}
		public function CheckNull($a){
			if (!empty($a)) {
				return true;
				# code...
			}else{
				return false;
			}
		}
		public function CheckNumber($a){
			if (is_numeric($a)) {
				return true;
				# code...
			}else{
				return false;
			}
		}
	}
?>