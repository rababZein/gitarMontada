<?php

class Application_Model_Site extends Zend_Db_Table_Abstract
{
    protected $_name = "site";
    
    function lockSite($data,$siteId){
       
        $this->update($data,"siteId=1");
    }
    
    function listSite($siteId){
       
        $select = $this->select()->where("siteId = ".$siteId);;
        $site = $this->fetchAll($select)->toArray();
        return $site[0];
    }

}

