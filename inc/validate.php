<?php
class Validate {

	public function __construct() {
	}

	public function clean($data, $sanitize = true) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = addslashes($data);
		if ($sanitize) {
			$data = htmlspecialchars($data);
		}
		return $data;
	}	

	public function isValid($valArray) {

		foreach ($valArray as $data => $val) {

			$type = explode("|", $val)[0];
			$length = explode("|", $val)[1];

			$data = $this->clean($data, false);

			switch ($type) {

				case 'text_ns':
					if (empty($data) || !preg_match("/^[a-zA-Z0-9]*$/", $data) || count($data) > $length){
						return false;
					}
				break;

				case 'text':
					if (empty($data) || !preg_match("/^[a-zA-Z0-9 ]*$/", $data) || count($data) > $length){
						return false;
					}
				break;

				case 'email':
					$email = $data;
					if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)){
						return false;
					}
				break;
				
				default: break;
			}
		}

		return true;
	}
}
?>