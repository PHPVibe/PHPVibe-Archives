<?php

require_once 'DefaultController.class.php';

class MK_AccountController extends MK_DefaultController{

	public function _init(){
		parent::_init();
		$this->getView()->setTemplatePath('small');

		$user = MK_Authorizer::authorize();
		if( $user->isAuthorized() && MK_Request::getParam('section') !== 'log-out' )
		{
			$this->getView()->redirect(array('controller' => 'index'));
		}
	}

	public function sectionIndex()
	{
		$this->getView()->setRender( false );
		$user = MK_Authorizer::authorize();
		if( !$user->isAuthorized() )
		{
			$this->getView()->redirect(array('controller' => 'account', 'section' => 'login'));
		}
		else
		{
			$this->getView()->redirect(array('controller' => 'index'));
		}
		
	}
	
	public function sectionLogin()
	{
		$config = MK_Config::getInstance();

		$this->getView()->getHead()->prependTitle( 'Login' );

		$form_structure = array(
			'email' => array(
				'label' => 'Email',
				'validation' => array(
					'instance' => array()
				)
			),
			'password' => array(
				'label' => 'Password',
				'validation' => array(
					'instance' => array()
				),
				'attributes' => array(
					'type' => 'password'
				)
			),
			'remember-me' => array(
				'type' => 'checkbox',
				'label' => 'Remember me on this machine'
			),
			'login' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Login'
				)
			),
			'forgot-password' => array(
				'type' => 'link',
				'text' => 'Forgot Pass',
				'attributes' => array(
					'href' => $this->getView()->uri(array('controller' => 'account', 'section' => 'forgot-password'))
				)
			)
		);

		$form_settings = array(
			'attributes' => array(
				'class' => 'standard clear-fix small'
			)
		);
		
		$form = new MK_Form($form_structure, $form_settings);

		if($form->isSuccessful())
		{
			$user = MK_Authorizer::authorizeByEmailPass(
				$form->getField('email')->getValue(),
				$form->getField('password')->getValue()
			);

			if( $user->isAuthorized() )
			{
				if( $user->getGroup()->isAdmin() )
				{
					$cookie = MK_Cookie::getInstance();
					$session = MK_Session::getInstance();
					$session->login = $user->getId();
					if( $form->getField('remember-me')->getValue() )
					{
						$cookie->set('login', $user->getId(), $config->site->user_timeout);
					}
					$this->getView()->redirect( array('controller' => 'index') );
				}
				else
				{
					$form->getField('password')->getValidator()->addError("You cannot access this section");
				}
			}
			else
			{
				$form->getField('password')->getValidator()->addError("Incorrect email / password combination");
			}
		}
		$html = $form->render();
		
		$this->view->login_form = $html;
	
	}
	
	public function sectionForgotPassword()
	{
		$config = MK_Config::getInstance();
		
		$this->getView()->getHead()->prependTitle( 'Forgot Password' );

		$html = '';
		$form_structure = array(
			'email' => array(
				'label' => 'Email',
				'validation' => array(
					'instance' => array(),
					'email' => array()
				)
			),
			'reset-password' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Reset Password'
				)
			)
		);

		$form_settings = array(
			'attributes' => array(
				'class' => 'small clear-fix standard'
			)
		);
		
		$form = new MK_Form($form_structure, $form_settings);

		if($form->isSuccessful()){
			$search_criteria = array(
				'email' => $form->getField('email')->getValue()
			);

			$users_module = MK_RecordModuleManager::getFromSlug('users');
			$user_account = $users_module->searchRecordExact( $search_criteria );

			if( $user_account ){
				$new_password = MK_Utility::getRandomPassword();
				$user_account
					->setTemporaryPassword($new_password)
					->save();

				$message = '<p>Hi, <strong>'.$user_account->getDisplayName().'</strong>!</p><p>Your new login details are below;</p><p><strong>Email:</strong> '.$user_account->getEmail().'<br /><strong>Password:</strong> '.$new_password.'</p>';
				$emailer = new MK_BrandedEmail();
				$emailer
					->setSubject('Password Recovery')
					->setMessage($message);

				if( !$emailer->send( $user_account->getEmail(), $user_account->getUsername()) )
				{
					$form->getField('email')
						->getValidator()
							->addError("There was a problem sending your login credentials. Please consult <a href=\"mailto:".$config->site->email."\">".$config->site->email."</a> stating your problem.");
				}
				else
				{
					$html .= '<p>An email containing login credentials has been sent to <strong>'.$user_account->getEmail().'</strong>!</p>';
					$html .= '<p>Upon receiving your new password you can <a href="'.$this->getView()->uri(array('controller' => 'account', 'section' => 'login')).'">login</a> and change it to something memorable.</p>';
				}
			}else{
				$form->getField('email')
					->getValidator()
						->addError("Invalid email");
			}
		}else{
			$html .= '<p>Forgotten your password? No worries, enter your email address below and we\'ll send you a new password. If you haven\'t forgotten your password the <a href="'.$this->getView()->uri(array('controller' => 'account', 'section' => 'login')).'">login</a>.</p>';
		}
		$html .= $form->render();
		
		$this->view->password_reset_form = $html;
	
	}

	public function sectionLogOut()
	{
		$session = MK_Session::getInstance();
		$cookie = MK_Cookie::getInstance();
		unset($session->login, $cookie->login);
		$this->getView()->redirect(array('controller' => 'account', 'section' => 'login'));
	}

}

?>