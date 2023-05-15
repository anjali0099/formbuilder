(function(){
    document.addEventListener('click', function(e) {
        var selected_id = e.target.id;
        var box = document.getElementById("formbuilder_content");
        const randnum = Math.floor(Math.random() * (1000 - 1)) + 1;

        if ( selected_id == 'text_field' ){
            box.value += '[type="text" name="form_text_field" id="textfield_'+randnum+'"]';
        }else if( selected_id == 'email_field' ){
            box.value += '[type="email" name="form_email_field" id="emailfield_'+randnum+'"]';
        }else if( selected_id == 'submit_field' ){
            box.value += '[type="submit" name="form_submit_field" id="submitfield_'+randnum+'"]';
        }else if( selected_id == 'textarea_field' ){
            box.value += '[type="textarea" name="form_textarea_field" id="textareafield_'+randnum+'"]';
        }else if( selected_id == 'password_field' ){
            box.value += '[type="password" name="form_password_field" id="passwordfield_'+randnum+'"]';
        }
    }, false);
})();
