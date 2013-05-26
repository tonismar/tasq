<?php

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('/user/loginform');
		}
	}

	public function indexAction()
	{
		// action body
	}


}

