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
		$request = $this->getRequest();
		$auth    = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()) {
			$this->_redirect('/user/loginform');
		}
		else {
			$this->_redirect('/user/userpage');
		}
	}

	public function loginformAction()
	{
		$request = $this->getRequest();
		$this->view->assign('action', $request->getBaseURL()."/user/auth");
		$this->view->assign('title', 'Login Form');
		$this->view->assign('usuario', 'Usuario');
		$this->view->assign('senha', 'Senha');
	}

	public function authAction()
	{
		$request  = $this->getRequest();
		$DB 	  = Zend_Registry::get('db');
		$auth     = Zend_Auth::getInstance();

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
			$this->view->erro = TRUE;
			$this->_redirect('/user/loginform');
		}
	}
	
	public function userpageAction()
	{
		$auth = Zend_Auth::getInstance();
		
		if(!$auth->hasIdentity()){
			$this->_redirect('/user/loginform');
		}
		
		$request   = $this->getRequest();
		$user      = $auth->getIdentity();
		$real_name = $user->nome;
		$usuario   = $user->usuario;
		$logoutUrl = $request->getBaseURL(). '/user/logout';
		
		$this->view->assign('usuario', $real_name);
		$this->view->assign('urllogout', $logoutUrl);
	}

	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->_redirect('/user');
	}
}

