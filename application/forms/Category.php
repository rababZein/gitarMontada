<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $this->setMethod("post");
         $catName = new Zend_Form_Element_Text("catName");
         $catName->setLabel("Category Name: ");
         $catName->setRequired();
        // $catId = new Zend_Form_Element_Hidden("catId");
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($catName,$submit));
         //$this->redirect("fourm/list");
    }


}

