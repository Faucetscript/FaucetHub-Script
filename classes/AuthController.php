<?php

class AuthController extends BaseController {
	public function getLogin() {
		$this->tplEngine->display('404.tpl');
		exit();
	}

	public function getSignup() {
		$this->tplEngine->display('404.tpl');
		exit();
	}

	public function postLogin() {
		if($this->isAuthenticated()) {
			echo "You are already logged in.";
			exit();
		}
		if(trim($_POST['address']) != '' && trim($_POST['password']) != ''){
			if(strlen($_POST['address']) < 30 || strlen($_POST['address']) > 40){
				$this->tplEngine->assign('resultSignIn', $this->alert("danger", "The bitcoin address doesn't look valid."));
			} else {
				$addressCheck = $this->db->prepare("SELECT * FROM faucet_user_list WHERE LOWER(address) = :address");
				$addressCheck->execute([':address' => strtolower($_POST['address'])]);

				if($addressCheck->rowCount() == 1){
					$user = $addressCheck->fetch(PDO::FETCH_ASSOC);
					$password = $user['password'];
					if (password_verify($_POST['password'], $password)) {
						//valid
						$userid = $user['id'];
						$sessionKey = sha1(uniqid(mt_rand(), true));
						$createKey = $this->db->prepare("INSERT INTO faucet_login_session VALUES (:user_id, :session_key, UNIX_TIMESTAMP())");
						$createKey->execute(array(":session_key" => $sessionKey, ":user_id" => $userid));
						$updateUser = $this->db->prepare("UPDATE faucet_user_list SET last_activity = UNIX_TIMESTAMP() WHERE id = :id");
						$updateUser->execute([':id' => $userid]);
						$_SESSION['session_key'] = $sessionKey;

						header("Location: index.php");
						exit();

					} else {
						$this->tplEngine->assign('resultSignIn', $this->alert("danger", "Password is incorrect."));
					}
				} else {
					$this->tplEngine->assign('resultSignIn', $this->alert("danger", "There already is no account with the provided address."));
				}
			}
		} else {
			$this->tplEngine->assign('resultSignIn', $this->alert("The fields can't be blank."));
		}
		$this->tplEngine->display('index.tpl');

	}

	public function getLogout() {
		$validateKey = $this->db->prepare("DELETE FROM faucet_login_session WHERE session_key  = :session_key");
		$validateKey->execute(array(":session_key" => $_SESSION['session_key']));

		session_destroy();

		header("Location: index.php");
		exit();

	}

	public function postSignup() {
		if($this->isAuthenticated()) {
			echo "You are already logged in.";
			exit();
		}
		if(trim($_POST['address']) != '' && trim($_POST['password']) != '' && trim($_POST['password2']) != ''){
			if(strlen($_POST['address']) < 30 || strlen($_POST['address']) > 40){
				$this->tplEngine->assign('resultSignUp', $this->alert("danger", "The bitcoin address doesn't look valid."));
			} else {
				$addressCheck = $this->db->prepare("SELECT * FROM faucet_user_list WHERE LOWER(address) = :address");
				$addressCheck->execute([':address' => strtolower($_POST['address'])]);

				if($addressCheck->rowCount() == 1){
					$this->tplEngine->assign('resultSignUp', $this->alert("danger", "There already is a account with the provided address."));
				} else {
					$CaptchaCheck = json_decode($this->checkCaptcha($_POST['g-recaptcha-response']))->success;
					if(!$CaptchaCheck){
						$this->tplEngine->assign('resultSignUp', $this->alert("danger", "Please complete the captcha."));
					} else {
						if($_POST['password'] == $_POST['password2']) {
							$refBy = 0;
							$password = $this->generatePassword($_POST['password']);
							if(isset($_COOKIE['ref']) && is_numeric($_COOKIE['ref'])) {
								$userCheck = new User($_COOKIE['ref']);
								if(!is_null($userCheck)) {
									$refBy = $_COOKIE['ref'];
								}
							}
							try {
								$createQry = $this->db->prepare("INSERT INTO faucet_user_list (address, password, ip_address, balance, joined, last_activity, referred_by) VALUES (:address, :password, :ip, '0', :timestamp, :timestamp2, :refby)");
								if($createQry->execute([':address' => $_POST['address'], ':password' => $password, ':ip' => $this->ip, ':timestamp' => $this->timestamp, ':timestamp2' => $this->timestamp, ':refby' => $refBy])) {
									$this->tplEngine->assign('resultSignUp', $this->alert("success", "Your account has been created. Please sign in to claim."));
								}	
							} catch(PDOException $e) {
								$this->tplEngine->assign('resultSignUp', $this->alert("danger", "Your signup failed. Try again later."));
							}
						} else {
							$this->tplEngine->assign('resultSignUp', $this->alert("danger", "The two passwords given don't match."));
						}
					}
					//$content .= alert("danger", "There's been no account found with given credentials.");
					//$alertForm = "has-error";
				}
			}
		} else {
			$this->tplEngine->assign('resultSignUp', $this->alert("danger", "The fields can't be blank."));
		}
		$this->tplEngine->display('index.tpl');
	}
}