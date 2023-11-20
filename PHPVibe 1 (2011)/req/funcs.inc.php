<?php
    /***
     *  Encode MailAddresses against Spam Bots
     ***/
    function jsEncode($address, $text){
        return '<a href="../../user.php?id='.$address.'">'. $text.'</a>';
    }

    /***
     *  Get rid of all HTML in the input
     ***/
    function cleanInput($str){
        return nl2br(htmlspecialchars(strip_tags(trim(urldecode($str)))));
    }

    /***
     *  Prepare a Gravatar String
     ***/
    function gravatar($email, $absolute=true){
        if($absolute){
            $dir = str_replace('/commentanything/ajax/loadComments.php','/',$_SERVER['REQUEST_URI']);
            $dir = str_replace('/commentanything/ajax/addComment.php','/',$dir);
            return md5( strtolower( trim( $email ) ) ).'?s=32&d='.urlencode('http://'.$_SERVER['HTTP_HOST'].$dir.'commentanything/css/images/default.gif');
        }

        $dirs = explode('/',$_SERVER['REQUEST_URI']);
        array_pop($dirs);
        $dir  = implode('/',$dirs);
        return md5( strtolower( trim( $email ) ) ).'?s=32&d='.urlencode('http://'.$_SERVER['HTTP_HOST'].$dir.'/commentanything/css/images/default.gif');
    }

    /***
     *  Make links clickable
     ***/
    function twitterify($ret) {
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
        $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\" rel=\"nofollow\">@\\1</a>", $ret);
        $ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\" rel=\"nofollow\">#\\1</a>", $ret);
        return $ret;
    }
    
    /***
     *  Comment Like Text
     ***/
    function commentLikeText($total, $me=true){
        global $lang;
        
        if($me){
            if($total == 0){
                return $lang['youlikethis'];
            }elseif($total == 1){
                return $lang['youandone'];
            }else{
                return str_replace('XXX',$total,$lang['youandxx']);
            }       
        }else{
            if($total == 1){
                return $lang['onelikes'];
            }else{
                return str_replace('XXX',$total,$lang['xxlikethis']);
            }
        }
    }