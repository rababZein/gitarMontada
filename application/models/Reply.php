<?php

class Application_Model_Reply extends Zend_Db_Table_Abstract
{
    protected $_name = "reply";
    function addReply($data,$messageId,$name){
        $row = $this->createRow();
        $row->messageId=$messageId;
         $row->name=$name;
        $row->body = $data;
        
        return $row->save();
    }
    function listRepltByMessageId($messageId){
        $select = $this->select()->where("messageId = ".$messageId);
        $message = $this->fetchAll($select)->toArray();
        return $message;
    }

}

