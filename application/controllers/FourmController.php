<?php

class FourmController extends Zend_Controller_Action
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

        $fourm_model = new Application_Model_Fourm();
        $category_model = new Application_Model_Category();
        $fourms=$fourm_model->listForum();
        
        $this->view->fourms = $fourms;
        $this->view->categories =  $category_model->listCategory();
        if(!empty($fourms['lockForum'])){
            $this->view->lock=$fourms['lockForum'];
        }
            
    }
    function lockAction(){
         $forumId = $this->_request->getParam("id");
         $lock = $this->_request->getParam("lock");
         $forum_model = new Application_Model_Fourm();
         $data=array(
             'lockForum'=>$lock,
         );
         //$user_model->admin($data, $userId);
         $forum_model->lockForum($data, $forumId);
         $this->redirect("fourm/list");
    }
    public function deletecategoryAction()
    {
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $category_model = new Application_Model_Category();
            $category_model->deleteCategory($id);
           
        }
        $this->redirect("fourm/list");
      
    } 
    public function deletefourmAction()
    {
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            
            $fourm_model = new Application_Model_Fourm();
            $fourm_model->deleteForum($id);
        }
        $this->redirect("fourm/list");
      
    } 
    public function editcategoryAction()
    {
        $id = $this->_request->getParam("id");
        $form  = new Application_Form_Category();
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $cat_info = $form->getValues();
               $cat_model = new Application_Model_Category();
               $cat_model->editCategory($cat_info,$id);
               
                 
               $this->redirect("fourm/list");
        
        
             }
            
       }
       if(!empty($id)){
            $post_model = new Application_Model_Category();
            $category = $post_model->getCategoryById($id);
            $form->populate($category[0]);
        }
       $form->getElement("catName")->setRequired(false);
       $this->view->form = $form;
       $this->render('cat');
        
    }
    public function addcategoryAction()
    {
        $id = $this->_request->getParam("id");
        $form  = new Application_Form_Category();
        //$form->getElement("catName")->setRequired(false);
        $this->view->form = $form;
        
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $cat_info = $form->getValues();
               $cat_model = new Application_Model_Category();
               $cat_model->addCategory($cat_info);
               
                 
               $this->redirect("fourm/list");
        
        
           } 
            
       }
       
       $this->render('cat');
        
    }
    public function editfourmAction()
    {
        $id = $this->_request->getParam("id");
        $form  = new Application_Form_Fourm();
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $fourm_info = $form->getValues();
               $fourm_model = new Application_Model_Fourm();
               $fourm_model->editForum($fourm_info,$id);
               
                 
               $this->redirect("fourm/list");
        
        
             }
            
       }
       if(!empty($id)){
            $fourm_model = new Application_Model_Fourm();
            $fourm= $fourm_model->getForumById($id);
            $form->populate($fourm[0]);
        }
        //$form->getElement("catId")->setRequired(false);
       //$form->removeElement("catId");
       //$form->getElement("catId")->addValidator(FALSE);
       $this->view->form = $form;
       $this->render('cat');
        
    }
    public function addfourmAction()
    {
        $id = $this->_request->getParam("id");
        $form  = new Application_Form_Fourm();
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $fourm_info = $form->getValues();
               $fourm_model = new Application_Model_Fourm();
               $fourm_model->addForum($fourm_info,$id);
               
                 
               $this->redirect("fourm/list");
        
        
             }
            
       }
       
       $this->view->form = $form;
       $this->render('cat');
        
    }
    
    


}

