<?php

class HomeController extends BaseController {
	public function getIndex() {
		if($this->isAuthenticated()) {
			$this->tplEngine->display('home.tpl');
		} else {
			$this->tplEngine->display('index.tpl');
		}
	}

	public function getWithdraw() {
		if($this->isAuthenticated()) {
			if($this->getConfig('withdraw_min') < $this->getUser()->balanceInSat) {
				$result = $this->faucethub->send($this->getUser()->address, $this->getUser()->balanceInSat, $this->ip);
				if($result["success"] === true){
					$payOut = $this->getUser()->balanceInSat / 100000000;
					$updateUser = $db->prepare("UPDATE faucet_user_list SET balance = 0, last_activity = :timestamp WHERE id = :id");
					$updateUser->execute([':id' => $this->id, ':payout' => $payOut, ':timestamp' => $this->timestamp]);
					$transaction = $db->prepare("INSERT INTO faucet_transactions (userid, type, amount, timestamp) VALUES (:id, 'Withdrawal', :payout, :timestamp)");
					$transaction->execute([':id' => $this->id, ':payout' => $payOut, ':timestamp' => $this->timestamp]);
				    
				    $this->tplEngine->assign('resultClaim', result["html"]);

				} else {
					$this->tplEngine->assign('resultClaim', $this->alert('danger', "Unfortunately, we were unable to withdraw your funds. Please try again later."));
				}
			} else {
				$this->tplEngine->assign('resultClaim', $this->alert('danger', 'You don\'t have sufficient satoshis to withdraw. You need at least ' . $this->getConfig('withdraw_min') . ' satoshis.'));
			}
			$this->tplEngine->display('home.tpl');
		} else {
			$this->tplEngine->display('index.tpl');
		}
	}
}