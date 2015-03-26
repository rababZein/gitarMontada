<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
       /* $username = new Zend_Form_Element_Text("userName");
        $username->setAttrib("class", "form-control");
        $username->setLabel("Username: ");
        $username->setRequired();*/
        //$username->addValidator(new Zend_Validate_EmailAddress());
        //$username->addFilter(new Zend_Filter_StripTags);
        //$username->addDecorator($decorator)
        
        $email = new Zend_Form_Element_Text("email");
         $email->setRequired()
                ->setLabel("Email:")
                 ->addValidator(new Zend_Validate_EmailAddress())
                 ->addValidator(new Zend_Validate_Db_NoRecordExists(array(
        'table' => 'student',
        'field' => 'email'
    )
));
         
         $password = new Zend_Form_Element_Password("password");
         $password->setRequired()
                 ->setLabel("Password");
         
         $id = new Zend_Form_Element_Hidden("id");
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($id,$email,$password,$submit));
        
        
    }


}


