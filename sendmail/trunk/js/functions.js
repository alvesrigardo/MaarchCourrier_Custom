var addEmailAdress = function (idField, idList, theUrlToListScript, paramNameSrv, minCharsSrv) {
     new Ajax.Autocompleter(
         idField,
         idList,
         theUrlToListScript,
         {
             paramName: paramNameSrv,
             minChars: minCharsSrv,
             tokens: ',',
             afterUpdateElement:extractEmailAdress
         });
 };
 
function showEmailForm(path, width, height) {
    
    if(typeof(width)==='undefined'){
        var width = '820px';
    }
    
    if(typeof(height)==='undefined'){
        var height = '545px';
    }  
    
    new Ajax.Request(path,
    {
        method:'post',
        parameters: { url : path
                    },  
        onSuccess: function(answer) {
            eval("response = "+answer.responseText);
           
            if(response.status == 0){
             
                var modal_content = convertToTextVisibleNewLine(response.content);
                createModal(modal_content, 'form_email', height, width); 
            } else {
                window.top.$('main_error').innerHTML = response.error;
            }
        }
    });
}

function updateAdress(path, action, adress, target, array_index, email_format_text_error) {
    
    if (validateEmail(adress) === true) {
        
        new Ajax.Request(path,
        {
            method:'post',
            parameters: { url : path,
                          'for': action,
                          email: adress,
                          field: target,
                          index: array_index
                        },
            onLoading: function(answer) {
                $('loading_' + target).style.display='inline';
            },
            onSuccess: function(answer) {
                eval("response = "+answer.responseText);
                if(response.status == 0){
                    $(target).innerHTML = response.content;
                    if (action == 'add') {$('email').value = '';}
                } else {
                    alert(response.error);
                    eval(response.exec_js);
                }
                // $('loading_' + target).style.display='none';
            }
        });
    } else {
        if(typeof(email_format_text_error) == 'undefined'){
            email_format_text_error = 'Email format is not available!';
        }
        alert(email_format_text_error);
    }
}

function validEmailForm (path, form_id) {
    // var bodyContent = getBodyConten();

    new Ajax.Request(path,
    {
        asynchronous:false,
        method:'post',
        parameters: Form.serialize(form_id),   
        encoding: 'UTF-8',                       
        onSuccess: function(answer){
            eval("response = "+answer.responseText);
            if(response.status == 0){
                eval(response.exec_js);
                window.parent.destroyModal('form_email'); 
            } else {
                alert(response.error);
                eval(response.exec_js);
            }
        }
    });
}

function extractEmailAdress(field, item) {
    var fullAdress = item.innerHTML;
    var email = fullAdress.match(/\(([^)]+)\)/)[1];
    field.value = email;
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
 
function switchMode(action) {
    var div = document.getElementById(mode+"_mode");
    div.style.display = "block";
    if(action == "show") {
        div.style.display = "none"; // Hide the current div.
        mode = (mode === 'html')? 'raw' : 'html';      // switch the mode
        document.getElementById("is_html").value = (mode === 'html')? 'Y' : 'N'; //Update the hidden field
        document.getElementById(mode+"_mode").style.display = "block"; // Show the other div.
    }
}

var MyAjax = { };
MyAjax.Autocompleter = Class.create(Ajax.Autocompleter, {
    updateChoices: function(choices) {
        if(!this.changed && this.hasFocus) {
            this.update.innerHTML = choices;
            Element.cleanWhitespace(this.update);
            Element.cleanWhitespace(this.update.down());
            if(this.update.firstChild && this.update.down().childNodes) {
                this.entryCount = this.update.down().childNodes.length;
                for (var i = 0; i < this.entryCount; i++) {
                    var entry = this.getEntry(i);
                    entry.autocompleteIndex = i;
                    this.addObservers(entry);
                }
            } else {
                this.entryCount = 0;
            }
            this.stopIndicator();
            this.index = -1;

            if(this.entryCount==1 && this.options.autoSelect) {
                this.selectEntry();
                this.hide();
            } else {
                this.render();
            }
        }
    }
});