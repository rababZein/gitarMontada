<?php

class Application_Model_Fourm extends Zend_Db_Table_Abstract
{
    protected $_name = "forum";
    function addForum($data,$id){
        $row = $this->createRow();
        $row->forumName = $data['forumName'];
        $row->catId = $id;
        
       
        return $row->save();
    }
    function listForum(){
        
        return $this->fetchAll()->toArray();
    }
    function deleteForum($id){
        return $this->delete("forumId=$id");
    }
    function deleteForumOfDeletedCat($id){
        return $this->delete("catId=$id");
    }
    function getForumById($forumId){
        return $this->find($forumId)->toArray();
    }
            
    function editForum($data,$id){
        if(empty($data['forumName']))         
            unset ($data['forumName']);
        if(empty($data['catId']))        
            unset ($data['catId']);
        
        
        $this->update($data, "forumId=".$id);
      
        return $this->fetchAll()->toArray();
    }
     function listForumByID($forumId){
        $select = $this->select()->where("forumId = ".$forumId);
        $forum = $this->fetchAll($select)->toArray();
        return $forum[0];
    }
    function lockForum($data,$forumId){
        $this->update($data,"forumId=".$forumId);
    }

}

