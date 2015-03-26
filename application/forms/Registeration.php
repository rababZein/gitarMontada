<?php

class Application_Form_Registeration extends Zend_Form
{

    public function init()
    {
         
     $this->setMethod("post");
        $userName = new Zend_Form_Element_Text("userName");
        $userName->addValidator(new Zend_Validate_Db_NoRecordExists(array(
        'table' => 'user',
        'field' => 'userName'
    )
));
        //$userName->setAttrib("class", "form-control");
        $userName->setLabel("Username: ");
        $userName->setRequired();
        //$username->addValidator(new Zend_Validate_EmailAddress());
        $userName->addFilter(new Zend_Filter_StripTags);
        //$username->addDecorator($decorator)
        
        $email = new Zend_Form_Element_Text("email");
         $email->setRequired()
                ->setLabel("Email:")
                 ->addValidator(new Zend_Validate_EmailAddress())
                 ->addValidator(new Zend_Validate_Db_NoRecordExists(array(
        'table' => 'user',
        'field' => 'email'
    )
));
         
         $password = new Zend_Form_Element_Password("password");
         $password->setRequired()
                 ->setLabel("Password");
         //$password->addValidator(new Zend_Validate_EmailAddress());
         
        $confirmPswd = new Zend_Form_Element_Password('confirm_pswd');
        $confirmPswd->setLabel('Confirm Password:');
       // $confirmPswd->setAttrib('size', 35);
        $confirmPswd->setRequired(true);
        $confirmPswd->addValidator('Identical', false, array('token' => 'password'));
        $confirmPswd->addErrorMessage('The passwords do not match');

         $pic=new Zend_Form_Element_File('pic');
         $pic->setLabel("Add photo:");
         $pic->setRequired();
          $pic->setDestination('/var/www/html/site/public/uploads');
          $pic->addValidator('Extension', false, 'jpg,png,gif');
          
         $gender=new Zend_Form_Element_Select("gender");
                  $gender->setLabel("Gender:");
                   $gender->addMultiOptions(array(
                    'male' => 'male',
                    'female' => 'female' 
                        ));    
                  
 $country=new Zend_Form_Element_Select("country");
                  $country->setLabel("Country:");
        $country->addMultiOptions(array(
                    'US' => 'United States',
                    'UK' => 'United Kingdom' ,
                     'Eg' => 'Egypt' 
                        ));    
         
        $signature=new Zend_Form_Element_Text("signature");
         $signature->setLabel("Please add your signature:");
         $signature->setRequired();

         
         $userId = new Zend_Form_Element_Hidden("userId");
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($userId,$userName,$email,$password,$confirmPswd,$gender,$country,$signature,$pic,$submit));
        
        
    }


}

