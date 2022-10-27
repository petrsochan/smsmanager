<?php
namespace PeS\SmsManager;

class SendResponse {

    private $result;

    private $requestid;

    private $phone = [];

    private $customid;

    private $errorid;

    public function __construct($str) {
        $arr = explode('|', $str);
        $this->result = $arr[0];
        if (strtolower($arr[0]) == 'ok') {
            $this->requestid = $arr[1];
            $this->phone = explode(',', $arr[2]);
            if (isset($arr[3])) {
                $this->customid = $arr[3];
            }
        } else {
            $this->errorid = $arr[1];
        }
    }

    /**
     * Get the value of result
     */ 
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set the value of result
     *
     * @return  self
     */ 
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Get the value of requestid
     */ 
    public function getRequestid()
    {
        return $this->requestid;
    }

    /**
     * Set the value of requestid
     *
     * @return  self
     */ 
    public function setRequestid($requestid)
    {
        $this->requestid = $requestid;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of customid
     */ 
    public function getCustomid()
    {
        return $this->customid;
    }

    /**
     * Set the value of customid
     *
     * @return  self
     */ 
    public function setCustomid($customid)
    {
        $this->customid = $customid;

        return $this;
    }

    /**
     * Get the value of errorid
     */ 
    public function getErrorid()
    {
        return $this->errorid;
    }

    /**
     * Set the value of errorid
     *
     * @return  self
     */ 
    public function setErrorid($errorid)
    {
        $this->errorid = $errorid;

        return $this;
    }
}