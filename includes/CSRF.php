<?php

class CSRF {
  /*
   * Contains the hours till the token expires.
   * @var int
   */

  private $_time = 3;

  /*
   * Cleans the expired tokens and creates the CSRF session if it doesn't exist.
   * @return void
   */

  public function __construct() {

    $this->deleteExpiredTokens();

    if (!isset($_SESSION['security']['csrf'])) {
      $_SESSION['security']['csrf'] = [];
    }
  }

  /*
   * Prints the json string with all the sessions.
   * @return void
   */

  public function debug() {
    echo json_encode($_SESSION['security']['csrf'], JSON_PRETTY_PRINT);
  }

  /*
   * Sets the time in hours till the token expires.
   * @param string $time
   * @return boolean
   */

  public function set_time($time) {
    if (is_int($time) && is_numeric($time)) {
      $this->_time = $time;

      return true;
    }
    return false;
  }

  /*
   * Removes the session if it exists and returns true or false.
   * @return boolean
   */

  public function delete($token) {
    $this->deleteExpiredTokens();

    if ($this->get($token)) {
      unset($_SESSION['security']['csrf'][$token]);
      return true;
    }

    return false;
  }

  /*
   * Walks through all the sessions to check if they are expired.
   * @return void
   */

  public function deleteExpiredTokens() {
    if(isset($_SESSION['security']['csrf']) && isset($_SESSION['security'])) {
      foreach ($_SESSION['security']['csrf'] AS $token => $time) {
        if (time() >= $time) {
          unset($_SESSION['security']['csrf'][$token]);
        }
      }
    }
  }

  /*
   * Creates the session token.
   * @return string
   */

  public function set($time = true, $multiplier = 3600) {

    if (function_exists('openssl_random_pseudo_bytes')) {
      $key = substr(bin2hex(openssl_random_pseudo_bytes(128)), 0, 128);
    } else {
      $key = sha1(mt_rand() . rand());
    }
    $value = (time() + (($time ? $this->_time : $time) * $multiplier));

    $_SESSION['security']['csrf'][$key] = $value;
    return $key;
  }

  /*
   * Checks if a session exists and returns true or false.
   * @return boolean
   */

  public function get($token) {
    $this->deleteExpiredTokens();
    return isset($_SESSION['security']['csrf'][$token]);
  }

  /*
   * returns the last key in the session array.
   * @return string
   */

  public function last() {
    return end($_SESSION['security']['csrf']);
  }

}