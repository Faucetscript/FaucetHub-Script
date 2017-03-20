<?php

class BaseModel {
	public function toSatoshi($amount) {
		$satoshi = $amount * 100000000;
		return $satoshi;
	}
}