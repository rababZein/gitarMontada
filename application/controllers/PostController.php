<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        $site_model=new Application_Model_Site();
        $siteId=1;
        $site=$site_model->listSite($siteId);
        
        $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity() && $this->_request->getActionName()!='login') {
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

public function listAction()
    {
         $post_model = new Application_Model_Post();
         function getPostById($postId)
    { return $this->find($postId)->toArray(); }
    
    
        $id=$this->getParam('id');
        $forum_model= new Application_Model_Fourm();
         $authorization =Zend_Auth::getInstance();
            $info = $authorization->getIdentity();
           
            $userId=$info->userId;
            
            
        $this->view->fourm=$forum_model->listForumByID($id);
        
        $this->view->posts = $post_model->listPosts($id);
        $forum_model= new Application_Model_User();
        $this->view->user=$forum_model->listUserByID($userId);

    }
    
    
    public function checkAction()
    {
        $post_model = new Application_Model_Post();
        $postId=$this->getParam('id');
        $forumId=$this->getParam('forumId');

        $this->view->posts = $post_model->check($postId);
        $this->_redirect("post/list/id/$forumId");

    } 
    
    
    
    public function uncheckAction()
    {
        $post_model = new Application_Model_Post();
        $postId=$this->getParam('id');
        $forumId=$this->getParam('forumId');

        $this->view->posts = $post_model->uncheck($postId);
        $this->_redirect("post/list/id/$forumId");

    } 
    
    
    
    
    
    
     public function editAction()
{

$id = $this->_request->getParam("postId");

$form = new Application_Form_AddUser();
if ($this->_request->isPost()) {
if ($form->isValid($this->_request->getParams())) {
$comment_info = $form->getValues();
var_dump($comment_info);
$comment_info['postId']=$this->_request->getParam('postId');
$comment_model = new Application_Model_Post();
$comment_model->editPost($comment_info);

$postId = $this->_request->getParam('postId');
$this->redirect("post/open/id/$postId");
}
}
if (!empty($id)) {
$comment_model = new Application_Model_Post();
$comment = $comment_model->getPostById($id);

$form->populate($comment[0]);
}

$this->view->form = $form;
$this->render('add');

}
    
    
    
    
    
    
    
    
    public function deleteAction()
    {
        $id = $this->_getParam('postId');
        $post_model = new Application_Model_Post();
        $this->view->posts = $post_model->deletePosts($id);
        
                               $forumId=$this->getParam('id');
                $this->redirect("post/list/id/$forumId");

                               
                               
    }
    
    
    
     public function addAction()
    {
        $form  = new Application_Form_AddUser();
       
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $post_info = $form->getValues();
               
                       $forumId=$this->getParam('id');

               
               
               $authorization =Zend_Auth::getInstance();
         if($authorization->hasIdentity()) { 
            $info = $authorization->getIdentity();
           // $name = $info->name;
            $userId=$info->userId;
            //echo $userId;        exit();
          //  $this->redirect("post/list/id/$forumId");
        }
        
        
        
                $post_info['userId']=$userId;
                                $post_info['forumId']=$forumId;

               $user_model = new Application_Model_Post();
               $user_model->addPost($post_info);
                $this->redirect("post/list/id/$forumId");
           }
       }
       
	$this->view->form = $form;
        
        
    }
    
    public function openAction()
    {
       // get information of current loged user
         $authorization =Zend_Auth::getInstance();
         if($authorization->hasIdentity()) { 
            $info = $authorization->getIdentity();
          
            $admin=$info->admin;
            $userId=$info->userId;
            $userName=$info->userName;
            $sign=$info->signature;
            $userImage=$info->userImage;
 
            $this->view->admin=$admin ;
            $this->view->userId=$userId ;
            $this->view->name=$userName ;
            $this->view->userImage=$userImage;
             $this->view->sign=$sign;

         }   
        
         
         // get the status of post lock or not 
         $id = $this->_request->getParam("id");
         $post_model = new Application_Model_Post();
         $post = $post_model->getPostById($id);
         $this->view->lockPost=$post[0]['lockPost'];
         //view the post 
        $id = $this->_request->getParam("id");
        $post_model = new Application_Model_Post();
        //$post_info= $post_model->getPostById($id);
        $post_info= $post_model->listPostByID($id);
        $userPostId=$post_info['userId'];
        $user_model = new Application_Model_User();
        $user = $user_model->listUserByID($userPostId);
        $this->view->userPost=$user;
        $this->view->post = $post_info;
        
        
      
        
        //view all comments
        $comment_model = new Application_Model_Comment();
        $comment=$comment_model->listComment($id);
       
         // get information of users who made comment
       for($i=0;$i<count($comment);$i++){
            $user_model = new Application_Model_User();
            $uId=$comment[$i]['userId'];
            $user = $user_model->listUserByID($uId);
           
            $userNAME[]=$user['userName'];
           
            $signatureUser[]=$user['signature'];
            
            $image[]=$user['userImage'];
       
       }
       
       
         $this->view->userNAME=$userNAME;
         $this->view->signatureUser=$signatureUser;
         $this->view->image=$image;
         

        
      
        
       $this->view->comments = $comment;

         
       
         
        $this->view->comments = $comment;
         
        $commentForm  = new Application_Form_Comment();
       
       if($this->_request->isPost()){
           if($commentForm->isValid($this->_request->getParams())){
               $comment_info = $commentForm->getValues();
               $comment_model = new Application_Model_Comment();
               $comment_model->addComment($comment_info,$this->_request->getParam('id'),$userId);
               $id=$this->_request->getParam('id');
                
               $this->redirect("post/open/id/$id") ;      
           
           }
       }
       
    	$this->view->commentForm = $commentForm;
         
    }
    
       public function lockAction()
    {
         
       
        $postId = $this->_request->getParam("postId");
        $lock = $this->_request->getParam("lock");
        
        $post_model = new Application_Model_Post();
      
        $data=array(
            'lockpost'=>$lock,
        );
        $post_model->lockPost($data, $postId);
        
        $this->redirect("post/open/id/$postId");
       
    
         
    }
    
    function cmmAction(){
        $commentContain = $this->_request->getParam("body");
        //$userId = $this->_request->getParam("userId");
        //$postId= $this->_request->getParam("postId");
        $commID = $this->_request->getParam("commID");
        $data=array(
            'commentId'=>$commID,
            'commentContain'=>$commentContain,
        );
        $comm_model = new Application_Model_Comment();
        $comm_model->updateComment($data);
        
    }
    
    
    //test git
    
    public function ajaxcommentAction(){
        
         $postId = $this->_request->getParam("postId");
         $commentContain= $this->_request->getParam("commentContain");
         $uId=$this->_request->getParam("userId");
         
    
        $reply_model = new Application_Model_Comment();
        $reply_model->add($commentContain,$uId,$postId);


    }
    
    public function userpostAction(){
        $userId = $this->_request->getParam("id");
        $post_model=new Application_Model_Post();
        $post=$post_model->userPost($userId);
        $this->view->$post;
    }
    
    
    public function ajaxdelAction()
    {
        $id = $this->_request->getParam("commentId");
 	//  echo $id;
        if(!empty($id)){
            $comment_model = new Application_Model_Comment();
            $comment_model->deleteComment($id);
        }
    }
    
}

