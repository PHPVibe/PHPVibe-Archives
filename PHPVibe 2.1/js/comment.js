/***
 *  When a user is typing a comment the size of the textarea is extended
 ***/
function adjustHeight(textarea){
    var dif = textarea.scrollHeight - textarea.clientHeight;
    if (dif){
        if (isNaN(parseInt(textarea.style.height))){
            textarea.style.height = textarea.scrollHeight + "px"
        }else{
            textarea.style.height = parseInt(textarea.style.height) + dif + "px"
        }
    }
}


/***
 *  Creates placeholders for text in the field
 ***/
function inputPlaceholder (input, color) {

    if (!input) return null;

    /**
    * Webkit browsers already implemented placeholder attribute.
    * This function useless for them.
    */
    if (input.placeholder && 'placeholder' in document.createElement(input.tagName)) return input;

    var placeholder_color = color || '#AAA';
    var default_color = input.style.color;
    var placeholder = input.getAttribute('placeholder');

    if (input.value === '' || input.value == placeholder) {
        input.value = placeholder;
        input.style.color = placeholder_color;
    }

    var add_event = /*@cc_on'attachEvent'||@*/'addEventListener';

    input[add_event](/*@cc_on'on'+@*/'focus', function(){
        input.style.color = default_color;
        if (input.value == placeholder) {
            input.value = '';
        }
    }, false);

    input[add_event](/*@cc_on'on'+@*/'blur', function(){
        if (input.value === '') {
            input.value = placeholder;
            input.style.color = placeholder_color;
        } else {
            input.style.color = default_color;
        }
    }, false);

    input.form && input.form[add_event](/*@cc_on'on'+@*/'submit', function(){
        if (input.value == placeholder) {
            input.value = '';
        }
    }, false);

    return input;
}


/***
 *  Heart and soul of the application -- it ADDS the comment to the database
 ***/
function addEMComment(oid){
    if($('#addEmComment_'+oid).val() && $('#addEmComment_'+oid).val() != $('#addEmComment_'+oid).attr('placeholder')){
    
        //mark comment box as inactive
        $('#addEmComment_'+oid).attr('disabled','true');
        $('#addEmMail_'+oid).attr('disabled','true');
        $('#addEmName_'+oid).attr('disabled','true');
        $('#emAddButton_'+oid).attr('disabled','true');

        if($('#addEmName_'+oid).val() == $('#addEmName_'+oid).attr('placeholder')){
            document.getElementById('addEmName_'+oid).value = '';
        }

        if($('#addEmMail_'+oid).val() == $('#addEmMail_'+oid).attr('placeholder')){
            document.getElementById('addEmMail_'+oid).value = '';
        }
        
        $.post(
            'components/addComment.php', { 
                comment:      encodeURIComponent($('#addEmComment_'+oid).val()),
                object_id:    oid,
                sender_name:  encodeURIComponent($('#addEmName_'+oid).val()),
                sender_id:  encodeURIComponent($('#addEmMail_'+oid).val())
            },
            
            function(data){
                $('#emContent_'+oid).append('<div class="emComment" id="comment_'+data.id+'" style="display: none;"><div class="emCommentImage">'+data.image+'</div><div class="emCommentText">'+data.text+'</div><div class="emCommentInto">'+data.date+'<div class="emCommentLike"><span id="iLikeThis_'+data.id+'"><em>'+data.like+'</em></span></div></div></div>');
                $('#comment_'+data.id).slideDown();
                
                if($('#total_em_comments_'+oid)){
                    $('#total_em_comments_'+oid).replaceWith(data.total);
                }
                resetFields(oid);
            }, "json");            
            
    }else{
        $('#addEmComment_'+oid).focus();
    }

    return false;
}



/***
 *  This loads all the comments to the current object id from the database
 ***/
function loadComments(){
    return;
    if($('emComments') && $('emComments').getAttribute('object')){
        if(!$('emComments').hasClassName('ignorejsloader')){

            new Ajax.Request('components/loadComments.php', {
                  method: 'post',
                  parameters: {
                      object_id: $('emComments').getAttribute('object')
                  },

                onSuccess: function(reply) {
                    var data = reply.responseText.evalJSON(true);

                    if(data.dberror){
                        alert("DATABASE ERROR:\n"+data.dberror);
                        return;
                    }

                    $('emComments').innerHTML = data.html;
                    Event.observe('addEmComment', 'keyup', function(){
                        adjustHeight($('addEmComment'));
                    });
                    resetFields();
                }
            });

        }else{
            Event.observe('addEmComment', 'keyup', function(){
                adjustHeight($('addEmComment'));
            });
            resetFields();
        }
    }
}

function _JQloadComments(){
    return;
    if($('#emComments') && $('#emComments').attr('object')){
        if(!$('#emComments').hasClass('ignorejsloader')){
        
            $.post(
                'components/loadComments.php', { 
                    object_id: $('#emComments').attr('object')
                },
                
                function(data){
                
                    if(data.dberror){
                        alert("DATABASE ERROR:\n"+data.dberror);
                        return;
                    }

                    document.getElementById('emComments').innerHTML = data.html;

                    $('#addEmComment').bind('keyup', function(){                        
                        adjustHeight(document.getElementById('addEmComment'));                    
                    });
                    
                    resetFields();
                }, "json");  
            
        }else{
            $('#addEmComment').bind('keyup', function(){                        
                adjustHeight(document.getElementById('addEmComment'));                    
            });            
            resetFields();
        }
    }
}

/***
 *  Clear Add Comment Fields
 ***/
function resetFields(oid){
    var obj = document.getElementById('addEmComment_'+oid);
    if(obj){
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        obj.style.height = '29px';
        inputPlaceholder(document.getElementById('addEmComment_'+oid));
    }

    obj = document.getElementById('addEmName_'+oid);
    if(obj){
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        inputPlaceholder(document.getElementById('addEmName_'+oid));
    }

    obj = document.getElementById('addEmMail_'+oid);
    if(obj){
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        inputPlaceholder(document.getElementById('addEmMail_'+oid));
    }

    obj = document.getElementById('emAddButton_'+oid);    
    if(obj){
        obj.disabled = false;
    }
}


/***
 *
 ***/
function iLikeThisComment(cid){
    $.post(
            'components/likeComment.php', { 
                comment_id:   cid
            },
            
            function(data){
                $('#iLikeThis_'+cid).html('<em>'+data.text+'</em>');
            }, "json"); 
}


/***
 *  When there are more than 2 comments they are hidden and can be opened by this function
 ***/
function viewAllComments(obj){
    $('.emComment_'+obj).fadeIn();
    $('#emShowAllComments_'+obj).slideUp();
    $('#emHideAllComments_'+obj).fadeIn();
}

/***
 *  When there are more than 2 comments they are hidden and can be opened by this function
 ***/
function hideAllComments(obj){
    $('.emHiddenComment_'+obj).fadeOut();
    $('#emShowAllComments_'+obj).fadeIn();
    $('#emHideAllComments_'+obj).slideUp();
}




$(document).ready(function(){
    //resetFields();
});
