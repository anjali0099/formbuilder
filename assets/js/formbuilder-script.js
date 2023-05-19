(function(){
    document.addEventListener('click', function(e) {
        var selected_id = e.target.id;
        var box = document.getElementById("formbuilder_content");
        const randnum = Math.floor(Math.random() * (1000 - 1)) + 1;
        
        // Get the current cursor position
        var startPos = box.selectionStart;
        var endPos = box.selectionEnd;

        if ( selected_id == 'text_field' ){
            var inserted_text = '[type="text" name="form_text_field" id="textfield_'+randnum+'" placeholder="type here something" label="type something"]';
            box.value = box.value.substring(0, startPos) + inserted_text + box.value.substring(endPos);
        }else if ( selected_id == 'email_field' ){
            var inserted_text = '[type="email" name="form_email_field" id="emailfield_'+randnum+'" placeholder="type here something" label="type something"]';
            box.value = box.value.substring(0, startPos) + inserted_text + box.value.substring(endPos);
        }else if ( selected_id == 'submit_field' ){
            var inserted_text = '[type="submit" name="form_submit_field" id="submitfield_'+randnum+'" value="type here something"]';
            box.value = box.value.substring(0, startPos) + inserted_text + box.value.substring(endPos);
        }else if ( selected_id == 'textarea_field' ){
            var inserted_text = '[type="textarea" name="form_textarea_field" id="textareafield_'+randnum+'" placeholder="type here something" label="type something"]';
            box.value = box.value.substring(0, startPos) + inserted_text + box.value.substring(endPos);
        }else if ( selected_id == 'password_field' ){
            var inserted_text = '[type="password" name="form_password_field" id="passwordfield_'+randnum+'" placeholder="type here something" label="type something"]';
            box.value = box.value.substring(0, startPos) + inserted_text + box.value.substring(endPos);
        }

        // Set the new cursor position based on the updated box.value
        var newCursorPos = startPos + inserted_text.length;

        // Reset the cursor position
        box.selectionStart = newCursorPos;
        box.selectionEnd = newCursorPos;
        
        // focus the textarea.
        box.focus();

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
