<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        $this->setMethod("post");
        $body = new Zend_Form_Element_Textarea("commentContain");
        $body->setRequired();
        $body->addFilter(new Zend_Filter_StripTags);
        
        $id = new Zend_Form_Element_Hidden("postId");
	$commentId = new Zend_Form_Element_Hidden("commentId");
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($id,$commentId,$body,$submit));
    }


}

