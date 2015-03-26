<?php
  //  require 'Zend\Mail'; 

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $site_model=new Application_Model_Site();
        $siteId=1;
        $site=$site_model->listSite($siteId);
        
        
        $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity() && $this->_request->getActionName()!='login') {
            $this->redirect("user/login");
        }else{
            $info = $authorization->getIdentity();
            if(!empty($info)){
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
        
    }
    public function siteAction(){
        $site_model = new Application_Model_Site();
        $siteId=1;
        $this->view->site = $site_model->listSite($siteId);
    }
    public function locksiteAction() {
        $lock= $this->_request->getParam("lock");
        //echo $lock;        exit();
        $site_model = new Application_Model_Site();
        $data=array(
            'lockSite'=>$lock,
        );
         //$x=array('lockSite'=>$lock,);
        $siteId=1;
        $site_model->lockSite($data,$siteId);
        $this->redirect("user/site");
    }

    public function indexAction()
    {
        // action body
    }
   /* public function cantaccessAction(){
        //$this->redirect("user/cantaccess");
    }*/

        public function mailAction()
    
    {
       // require 'Zend\Mail';
        
//     $tr = new Zend_Mail_Transport_Sendmail('-freturn_to_me@example.com');
//Zend_Mail::setDefaultTransport($tr);

    
        $m=$this->_getParam('mail');
        
        
        
        
        
        
        $mailTransport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', array(
    'auth'     => 'login',
    'username' => 'engy.elmoshrify@gmail.com',
    'password' => 'engyengy',
    'port'     => '587',
    'ssl'      => 'tls',
));
Zend_Mail::setDefaultTransport($mailTransport);
    $mail = new Zend_Mail();
    $mail->setBodyText('This is the text of the mail.');
    $mail->setFrom('engy.elmoshrify@gmail.com', 'Some Sender');
    $mail->addTo($m, 'Some Recipient');
    $mail->setSubject('TestSubject');
    $sent = true;
try {
    $mail->send();
} catch (Exception $e){
    $sent = false;
}

//Do stuff (display error message, log it, redirect user, etc)
if($sent){
    echo 'Mail was sent successfully.';
} else {
    //Mail failed to send.
}
        
        echo $sent;
      
        
        
}
    
   public function listAction()
    {
        $user_model = new Application_Model_User();
        $this->view->users = $user_model->listUsers();
    }
    public function banAction()
    {
         $userId = $this->_request->getParam("id");
         $ban = $this->_request->getParam("ban");
         $user_model = new Application_Model_User();
         $data=array(
             'ban'=>$ban,
         );
         $user_model->ban($data, $userId);
         $this->redirect("user/list");
         
    }
    public function adminAction()
    {
         $userId = $this->_request->getParam("id");
         $admin = $this->_request->getParam("admin");
         $user_model = new Application_Model_User();
         $data=array(
             'admin'=>$admin,
         );
         $user_model->admin($data, $userId);
         $this->redirect("user/list");
    }

        public function deleteAction()
    {
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $user_model = new Application_Model_User();
            $user_model->deleteUser($id);
        }
        $this->redirect("user/list");
      
    }
    public function editAction()
    {
        $userid = $this->_request->getParam("id");
    //    
        $form  = new Application_Form_Registeration();
        $form->email->setValidators(array());
        $form->email->setAllowEmpty(true);
        $form->email->setRequired(false);
        
        $form->userName->setValidators(array());
        $form->userName->setAllowEmpty(true);
        $form->userName->setRequired(false);
        
        
        /*$form->password->setValidators(array());
        $form->password->setAllowEmpty(true);
        $form->password->setRequired(false);*/
        
        $form->pic->setValidators(array());
        $form->pic->setAllowEmpty(true);
        $form->pic->setRequired(false);
        
        $form->gender->setValidators(array());
        $form->gender->setAllowEmpty(true);
        $form->gender->setRequired(false);
        
        $form->country->setValidators(array());
        $form->country->setAllowEmpty(true);
        $form->country->setRequired(false);
        
        $form->signature->setValidators(array());
        $form->signature->setAllowEmpty(true);
        $form->signature->setRequired(false);

        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               $user_model = new Application_Model_User();
               $data=array(
                   'userId'=>$user_info['userId'],
                   'userName'=>$user_info['userName'],
                   'password'=>$user_info['password'],
                   'email'=>$user_info['email'],
                   'userImage'=>$user_info['userImage'],
                   'gender'=>$user_info['gender'],
                   'signature'=>$user_info['signature'],
                   'country'=>$user_info['country'],
               );
               $user_model->editUser($data);
               $this->redirect("user/profile");
                       
           }
        }  
            if(!empty($userid)){
               // echo $userid;        exit();
                $user_model = new Application_Model_User();
                $user = $user_model->getUserById($userid);
                //var_dump($user); exit;

                $form->populate($user[0]);
            } /*else
                */
        
        
       
     
        $this->view->form = $form;
	$this->render('add');
    }
    
    

    
    
    public function addAction()
    {
    $form  = new Application_Form_Registeration();
       
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               $user_model = new Application_Model_User();
               $result=$user_model->addUser($user_info);
    if($result)
    {
        $m=$this->_request->getParam('email');
        
$this->_redirect("/user/mail?mail=$m");

    }                   
           }
       }
       
	$this->view->form = $form;
    
    
    
    }
    
    
     function loginAction(){
          $form  = new Application_Form_User();
          $form->removeElement("name");
          $form->removeElement("id");
          $form->getElement('email')->removeValidator('Db_NoRecordExists');
          $this->view->form = $form;
          if($this->_request->isPost()){
            if($form->isValid($this->_request->getParams())){
                $useInfo = $form->getValues();
                $email= $this->_request->getParam('email');
                $password= $this->_request->getParam('password');
                $db = Zend_Db_Table::getDefaultAdapter();
                //create the auth adapter
                $authAdapter = new Zend_Auth_Adapter_DbTable($db,'user','email', 'password' );
                //set the email and password
                $authAdapter->setIdentity($email);
                $authAdapter->setCredential(md5($password));
                //authenticate
                $result = $authAdapter->authenticate();
                    if ($result->isValid()) {
                        echo "Success";
                        //if the user is valid register his info in session
                            $auth =Zend_Auth::getInstance();
                            $storage = $auth->getStorage();
                            $storage->write($authAdapter->getResultRowObject(array('email' , 'userId' , 'userName' , 'ban' , 'admin','userImage','signature')));
                            $this->redirect("fourm/list");
                    }else{
                        echo "Not Success";
                    }
                    
            }
            
          }
          
     }
    
     
     
     function logoutAction(){
         session_destroy();
         $this->redirect("user/login");
          // $this->redirect("user/list");
     }
     
     function profileAction(){
         $id = $this->_request->getParam("id");
         if(empty($id)){
            $authorization =Zend_Auth::getInstance();
            if($authorization->hasIdentity()) { 
                $info = $authorization->getIdentity();
                //$name = $info->name;
                $id=$info->userId;
            } 
         }
         
        $user_model = new Application_Model_User();
        
        $this->view->user =  $user_model->listUserByID($id);
     }
     function sendmessageAction(){
         $receiver = $this->_request->getParam("receiver");
         $receiverName = $this->_request->getParam("receiverName");
         $authorization =Zend_Auth::getInstance();
         if($authorization->hasIdentity()) { 
            $info = $authorization->getIdentity();
            $senderName = $info->userName;
            $sender=$info->userId;
        }
        $form  = new Application_Form_Message(); 
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $message_info = $form->getValues();
               $message_model = new Application_Model_Message();
               $message_model->addForum($message_info,$sender,$receiver,$senderName,$receiverName);
               
                 
               $this->redirect("user/profile");
        
        
             }
            
       }
       
       $this->view->form = $form;
       $this->render('add');
     }
     function showmessageAction(){
         $authorization =Zend_Auth::getInstance();
            if($authorization->hasIdentity()) { 
                $info = $authorization->getIdentity();
                $name = $info->userName;
                $id=$info->userId;
            }
            $message_model = new Application_Model_Message();
        
             
         $this->view->message =  $message_model->listMessageByReceiverID($id);
            
     }
     function messageusersendAction(){
         $authorization =Zend_Auth::getInstance();
            if($authorization->hasIdentity()) { 
                $info = $authorization->getIdentity();
                $name = $info->userName;
                $id=$info->userId;
            }
            $message_model = new Application_Model_Message();
        
             
         $this->view->message =  $message_model->listMessageBySenderId($id);
            
     }
     function specificmessageAction(){
        $messageId = $this->_request->getParam("messageId");
       // echo $messageId; exit();
        $message_model = new Application_Model_Message();
        $this->view->message =  $message_model->listMessageById($messageId);
        $reply_model = new Application_Model_Reply();
        $this->view->reply =$reply_model->listRepltByMessageId($messageId);   
         
         
         
         
         $form  = new Application_Form_Reply();
           /* if($this->_request->isPost()){
               if($form->isValid($this->_request->getParams())){
                   $message_info = $form->getValues();
                   
                   $reply_model->addReply($message_info, $messageId);
                  // echo 'jj'; exit();

                   $this->redirect("user/specificmessage/messageId/$messageId");
                   

                 }

           }*/
          
       
           $this->view->form = $form;
       
     }
     function addreplyAction(){
         $messageId = $this->_request->getParam("messageId");
         $body= $this->_request->getParam("body");
         $name= $this->_request->getParam("name");
         //$form  = new Application_Form_Reply();
            
                  //echo "kk"; exit();
                   $reply_model = new Application_Model_Reply();
                   $reply_model->addReply($body, $messageId,$name);
                  // echo 'jj'; exit();

                  // $this->redirect("user/specificmessage/messageId/$messageId");
                   

                

           
     }
     
    
    
    
}

