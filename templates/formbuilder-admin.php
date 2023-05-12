<?php
wp_enqueue_script( 'formbuilder-js' );
wp_enqueue_style( 'formbuilder-css' );
?>
<div class="container">
    <div class="row">
        <div class="col">
            <form action="" method="POST">
                <div class="form-group">
                    <label><h2><?php _e('Add a title', 'formbuilder') ?></h2></label>
                    <input type="text" class="form-control" name="formbuilder_title" id="formbuilder_title" required>
                </div><hr>
                <div class="form-group" id="input_field_div">
                    <button type="button"  class="btn btn-light field_name" name="text_field" id="text_field" >text</button>
                    <button type="button"  class="btn btn-light field_name" name="email_field" id="email_field" >email</button>
                </div>
                <div class="form-group">
                    <textarea  class="form-control" name="formbuilder_content" id="formbuilder_content" rows="20" ></textarea>
                </div>
                <?php wp_nonce_field( 'formbuilder_form', 'formbuilder_nonce' ); ?>

                <input type="submit" name="formbuilder_page_submit" id="formbuilder_page_submit" value="Save Changes">
            </form>
        </div>
    </div>
</div>