<?php

####################################################################################

    /* -- Some UI Settings, edit as you wish -- */
    //how to format dates
    $DATEFORMAT = '%c'; //see http://at2.php.net/manual/en/function.strftime.php for other possibilities

    //what to hide comments under SHOW MORE
    $CCOUNT     = 2;

    //Name Input Field Visible?
    $SHOWNAME   = false;

    //eMail Input Field Visible?
    $SHOWMAIL   = false;
    
    //allow "liking" of comments?
    $ALLOWLIKE  = true;

    //enable tags (list tags you wish to enable eg 'IMG,A,B,SPAN')?
    $ENABLETAGS = 'img,a,b,strong';
    
    
    
    //comment moderator email
    $MODMAIL    = 'moderator@domain.com';
    
    //moderate comments? (will also send them via email)
    $MODCOM     = false;
    
    //email all new comments to the email address above?
    $MAILCOM    = false;

    //the address from which new comments are sent from
    $MAILFROM   = 'comments@domain.com';





    /* -- Language Settings -- */
    $lang['view']           = 'View all';
    $lang['view2']          = 'comments';
    $lang['name']           = 'Name';
    $lang['enterName']      = 'Enter your name';
    $lang['mail']           = 'eMail';
    $lang['enterMail']      = 'Enter youe eMail address';
    $lang['enterComment']   = 'Add a Comment';
    $lang['comment']        = 'Comment';
    $lang['hide']           = 'Hide all';
    
    $lang['ilike']          = 'I like this comment';
    $lang['youlikethis']    = 'You like this';
    $lang['youandone']      = 'You and 1 other person like this';
    $lang['youandxx']       = 'You and XXX other people like this';
    $lang['onelikes']       = '1 person likes this';
    $lang['xxlikethis']     = 'XXX people like this';
    
    $lang['cid']            = 'The comment ID';
    $lang['wassuc']         = 'was successfully';
    $lang['deleted']        = 'deleted';
    $lang['moderated']      = 'moderated';














    ####################################################################################################
    /* ----- DO NOT EDIT BELOW THIS LINE ----- */
    //open the actual DB connection
    try{
        $db = new PDO('mysql:host='.$config->db->host.';dbname='.$config->db->name,$config->db->username,$config->db->password,array());
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $db->exec("SET NAMES 'utf8'");
    }catch (exception $e){
        header('Content-type: application/x-json');
        echo json_encode(array('dberror' => $e->getMessage()));
        exit;
    }

  
                