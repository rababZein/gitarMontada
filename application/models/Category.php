<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = "category";
    function addCategory($data){
        $row = $this->createRow();
        $row->catName = $data['catName'];
        //$row->forumId = $data['forumId'];
        
        //$row->catId = $data['catId'];
       
        return $row->save();
    }
    function listCategory(){
        
        return $this->fetchAll()->toArray();
    }
    function deleteCategory($catId){
        return $this->delete("catId=$catId");
    }
    function getCategoryById($catId){
        return $this->find($catId)->toArray();
    }
            
    function editCategory($data,$id){
        if(empty($data['catName']))         
            unset ($data['catName']);

        $this->update($data, "catId=".$id);
      
        return $this->fetchAll()->toArray();
    }
     function listCategoryByID($catId){
        $select = $this->select()->where("catId = ".$catId);
        $cat = $this->fetchAll($select)->toArray();
        return $cat[0];
    }


}

