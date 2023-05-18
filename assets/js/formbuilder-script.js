(function(){
    document.addEventListener('click', function(e) {
        var selected_id = e.target.id;
        var box = document.getElementById("formbuilder_content");
        const randnum = Math.floor(Math.random() * (1000 - 1)) + 1;

        if ( selected_id == 'text_field' ){
            box.value += '[type="text" name="form_text_field" id="textfield_'+randnum+'" placeholder="type here something"]';
        }else if ( selected_id == 'email_field' ){
            box.value += '[type="email" name="form_email_field" id="emailfield_'+randnum+'" placeholder="type here something"]';
        }else if ( selected_id == 'submit_field' ){
            box.value += '[type="submit" name="form_submit_field" id="submitfield_'+randnum+'" value="type here something"]';
        }else if ( selected_id == 'textarea_field' ){
            box.value += '[type="textarea" name="form_textarea_field" id="textareafield_'+randnum+'" placeholder="type here something"]';
        }else if ( selected_id == 'password_field' ){
            box.value += '[type="password" name="form_password_field" id="passwordfield_'+randnum+'" placeholder="type here something"]';
        }else if ( selected_id == 'label_field' ){
            box.value += '[type="label" name="type something here" id="labelfield_'+randnum+'"]';
        }
    }, false);
})();

// function delete_formbuilder_post(id) {
// 	debugger;
// 	if (confirm("Are you sure you want to delete this post?")) {
// 		$.ajax({
// 			type: "POST",
// 			url: 'form-builder/formbuilder_delete_post',
// 			data: { 'id': id },
// 			success: function (data) {
// 				// console.log(data);
// 				// alert(data);
// 				// location.reload(true);
// 			}
// 		});
//         debugger;
// 	}
// }
