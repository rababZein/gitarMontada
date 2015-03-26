<?php

class Application_Model_User extends Zend_Db_Table_Abstract


{

 protected $_name = "user";
 
 function addUser($data){
        $row = $this->createRow();
        $row->userName = $data['userName'];
        $row->password = md5($data['password']);
        $row->email = $data['email'] ;
                $row->userImage = $data['pic'] ;
                $row->gender = $data['gender'] ;
                $row->country = $data['country'] ;
                $row->signature = $data['signature'] ;

                
        return $row->save();
 }
 function listUserByID($userID){
        $select = $this->select()->where("userId = ".$userID);
        $user = $this->fetchAll($select)->toArray();
        return $user[0];
    }
    
    function listUsers(){
        
        return $this->fetchAll()->toArray();
    }
    
    function getUserById($userId){
        return $this->find($userId)->toArray();
    }
    
            
    function editUser($data){
        if(!empty($data['password']))
            $data['password']=md5($data['password']);
        else
            unset ($data['password']);
        if(empty($data['userName']))
             unset ($data['userName']);
        
        if(empty($data['userName']))
             unset ($data['userName']);
        
        if(empty($data['email']))
             unset ($data['email']);
        
        if(empty($data['userImage']))
             unset ($data['userImage']);
        
        if(empty($data['gender']))
             unset ($data['gender']);
        
        if(empty($data['signature']))
             unset ($data['signature']);
        
        if(empty($data['country']))
             unset ($data['country']);
        
        
        $this->update($data, "userId=".$data['userId']);
        return $this->fetchAll()->toArray();
    }
    
    function deleteUser($id){
        return $this->delete("userId=$id");
    }

 
    /*function listUserByID($userID){
        $select = $this->select()->where("id = ".$userID);
        $user = $this->fetchAll($select)->toArray();
        return $user[0];
    }*/
    
    function admin($data,$userId){
        $this->update($data,"userId=".$userId);
    }
    function ban($data,$userId){
        $this->update($data,"userId=".$userId);
    }
 
 
 
 
}

