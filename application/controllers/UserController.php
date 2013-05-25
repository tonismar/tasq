<?php
require_once 'Zend/Auth.php';
require_once 'Zend/Auth/Adapter/DbTable.php';

class UserController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		// action body
	}

	public function loginformAction()
	{
		$request = $this->getRequest();
		$this->view->assign('action', $request->getBaseURL()."/user/auth");
		$this->view->assign('title', 'Login Form');
		$this->view->assign('usuario', 'Usu‡rio');
		$this->view->assign('senha', 'Senha');
	}

	public function authAction()
	{
		$request  = $this->getRequest();
		$registry = Zend_Registry::getInstance();
		$auth     = Zend_Auth::getInstance();

		$DB = $registry['DB'];

		$authAdapter = new Zend_Auth_Adapter_DbTable($DB);
		$authAdapter->setTableName('owner')
		->setIdentityColumn('usuario')
		->setCredentialColumn('senha');

		$uname = $request->getParam('usuario');
		$paswd = $request->getParam('senha');
		$authAdapter->setIdentity($uname);
		$authAdapter->setCredential(md5($paswd));

		$result = $auth->authenticate($authAdapter);

		if($result->isValid()) {
			$data = $authAdapter->getResultRowObject(null,'senha');
			$auth->getStorage()->write($data);
			$this->_redirect('/owner/index');
		} else {
			$this->_redirect('/user/loginform');
		}
	}

}

