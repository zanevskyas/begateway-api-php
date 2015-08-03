<?php
class beGateway_Response extends beGateway_ResponseBase {

  public function isSuccess() {
    return $this->getStatus() == 'successful';
  }

  public function isFailed() {
    return $this->getStatus() == 'failed';
  }

  public function isIncomplete() {
    return $this->getStatus() == 'incomplete';
  }

  public function isTest() {
    if ($this->hasTransactionSection()) {
      return $this->getResponse()->transaction->test == true;
    }
    return false;
  }

  public function getStatus() {
    if ($this->hasTransactionSection()) {
      return $this->getResponse()->transaction->status;
    }elseif ($this->isError()) {
      return 'error';
    }
    return false;
  }

  public function getUid() {
    if ($this->hasTransactionSection()) {
      return $this->getResponse()->transaction->uid;
    }else{
      return false;
    }
  }

  public function getTrackingId() {
    if ($this->hasTransactionSection()) {
      return $this->getResponse()->transaction->tracking_id;
    }else{
      return false;
    }
  }

  public function hasTransactionSection() {
    return (is_object($this->getResponse()) && isset($this->getResponse()->transaction));
  }

  public function getMessage() {

    if (is_object($this->getResponse())) {

      if (isset($this->getResponse()->message)) {

        return $this->getResponse()->message;

      }elseif (isset($this->getResponse()->transaction)) {

        return $this->getResponse()->transaction->message;

      }elseif (is_object($this->getResponse()->response)) {

        return $this->getResponse()->response->message;

      }
    }

    return '';

  }
}
?>
