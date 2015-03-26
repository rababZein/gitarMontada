 <?php

class Application_Form_AddUser extends Zend_Form
{

public function init()
{
$this->setMethod("post");
$postName = new Zend_Form_Element_Text("postName");
$postName->setAttrib("class", "form-control");
$postName->setLabel("Title: ");
$postName->setRequired();
//$username->addValidator(new Zend_Validate_EmailAddress());
$postName->addFilter(new Zend_Filter_StripTags);
//$username->addDecorator($decorator)

$postContain = new Zend_Form_Element_Textarea("postContain");
$postContain->setRequired()
->setLabel("Body:")
;

$forumId=1;

$postId = new Zend_Form_Element_Hidden("postId");
$submit = new Zend_Form_Element_Submit("submit");
$this->addElements(array($postId,$postName,$postContain,$submit,$forumId));

}

}