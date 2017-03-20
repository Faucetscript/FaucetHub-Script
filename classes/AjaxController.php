<?php

class AjaxController extends BaseController {
	public function getClaimin() {
		if($this->isAuthenticated()) {

			$lastClaim = $this->getUser()->last_claim;
			$nextClaim = $lastClaim + (60 * $this->getConfig('timer'));
			$difference = $nextClaim - time();
			if($difference > 0) {
				$hours = floor($difference / 3600);
				if($hours != 0) {
					$difference = $difference - ($hours * 3600);
				}
				$minutes = floor($difference / 60);
				$seconds = $difference - ($minutes * 60);

				if($hours != 0) {
					$claimIn = "in " . $hours . " hours, " . $minutes . " minutes and " . $seconds . " seconds";
				} else {
					$claimIn = "in " . $minutes . " minutes and " . $seconds . " seconds";
				}
				echo $claimIn;
			} else {
				echo "now";
			}

		}
	}
}