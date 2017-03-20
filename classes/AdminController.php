<?php

class AdminController extends BaseController {
	public function getHome() {
		if(!$this->isAuthenticated() || $this->getUser()->admin != 1) {
			$this->tplEngine->display('404.tpl');
			exit();
		}

		$this->tplEngine->display('admin.tpl');
	}

	public function postUpdate() {
		switch($_GET['action']) {
			case "general":
				if(isset($_POST['faucet_name']) && isset($_POST['timer']) && isset($_POST['min_reward']) && isset($_POST['max_reward']) && isset($_POST['reCaptcha_privKey']) && isset($_POST['reCaptcha_pubKey']) && isset($_POST['faucethub_key']) && isset($_POST['referral_percent'])) {
					$fName = $_POST['faucet_name'];
					$fSlogan = $_POST['faucet_slogan'];
					$timer = $_POST['timer'];
					$minReward = $_POST['min_reward'];
					$maxReward = $_POST['max_reward'];
					$rePriv = $_POST['reCaptcha_privKey'];
					$rePub = $_POST['reCaptcha_pubKey'];
					$fHubKey = $_POST['faucethub_key'];
					$refPercent = $_POST['referral_percent'];

					$this->setConfig('faucet_name', $fName);
					$this->setConfig('faucet_slogan', $fSlogan);
					$this->setConfig('timer', $timer);
					$this->setConfig('min_reward', $minReward);
					$this->setConfig('max_reward', $maxReward);
					$this->setConfig('reCaptcha_privKey', $rePriv);
					$this->setConfig('reCaptcha_pubKey', $rePub);
					$this->setConfig('faucethub_key', $fHubKey);
					$this->setConfig('referral_percent', $refPercent);
					$this->tplEngine->assign('results', $this->alert('success', 'Settings are saved.'));
				} else {
					$this->tplEngine->assign('results', $this->alert("The fields can't be blank."));
				}
				break;
			case "ads":
				if(isset($_POST['space_top']) && isset($_POST['space_left']) && isset($_POST['space_right']) && isset($_POST['space_bottom'])) {
					$spaceTop = $_POST['space_top'];
					$spaceLeft = $_POST['space_left'];
					$spaceRight = $_POST['space_right'];
					$spaceBottom = $_POST['space_bottom'];

					$this->setConfig('space_top', $spaceTop);
					$this->setConfig('space_left', $spaceLeft);
					$this->setConfig('space_right', $spaceRight);
					$this->setConfig('space_bottom', $spaceBottom);
					$this->tplEngine->assign('results', $this->alert('success', 'Settings are saved.'));
				} else {
					$this->tplEngine->assign('results', $this->alert("The fields can't be blank."));
				}
				break;

				
		}
		$this->tplEngine->display('admin.tpl');
	}
}