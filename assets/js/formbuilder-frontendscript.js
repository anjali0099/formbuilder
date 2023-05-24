(function(){
    $( 'form' ).on( 'submit', function (e) {
        e.preventDefault();
        var datatype = $('form').serialize();
        $.ajax({
            url: custom_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'new_form_submit',
                data: datatype,
            },
            success: function(json) {
                console.log(json);
                if( json.success )
				    alert( json.data );
                else
                    alert( 'Error!! ' + json.data );     
                location.reload(); 
            }
        });
    });
})()

