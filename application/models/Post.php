<?php

class Application_Model_Post extends Zend_Db_Table_Abstract
{
    protected $_name = "post";

    function addPost($data){
        $row = $this->createRow();
        $row->postName = $data['postName'];
                $row->forumId = $data['forumId'];
        $row->userId = $data['userId'];
        $row->postContain = $data['postContain'] ; 
        
        return $row->save();
    }
 
 
    
    function getPostById($postId)
    { return $this->find($postId)->toArray(); }
    
    
    
    function check($postId)
    { 
      $data = array(
   'checked' => 'checked'
          );  
    $this->update($data,"postId=".$postId);
       

    }
    
    
    function uncheck($postId)
    { 
      $data = array(
   'checked' => NULL
          );  
    $this->update($data,"postId=".$postId);
       

    }
    
    function editPost($data){
        $this->update($data,"postId=".$data['postId']);

        return $this->fetchAll()->toArray();

    }
   

function listPosts($id){
$where = array(
"forumId=$id"

);

$test=$this->fetchAll($where)->toArray();

if(count($test))
{


return $this->fetchAll($where)->toArray();
}
else
{

return $id;

}

}
    
    
    function deletePosts($id){
             return $this->delete("postId=$id");

    }
    
     function lockPost($data,$postId){
       //  $this->update($data,"postId=".$postId);
       
        return $this->update($data,"postId=".$postId);
    }
    
    function listPostByID($postId){
        $select = $this->select()->where("postId = ".$postId);
        $post = $this->fetchAll($select)->toArray();
        return $post[0];
    }
    
    function userPost($userId){
        $select = $this->select()->where("userId = ".$userId);
        $post = $this->fetchAll($select)->toArray();
    }
    

}

