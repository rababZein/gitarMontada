<?php

class CommentController extends Zend_Controller_Action
{

    public function init()
    {
            $site_model=new Application_Model_Site();
            $siteId=1;
            $site=$site_model->listSite($siteId);
        
            $authorization =Zend_Auth::getInstance();
            // if he is from another action add or list return him to log in again
            if(!$authorization->hasIdentity() && $this->_request->getActionName() != "login") {
                $this->redirect("user/login");
            }else{
            $info = $authorization->getIdentity();
            $ban=$info->ban;
            $admin=$info->admin;
                if($ban==1){
                    $this->render("cantaccess");
                    //exit();

                }
                if($admin==0){
                        if($site['lockSite']==0){
                            $this->render("locksite");
                        }
                        
                }
        }   
                
    }

    public function indexAction()
    {
        // action body
    }
    public function deleteAction()
    {
        $id = $this->_request->getParam("commentId");
 	//  echo $id;
        if(!empty($id)){
            $comment_model = new Application_Model_Comment();
            $comment_model->deleteComment($id);
        }
        
       $postId=$this->_request->getParam('postId');
               //  echo $id;

        $this->redirect("post/open/id/$postId"); 
    
    }
    
     public function addAction()
    {
$authorization =Zend_Auth::getInstance();
         if($authorization->hasIdentity()) { 
            $info = $authorization->getIdentity();
            $name = $info->name;
            $userId=$info->userId;
           // echo $userId;        exit();
        }  
       // echo $userId;        exit();
$commentForm  = new Application_Form_Comment();
       
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $comment_info = $form->getValues();
               $comment_model = new Application_Model_Comment();
               $comment_model->addComment($comment_info,$this->_request->getParam('id'),$userId);
               $id=$this->_request->getParam('id');
               $this->redirect("post/open/id/$id") ;      
           }
       }
    	$this->view->commentForm = $commentForm;


}

 public function editAction()
    {
    $id = $this->_request->getParam("commentId");

     $form  = new Application_Form_Comment();
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $comment_info = $form->getValues();
                var_dump($comment_info);

               $comment_model = new Application_Model_Comment();
               $comment_model->editComment($comment_info);
               
               $postId=$this->_request->getParam('postId');
               $this->redirect("post/open/id/$postId") ;
 		             
           }
           
        }
        if(!empty($id)){
            $comment_model = new Application_Model_Comment();
            $comment = $comment_model->getCommentById($id);
            //var_dump($comment);
            
            $form->populate($comment[0]);
        } 
        
        $this->view->form = $form;
	$this->render('add');
    }
    
     public function ajaxcommentAction(){
         $authorization =Zend_Auth::getInstance();
         if($authorization->hasIdentity()) { 
            $info = $authorization->getIdentity();
            $name = $info->name;
            $userId=$info->userId;
           // echo $userId;        exit();
        }  
         $postId = $this->_request->getParam("postId");
         $commentContain= $this->_request->getParam("commentContain");
         $userId=$this->_request->getParam("userId");
         
         //$form  = new Application_Form_Reply();
            
                  //echo "kk"; exit();
                   $reply_model = new Application_Model_Comment();
                   $reply_model->addReply($commentContain,$userId,$postId);


}
}

