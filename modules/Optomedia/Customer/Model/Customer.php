<?php

namespace Optomedia\Customer\Model;

class Customer {
    /**
     *
     * @var int 
     */    
    private $id;
    /**
     *
     * @var int 
     */       
    private $extid;
    /**
     *
     * @var string 
     */       
    private $lastname;
    /**
     *
     * @var string
     */       
    private $name;
    /**
     *
     * @var int 
     */       
    private $status;
    /**
     *
     * @var int 
     */       
    private $type;
    /**
     *
     * @var string 
     */       
    private $street;
    /**
     *
     * @var string 
     */   
    private $building;
    /**
     *
     * @var string 
     */       
    private $apartment;
    /**
     *
     * @var string 
     */       
    private $zip;
    /**
     *
     * @var string 
     */       
    private $city;
    /**
     *
     * @var int 
     */       
    private $countryid;
    /**
     *
     * @var string 
     */       
    private $postName;
    /**
     *
     * @var string 
     */       
    private $postStreet;
    /**
     *
     * @var string 
     */       
    private $postBuilding;
    /**
     *
     * @var string 
     */       
    private $postApartment;
    /**
     *
     * @var string 
     */       
    private $postZip;
    /**
     *
     * @var string 
     */       
    private $postCity;
    /**
     *
     * @var int 
     */       
    private $postCountryid;
    /**
     *
     * @var string 
     */       
    private $ten;
    /**
     *
     * @var string 
     */       
    private $ssn;
    /**
     *
     * @var string 
     */       
    private $regon;
    /**
     *
     * @var string 
     */       
    private $rbe;
    /**
     *
     * @var string 
     */       
    private $icn;
    /**
     *
     * @var string 
     */       
    private $info;
    /**
     *
     * @var string 
     */       
    private $notes;
    /**
     *
     * @var \DateTime 
     */       
    private $creationdate;
    /**
     *
     * @var \DateTime  
     */       
    private $moddate;
    /**
     *
     * @var int 
     */       
    private $creatorid;
    /**
     *
     * @var int 
     */       
    private $modid;
    /**
     *
     * @var bool 
     */       
    private $deleted;
    /**
     *
     * @var string 
     */       
    private $message;
    /**
     *
     * @var string 
     */       
    private $pin;
    /**
     *
     * @var int 
     */       
    private $cutoffstop;
    /**
     *
     * @var /DateTime 
     */       
    private $consentdate;
    /**
     *
     * @var bool 
     */       
    private $einvoice;
    /**
     *
     * @var bool 
     */       
    private $invoicenotice;
    /**
     *
     * @var bool 
     */       
    private $mailingnotice;
    /**
     *
     * @var int 
     */       
    private $divisionid;
    /**
     *
     * @var int 
     */       
    private $paytime;
    /**
     *
     * @var int 
     */       
    private $paytype;
    
    public function getId() {
        return $this->id;
    }

    public function getExtid() {
        return $this->extid;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getName() {
        return $this->name;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getType() {
        return $this->type;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getBuilding() {
        return $this->building;
    }

    public function getApartment() {
        return $this->apartment;
    }

    public function getZip() {
        return $this->zip;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountryid() {
        return $this->countryid;
    }

    public function getPostName() {
        return $this->postName;
    }

    public function getPostStreet() {
        return $this->postStreet;
    }

    public function getPostBuilding() {
        return $this->postBuilding;
    }

    public function getPostApartment() {
        return $this->postApartment;
    }

    public function getPostZip() {
        return $this->postZip;
    }

    public function getPostCity() {
        return $this->postCity;
    }

    public function getPostCountryid() {
        return $this->postCountryid;
    }

    public function getTen() {
        return $this->ten;
    }

    public function getSsn() {
        return $this->ssn;
    }

    public function getRegon() {
        return $this->regon;
    }

    public function getRbe() {
        return $this->rbe;
    }

    public function getIcn() {
        return $this->icn;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getCreationdate() {
        return $this->creationdate;
    }

    public function getModdate() {
        return $this->moddate;
    }

    public function getCreatorid() {
        return $this->creatorid;
    }

    public function getModid() {
        return $this->modid;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getPin() {
        return $this->pin;
    }

    public function getCutoffstop() {
        return $this->cutoffstop;
    }

    public function getConsentdate() {
        return $this->consentdate;
    }

    public function getEinvoice() {
        return $this->einvoice;
    }

    public function getInvoicenotice() {
        return $this->invoicenotice;
    }

    public function getMailingnotice() {
        return $this->mailingnotice;
    }

    public function getDivisionid() {
        return $this->divisionid;
    }

    public function getPaytime() {
        return $this->paytime;
    }

    public function getPaytype() {
        return $this->paytype;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setExtid($extid) {
        $this->extid = $extid;
        return $this;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setStreet($street) {
        $this->street = $street;
        return $this;
    }

    public function setBuilding($building) {
        $this->building = $building;
        return $this;
    }

    public function setApartment($apartment) {
        $this->apartment = $apartment;
        return $this;
    }

    public function setZip($zip) {
        $this->zip = $zip;
        return $this;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function setCountryid($countryid) {
        $this->countryid = $countryid;
        return $this;
    }

    public function setPostName($postName) {
        $this->postName = $postName;
        return $this;
    }

    public function setPostStreet($postStreet) {
        $this->postStreet = $postStreet;
        return $this;
    }

    public function setPostBuilding($postBuilding) {
        $this->postBuilding = $postBuilding;
        return $this;
    }

    public function setPostApartment($postApartment) {
        $this->postApartment = $postApartment;
        return $this;
    }

    public function setPostZip($postZip) {
        $this->postZip = $postZip;
        return $this;
    }

    public function setPostCity($postCity) {
        $this->postCity = $postCity;
        return $this;
    }

    public function setPostCountryid($postCountryid) {
        $this->postCountryid = $postCountryid;
        return $this;
    }

    public function setTen($ten) {
        $this->ten = $ten;
        return $this;
    }

    public function setSsn($ssn) {
        $this->ssn = $ssn;
        return $this;
    }

    public function setRegon($regon) {
        $this->regon = $regon;
        return $this;
    }

    public function setRbe($rbe) {
        $this->rbe = $rbe;
        return $this;
    }

    public function setIcn($icn) {
        $this->icn = $icn;
        return $this;
    }

    public function setInfo($info) {
        $this->info = $info;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setCreationdate(\DateTime $creationdate) {
        $this->creationdate = $creationdate;
        return $this;
    }

    public function setModdate(\DateTime $moddate) {
        $this->moddate = $moddate;
        return $this;
    }

    public function setCreatorid($creatorid) {
        $this->creatorid = $creatorid;
        return $this;
    }

    public function setModid($modid) {
        $this->modid = $modid;
        return $this;
    }

    public function setDeleted($deleted) {
        $this->deleted = $deleted;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setPin($pin) {
        $this->pin = $pin;
        return $this;
    }

    public function setCutoffstop($cutoffstop) {
        $this->cutoffstop = $cutoffstop;
        return $this;
    }

    public function setConsentdate(\DateTime $consentdate) {
        $this->consentdate = $consentdate;
        return $this;
    }

    public function setEinvoice($einvoice) {
        $this->einvoice = $einvoice;
        return $this;
    }

    public function setInvoicenotice($invoicenotice) {
        $this->invoicenotice = $invoicenotice;
        return $this;
    }

    public function setMailingnotice($mailingnotice) {
        $this->mailingnotice = $mailingnotice;
        return $this;
    }

    public function setDivisionid($divisionid) {
        $this->divisionid = $divisionid;
        return $this;
    }

    public function setPaytime($paytime) {
        $this->paytime = $paytime;
        return $this;
    }

    public function setPaytype($paytype) {
        $this->paytype = $paytype;
        return $this;
    }
}
