<?php

class Application_Form_Message extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $this->setMethod("post");
         $subject = new Zend_Form_Element_Text("subject");
         $subject->setLabel("subject : ");
         $subject->setRequired();
         
         $body = new Zend_Form_Element_Textarea("body");
         $body->setLabel("body : ");
         $body->setRequired();
         
        
         
        // $catId = new Zend_Form_Element_Hidden("catId");
         $submit = new Zend_Form_Element_Submit("send");
         $this->addElements(array($subject,$body,$submit));
    }


}

