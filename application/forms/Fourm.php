<?php

class Application_Form_Fourm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $this->setMethod("post");
         $forumName = new Zend_Form_Element_Text("forumName");
         $forumName->setLabel("Fourm Name: ");
         $forumName->setRequired();
         
        /* $catId = new Zend_Form_Element_Text("catId");
         $catId->setLabel("Category id: ");
         $catId->setRequired();
         $catId->setDisableLoadDefaultDecorators(false);*/
         
         $catId = new Zend_Form_Element_Hidden("catId");
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($forumName,$catId,$submit));
         
    }


}

