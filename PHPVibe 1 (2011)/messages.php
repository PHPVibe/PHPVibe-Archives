<?php
require_once("_inc.php");

$head_title = array();
$head_desc = array();
$head_title[] = 'Edit profile'; 
$head_desc[] = 'Editing my profile'; 
$head_extra = '

';
include_once("tpl/php/global_header.php");


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
				'class' => 'clear-fix standard'
			)
		);
	
		$structure = array(
			'subject' => array(
				'label' => 'Subject',
				'validation' => array(
					'instance' => array()
				)
			),
			'recipient' => array(
				'label' => 'Recipient',
				'type' => 'static',
				'value' => $recipient->getDisplayName()
			),
			'message' => array(
				'label' => 'Message',
				'type' => 'rich_text',
				'attributes' => array(
					'class' => 'input-textarea-large'
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
					'class' => 'clear-fix standard'
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

				$output .= '<h2>Messages / Compose</h2>';
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
				$output .= '<div class="clear-fix form-field form-field-link title-button"><div class="input-left"><div class="input-right">
								<a rel="confirm" title="Are you sure you want to delete this message?" href="messages.php?method=delete&message='.$message->getId().'">Delete</a>
						</div></div></div>';
				$output .= '<h2>Messages / Compose</h2>';
				$output .= $form->render();
			}
		}
		// User is viewing a sent / received message 
		else
		{
			if($message->getType() == 'inbox_unread' || $message->getType() == 'inbox_read')
			{
				$output .= '<div class="clear-fix form-field form-field-link title-button"><div class="input-left"><div class="input-right">
								<a href="messages.php?method=compose&member='.$message->getSender().'&reply='.$message->getId().'">Reply</a>
						</div></div></div>';
			}
			$output .= '<div class="clear-fix form-field form-field-link title-button"><div class="input-left"><div class="input-right">
							<a rel="confirm" title="Are you sure you want to delete this message?" href="messages.php?method=delete&message='.$message->getId().'">Delete</a>
					</div></div></div>';
			$output .= '<h2>Messages / '.$message->getSubject().'</h2>';
			$output .= '<p class="subtitle">';
			if( $message->getSender() == $user->getId() )
			{
				$output .= 'Sent to <a href="members?profile='.$message->getRecipient().'">'.$message->renderRecipient().'</a>';
			}
			else
			{
				$output .= 'Sent by <a href="user.php?id='.$message->getSender().'">'.$message->renderSender().'</a>';
			}
			$output .= ' '.$message->renderDateSent().'</p>';
			$output .= $message->getMessage();
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
			->setPerPage(10);
		
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

		$output.= '<h2>'.__("Messages").' / '.ucwords($folder).'</h2>';
		$output.= '<form class="table" action="messages.php?folder='.$folder.'" method="post" enctype="multipart/form-data"><table class="list-view list-view-messages titled" cellpadding="0" cellspacing="0" border="0">';
		$output.= '<thead><tr>';
		$output.= '<th style="width:4%;"><input type="checkbox" name="message_all" id="message_all" /></th>';
		$output.= '<th style="width:46%;">'.__("Subject").'</th>';
		$output.= '<th style="width:25%; text-align:center;">'.__("Date Sent").'</th>';
		$output.= '<th style="width:25%; text-align:center;">'.($folder == 'inbox' ? 'Sender' : 'Recipient').'</th>';
		$output.= '</tr></thead>';
		$output.= '<tbody>';

		if( count($messages) > 0 )
		{
			foreach($messages as $message)
			{
				$output.= '<tr class="'.$message->getType().'">';
				$output.= '<td><input type="checkbox" value="'.$message->getId().'" name="message[]" /></td>';
				$output.= '<td class="title"><a href="messages.php?message='.$message->getId().'">'.$message->getSubject().'</a></td>';
				$output.= '<td style="text-align:center;">'.$message->renderDateSent().'</td>';
				if( $folder == 'inbox' )
				{
					$output.= '<td style="text-align:center;"><a href="user.php?id='.$message->getSender().'">'.$message->renderSender().'</a></td>';
				}
				else
				{
					$output.= '<td style="text-align:center;"><a href="user.php?id='.$message->getRecipient().'">'.$message->renderRecipient().'</a></td>';
				}
				$output.= '</tr>';
			}
		}
		else
		{
			$output .= '<tr><td colspan="4" class="message">There are no messages to display</td></tr>';
		}

		$output.= '</tbody>';
		$output.= '</table>';
		if( count($messages) > 0 )
		{
			if( $folder == 'inbox' )
			{
				$output.= '<div class="clear-fix form-field form-field-submit"><div class="input-left"><div class="input-right">
								<input type="submit" name="message_mark-as-read" value="Mark as Read">
						</div></div></div>';
			}
			$output.= '<div class="clear-fix form-field form-field-submit"><div class="input-left"><div class="input-right">
							<input type="submit" rel="confirm" name="message_delete" title="Are you sure you want to delete these messages?" value="Delete">
					</div></div></div>';
			$output.= '<div class="clear-fix paginator">'.$paginator->render('messages.php?folder='.$folder.'&page={page}').'</div>';
		}
		$output.= '</form>';
	}
	else
	{
		$output .= '<a href="messages.php?folder=inbox" class="button blue icon mailclosed rounded">Go to your Inbox </a>
';
		
	}
}
else
{
	$output = '<h2>Messages</h2>';
	$output .= '<p class="alert warning">Please <a href="login.php">log in</a> or <a href="register.php">register</a> to view this page!</p>';
}

?>
<div class="clearfix" id="main-content">
<div class="col col12">
  <div class="col-bkg clearfix">

	<?php print $output; ?>

			
  </div>

</div>
</div>
</div>
<?php      

include_once("tpl/php/footer.php");
?>