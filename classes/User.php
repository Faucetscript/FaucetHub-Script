<?php

class User extends BaseModel {
	public function __construct($userId) {
		$db = DB::getInstance();
		$query = $db->prepare("SELECT * FROM `faucet_user_list` WHERE id = :id");
		$query->execute([':id' => $userId]);
		if($query->rowCount() == 1) {
			$user = $query->fetch(PDO::FETCH_ASSOC);
			foreach($user as $key => $value) {
				$this->$key = $value;
			}
			$this->balanceInSat = $this->toSatoshi($this->balance);
			return true;
		}
		return null;
	}

	public static function findByAddress($address) {
		$db = DB::getInstance();
		$query = $db->prepare("SELECT * FROM `faucet_user_list` WHERE address = :address");
		$query->execute([':address' => $address]);
		if($query->rowCount() == 1) {
			$user = $query->fetch(PDO::FETCH_ASSOC);
			return new User($user['id']);
		}
		return null;
	}

	public function getRefLink() {
		$siteUrl = $_SERVER["SERVER_NAME"];
		return 'http://' . $siteUrl . '/index.php?ref=' . $this->address;
	}

	public function payReferer($amount, $feePercentage) {
		$referer = $this->referred_by;
		$refFee = $amount * ($feePercentage / 100);
		return $this->payOut($refFee, $referer, true);
	}
	
	public function payOut($amount, $uId = null, $ref = false) {
		if(is_null($uId)) {
			$uId = $this->id;
		}
		if($ref == false) {
			$type = 'Payout';
		} else {
			$type = 'Referral';
		}
		$timestamp = time();
		$db = DB::getInstance();
		$payOut = $amount / 100000000;
		$updateUser = $db->prepare("UPDATE faucet_user_list SET balance = balance + :payout, last_claim = :timestamp WHERE id = :id");
		$updateUser->execute([':id' => $uId, ':payout' => $payOut, ':timestamp' => $timestamp]);
		$transaction = $db->prepare("INSERT INTO faucet_transactions (userid, type, amount, timestamp) VALUES (:id, :type, :payout, :timestamp)");
		$transaction->execute([':id' => $uId, ':payout' => $payOut, ':timestamp' => $timestamp, ':type' => $type]);
		return true;
	}
}