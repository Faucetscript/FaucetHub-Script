<?php

class ClaimController extends BaseController {
	public function getVerify() {
		$this->tplEngine->display('404.tpl');
		exit();
	}

	public function getFinish() {
		$this->tplEngine->display('404.tpl');
		exit();
	}

	public function postVerify() {
		if(!$this->isAuthenticated()) {
			$this->tplEngine->display('404.tpl');
			exit();
		}
		return $this->tplEngine->display('verify.tpl');
	}

	public function postFinish() {
		if(!$this->isAuthenticated()) {
			$this->tplEngine->display('404.tpl');
			exit();
		}
		$lastClaim = $this->getUser()->last_claim;
		$nextClaim = $lastClaim + (60 * $this->getConfig('timer'));
		$difference = $nextClaim - time();
		if($difference > 0) {
			echo "You are not allowed to claim now.";
			exit();		
		}
		$captchaCheck = json_decode($this->checkCaptcha($_POST['g-recaptcha-response']))->success;
		if($captchaCheck){
			// valid, pay out
			$payOut = rand($this->getConfig('min_reward'), $this->getConfig('max_reward'));
			if($this->getUser()->payOut($payOut)) {
				$this->tplEngine->assign('resultClaim', $this->alert("success", "Awesome! You've claimed successfully " . $payOut . " satoshi.<br />You can claim again in " . $this->getConfig('timer') . " minutes!"));
				if($this->getUser()->referred_by != 0) {
					$this->getUser()->payReferer($payOut, $this->getConfig('referral_percent'));
				}
				$this->getShare($payOut);
				$newUser = $this->getUser();
				$newUser->balanceInSat = $newUser->balanceInSat;
				$this->tplEngine->assign('user', $newUser);
			}
		} else {
			// invalid. Person did not master the captcha.
			$this->tplEngine->assign('resultClaim', $this->alert("danger", "You failed the captcha. Please try again."));
		}
		return $this->tplEngine->display('home.tpl');
	}
}