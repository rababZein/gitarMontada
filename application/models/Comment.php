<?php

class Application_Model_Comment extends Zend_Db_Table_Abstract
{
    protected $_name = "comment";
    
    function addComment($data,$post_id,$iduser){
        $row = $this->createRow();
        $row->commentContain = $data['commentContain'] ;
        $row->userId =$iduser; // المفروض هنا يساوي ال id بتاع اليوسر اللي عامل لوج ان 
        $row->postId=$post_id;
        return $row->save();
    }
    function add($data,$post_id,$iduser){
        $row = $this->createRow();
        $row->commentContain = $data ;
        $row->userId =$iduser; // المفروض هنا يساوي ال id بتاع اليوسر اللي عامل لوج ان 
        $row->postId=$post_id;
        return $row->save();
    }
    
     function listComment($id){
         
         return $this->fetchAll('postId='.$id)->toArray();

    }
    
     function deleteComment($id){
         
        // echo $id;
        return $this->delete("commentId=$id");

    }
      function getCommentById($id){
        return $this->find($id)->toArray();
    }
            
    function editComment($data){
        $this->update($data,"commentId=".$data['commentId']);
       
        return $this->fetchAll()->toArray();
       
    }
    function updateComment($data){
        $this->update($data,"commentId=".$data['commentId']);
        
        /*$row = $this->createRow();
        $row->commentContain =$commentContain;
        $row->userId =$commID; // المفروض هنا يساوي ال id بتاع اليوسر اللي عامل لوج ان 
        $row->postId=4;
        return $row->save();*/
        
    }
    
    function getLastRow(){
        //return $lastInsertId = $this->getAdapter()->lastInsertId();
        /*$comm= $this->fetchAll('postId=8')->toArray();
        $count=count($comm)-1;
        
        return $comm[$count]['max(commentId)'];*/
        $sql = 'SELECT max(commentId) FROM comment';  
        $query = $this->getAdapter()->query($sql);
        $result = $query->fetchAll();
        return $result[0]['max(commentId)']; 
    }

}

