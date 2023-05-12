(function(){
    document.addEventListener('click', function(e) {
        var selected_id = e.target.id;
        var box = document.getElementById("formbuilder_content");
        const randnum = Math.floor(Math.random() * (1000 - 1)) + 1;

        if ( selected_id == 'text_field' ){
            box.value += '[type="text" name="form_text_field" id="textfield_'+randnum+'"]';
            box.value += '{br}';
        }else if( selected_id == 'email_field' ){
            box.value += '[type="email" name="form_email_field" id="emailfield_'+randnum+'"]';
            box.value += '{br}';
        }
    }, false);
})();
