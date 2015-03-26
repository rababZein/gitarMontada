<?php

class Application_Model_Message extends Zend_Db_Table_Abstract
{
    protected $_name = "message";
    function addForum($data,$sender,$receiver,$senderName,$receiverName){
        $row = $this->createRow();
        $row->subject = $data['subject'];
        $row->body = $data['body'];
        $row->sender = $sender;
        $row->receiver = $receiver;
        $row->senderName=$senderName;
        $row->receiverName=$receiverName;
       
        return $row->save();
    }
    function listMessage(){
        
        return $this->fetchAll()->toArray();
    }
    function deleteMessage($sendetId){
        return $this->delete("sender=$sendetId");
    }
   
    function listMessageBySenderId($senderId){
       // return $this->find($senderId)->toArray();
        return $this->fetchAll("sender = ".$senderId)->toArray();
    }
            
    
     function listMessageByReceiverID($receiverId){
        /*$select = $this->select()->where("receiver = ".$receiverId);
        $message = $this->fetchAll($select)->toArray();
        return $message[0];*/
          //return $this->find($receiverId)->toArray();
         return $this->fetchAll("receiver = ".$receiverId)->toArray();
    }
    function listMessageById($messageId){
       // return $this->find($senderId)->toArray();
      //  return $this->fetchAll("messageId = ".$messageId)->toArray();
        $select = $this->select()->where("messageId = ".$messageId);
        $message = $this->fetchAll($select)->toArray();
        return $message[0];
    }

}

