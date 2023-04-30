<?php

class Profile extends ProfileContr {

    private $userType;
    private $description;
    private $accessType;

    public function __construct($userType=NULL, $description=NULL, $accessType=NULL) {
        $this->userType = $userType;
        $this->description = $description;
        $this->accessType = $accessType;
    }

    public function getUserType() {
        return $this->userType;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getAccessType() {
        return $this->accessType;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
    public function setAccessType($accessType) {
        $this->accessType = $accessType;
    }
}