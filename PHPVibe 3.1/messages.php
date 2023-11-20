<?php require_once("phpvibe.php");
$user_module = MK_RecordModuleManager::getFromType('user');
$user_message_module = MK_RecordModuleManager::getFromType('user_message');

// Check that user is logged in
if( $user->isAuthorized() )
{
	$message_folders = array(
		'inbox',
		'sent',
		'drafts'
	);
	
	// The user is composing a message with a recipient defined
	if( MK_Request::getQuery('method') == 'compose' && ( $member = MK_Request::getQuery('member') ) )
	{
		try
		{
			if( $reply_message_id = MK_Request::getQuery('reply') )
			{
				$reply_message = MK_RecordManager::getFromId($user_message_module->getId(), $reply_message_id);
				$reply_message->setType('inbox_read')->save();
			}
		}
		catch(Exception $e)
		{
			header('Location: messages.php?folder=inbox', true, 302);
			exit;
		}

		try
		{
			$recipient = MK_RecordManager::getFromId($user_module->getId(), $member);
		}
		catch(Exception $e)
		{
			header('Location: messages.php?folder=inbox', true, 302);
			exit;
		}
		
		$settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);
	
		$structure = array(
		'recipient' => array(
				'label' => 'Recipient',
				'type' => 'static',
				'value' => $recipient->getDisplayName()
			),
			'subject' => array(
				'label' => 'Subject',
				'validation' => array(
					'instance' => array()
				)
			),
			
			'message' => array(
				'label' => 'Message',
				'type' => 'rich_text',
				'attributes' => array(
					'class' => ''
				)
			),
			'submit' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Send Message'
				)
			),
			'save' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Save as Draft'
				)
			)
		);

		if( !empty($reply_message) )
		{
			$output.='<h2>Messages / Reply</h2>';
			$subject = $reply_message->getSubject();
			if( ( $is_re = strtoupper( substr($subject, 0, 3) ) ) && $is_re != 'RE:' )
			{
				$subject = 'RE: '.$subject;
			}
			$structure['subject']['value'] = $subject;
		}
		else
		{
			$output.='<h2>Messages / Compose</h2>';
		}

		$form = new MK_Form($structure, $settings);
		
		if( $form->isSuccessful() )
		{
			if( $form->getField('save')->getValue() )
			{
				$new_message = MK_RecordManager::getNewRecord($user_message_module->getId());
				$new_message
					->setSubject( $form->getField('subject')->getValue() )
					->setMessage( $form->getField('message')->getValue() )
					->setRecipient( $recipient->getId() )
					->setSender( $user->getId() )
					->setType( 'draft' )
					->save();
				$output .= '<p class="alert success">Your message has been saved. You can continue to work on drafts via your <a href="messages.php?folder=drafts">drafts folder</a>.</p>';
			}
			else
			{
				$new_message = MK_RecordManager::getNewRecord($user_message_module->getId());
				$new_message
					->setSubject( $form->getField('subject')->getValue() )
					->setMessage( $form->getField('message')->getValue() )
					->setRecipient( $recipient->getId() )
					->setSender( $user->getId() )
					->setType( 'inbox_unread' )
					->save();
	
			$output .= '<p class="alert success">Your message has been sent. You can review sent messages via your <a href="messages.php?folder=sent">sent folder</a>.</p>';
			$xmessage = "You have a new message from ".$user->getDisplayName();
			$xmessage .= "<br /> Subject: ".$form->getField('subject')->getValue();
			$xmessage .= "<br /> Summary : ".$form->getField('message')->getValue();
			$xmessage .= "<br /> ".$site_url."messages.php?folder=inbox";
			$mailer = new MK_BrandedEmail();
			$mailer
				->setSubject('New personal message')
				->setMessage($xmessage)
				->send($recipient->getEmail(), $recipient->getDisplayName());
			
			}
		}
		else
		{
			$output.=$form->render();
		}
	}
	// The user is viewing a message
	elseif( $message = MK_Request::getQuery('message') )
	{
		// Get specified message, otherwise return to inbox
		try
		{
			$message = MK_RecordManager::getFromId($user_message_module->getId(), $message);
			if( $message->getType() == 'inbox_unread' )
			{
				$message->setType('inbox_read')->save();
			}
		}
		catch(Exception $e)
		{
			header('Location: messages.php?folder=inbox', true, 302);
			exit;
		}

		// Delete message and return to inbox
		if( MK_Request::getQuery('method') == 'delete' )
		{
			$message->delete();
			header('Location: messages.php?folder=inbox', true, 302);
			exit;
		}

		$output = '';
		
		// User is resuming a draft message
		if( $message->getType() == 'draft' )
		{
			$settings = array(
				'attributes' => array(
					'class' => 'clear-fix titled standard'
				)
			);
		
			$structure = array(
				'subject' => array(
					'label' => 'Subject',
					'validation' => array(
						'instance' => array()
					),
					'value' => $message->getSubject()
				),
				'recipient' => array(
					'label' => 'Recipient',
					'type' => 'static',
					'value' => $message->renderRecipient()
				),
				'message' => array(
					'label' => 'Message',
					'type' => 'rich_text',
					'attributes' => array(
						'class' => 'input-textarea-large'
					),
					'value' => $message->getMessage()
				),
				'submit' => array(
					'type' => 'submit',
					'attributes' => array(
						'value' => 'Send Message'
					)
				),
				'save' => array(
					'type' => 'submit',
					'attributes' => array(
						'value' => 'Save as Draft'
					)
				)
			);
			
			$form = new MK_Form( $structure, $settings );
			
			
			if( $form->isSuccessful() )
			{
				$message
					->setSubject( $form->getField('subject')->getValue() )
					->setMessage( $form->getField('message')->getValue() );

				$content_title = 'Compose';
				if( $form->getField('submit')->getValue() )
				{
					$message->setType('inbox_unread');
					$output .= '<p class="alert success">Your message has been sent. You can review sent messages via your <a href="messages.php?folder=sent">sent folder</a>.</p>';
				}
				else
				{
					$output .= '<p class="alert success">Your message has been saved. You can continue to work on drafts via your <a href="messages.php?folder=drafts">drafts folder</a>.</p>';
				}
				
				$message->save();
			}
			else
			{
				$output .= '<a rel="confirm" title="Are you sure you want to delete this message?" class="button" href="messages.php?method=delete&message='.$message->getId().'">Delete</a>
						</div>';
				$content_title = '<h2>Messages / Compose</h2>';
				$output .= $form->render();
			}
		}
		// User is viewing a sent / received message 
		else
		{
			if($message->getType() == 'inbox_unread' || $message->getType() == 'inbox_read')
			{
				$output .= '<p style="width:100%; overflow:hidden; margin-bottom:10px;"><a href="messages.php?method=compose&member='.$message->getSender().'&reply='.$message->getId().'" class="button"><span class="icon icon4"></span><span class="label">Reply</span></a>';
			}
			$output .= '<a rel="confirm" title="Are you sure you want to delete this message?" href="messages.php?method=delete&message='.$message->getId().'" class="button"><span class="icon icon4"></span><span class="label">Delete</span></a></p>';
			$content_title = $message->getSubject();
			$output .= '<p class="subtitle">';
			if( $message->getSender() == $user->getId() )
			{
				$output .= '<br/>Sent to <a href="'.$site_url.'user/'.$message->getRecipient().'/'.seo_clean_url($message->renderRecipient()) .'/">'.$message->renderRecipient().'</a><br/>';
			}
			else
			{
				$output .= '<br/>Sent by <a href="'.$site_url.'user/'.$message->getSender().'/'.seo_clean_url($message->renderSender()) .'">'.$message->renderSender().'</a><br/>';
			}
			$output .= ' '.$message->renderDateSent().'</p><br/><br/>';
			$output .= '<blockquote>'.$message->getMessage().'</blockquote>';
		}
	}
	// View a message folder
	elseif( ( $folder = MK_Request::getQuery('folder'))  && in_array($folder, $message_folders) )
	{

		if($selected_messages = MK_Request::getPost('message'))
		{
			foreach($selected_messages as $message_id)
			{
				try
				{
					$message = MK_RecordManager::getFromId($user_message_module->getId(), $message_id);
				}
				catch(Exception $e)
				{
					continue;
				}

				if( MK_Request::getPost('message_delete') )
				{
					$message->delete();
				}
				else
				{
					$message->setType('inbox_read')->save();
				}
			}
		}
		
		$paginator = new MK_Paginator();
		$paginator
			->setPage( MK_Request::getQuery('page', 1) )
			->setPerPage(30);
		
		if( $folder == 'inbox' )
		{
			$user_message_module_messages_search = array(
				array('field' => 'recipient', 'value' => $user->getId()),
				array('literal' => "`type` IN('inbox_read', 'inbox_unread')")
			);
			$messages = $user_message_module->searchRecords($user_message_module_messages_search, $paginator);
		}
		else
		{
			if( $folder === 'drafts' )
			{
				$search_folder = 'draft';
			}
			else
			{
				$search_folder = $folder;
			}

			$user_message_module_messages_search = array(
				array('field' => 'sender', 'value' => $user->getId()),
				array('field' => 'type', 'value' => $search_folder),
			);
			$messages = $user_message_module->searchRecords($user_message_module_messages_search, $paginator);
		}
          $output.= ' <div class="formul"><div class="tbhead"><h5>Messages  / '.ucwords($folder).'</h5></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">';

	
		$output.= '<form action="messages.php?folder='.$folder.'" method="post" enctype="multipart/form-data">';
		$output.= '<thead><tr>';
		$output.= '<td width="4%;"><input type="checkbox" name="message_all" id="message_all" /></td>';
		$output.= '<td width="width:46%;">Subject</td>';
		$output.= '<td width="25%;">Date Sent</td>';
		$output.= '<td width="25%; ">'.($folder == 'inbox' ? 'Sender' : 'Recipient').'</td>';
		$output.= '</tr></thead>';
		$output.= '<tbody>';

		if( count($messages) > 0 )
		{
			foreach($messages as $message)
			{
				$output.= '<tr class="'.$message->getType().'">';
				$output.= '<td><input type="checkbox" value="'.$message->getId().'" name="message[]" /></td>';
				$output.= '<td><a href="messages.php?message='.$message->getId().'">'.$message->getSubject().'</a></td>';
				$output.= '<td>'.$message->renderDateSent().'</td>';
				
				if( $folder == 'inbox' )
				{
				    $u_url = $site_url.'user/'.$message->getSender().'/'.seo_clean_url($message->renderSender()) .'/';
					$output.= '<td><a href="'.$u_url.'">'.$message->renderSender().'</a></td>';
				}
				else
				{
				   $r_url = $site_url.'user/'.$message->getRecipient().'/'.seo_clean_url($message->renderRecipient()) .'/';
					$output.= '<td><a href="'.$r_url.'">'.$message->renderRecipient().'</a></td>';
				}
				$output.= '</tr>';
			}
		}
		else
		{
			$output .= '<tr><td colspan="4" class="message">There are no messages to display</td></tr>';
		}

		$output.= '</tbody>';
		$output.= '</table></div>';
		if( count($messages) > 0 )
		{
			if( $folder == 'inbox' )
			{
				$output.= '
								<br /><input type="submit" name="message_mark-as-read" value="Mark as Read" class="buttonS bBlue">
						';
			}
			$output.= '
							<input type="submit" rel="confirm" name="message_delete" title="Are you sure you want to delete these messages?" value="Delete" class="buttonS bRed">
					';
			$output.= '<br /> <br /><div class="clear-fix paginator">'.$paginator->render('messages.php?folder='.$folder.'&page={page}').'</div>';
		}
		$output.= '</form>';
	}
	else
	{
		$output .= '<a href="messages.php?folder=inbox" class="buttonS bBlue">Go to your Inbox </a>
';
		
	}
}
else
{
	$output = '<h2>Messages</h2>';
	$output .= '<p class="alert warning">Please <a href="login.php">log in</a> or <a href="register.php">register</a> to view this page!</p>';
}
$content.= $output;
if(!isset($content_title)) {$content_title = "Messages";}
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");

?>