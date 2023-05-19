<?php
wp_enqueue_script( 'formbuilder-js' );
wp_enqueue_style( 'formbuilder-css' );

if ( isset( $_GET['form_id'] ) ) {
    $form_post_id = $_GET['form_id'];
}

if ( empty( $form_post_id ) ){
    ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="" method="POST">
                        <div class="form-group">
                        <input type="hidden" name="formbuilder_editid" id="formbuilder_editid">
                            <label><h2><?php _e('Add a title', 'formbuilder') ?></h2></label>
                            <input type="text" class="form-control" name="formbuilder_title" id="formbuilder_title" required>
                        </div><hr>
                        <div class="form-group" id="input_field_div">
                            <!-- <button type="button"  class="btn btn-light field_name" name="label_field" id="label_field" >label</button> -->
                            <button type="button"  class="btn btn-light field_name" name="text_field" id="text_field" >text</button>
                            <button type="button"  class="btn btn-light field_name" name="email_field" id="email_field" >email</button>
                            <button type="button"  class="btn btn-light field_name" name="textarea_field" id="textarea_field" >textarea</button>
                            <button type="button"  class="btn btn-light field_name" name="password_field" id="password_field" >password</button>
                            <button type="button"  class="btn btn-light field_name" name="submit_field" id="submit_field" >submit</button>
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" name="formbuilder_content" id="formbuilder_content" rows="20" ></textarea>
                        </div>
                        <?php wp_nonce_field( 'formbuilder_form', 'formbuilder_nonce' ); ?>

                        <?php if (empty($form_post_id)) : ?>
                            <input type="submit" name="formbuilder_page_submit" id="formbuilder_page_submit" value="Save Changes">
                        <?php else : ?>
                            <input type="submit" name="formbuilder_update_submit" id="formbuilder_update_submit" value="Update Changes">
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>
    <?php
} else {
    $form = get_post( $form_post_id );
    $form_id = $form->ID;
    $form_title = $form->post_title;
    $form_content = $form->post_content;
    ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="" method="POST">
                        <div class="form-group">
                        <input type="hidden" name="formbuilder_editid" id="formbuilder_editid" value=" <?php echo esc_attr( $form_id ) ?> "  >
                            <label><h2><?php _e('Add a title', 'formbuilder') ?></h2></label>
                            <input type="text" class="form-control" name="formbuilder_title" id="formbuilder_title" value=" <?php echo esc_attr( $form_title ) ?> " required>
                        </div><hr>
                        <div class="form-group" id="input_field_div">
                            <!-- <button type="button"  class="btn btn-light field_name" name="label_field" id="label_field" >label</button> -->
                            <button type="button"  class="btn btn-light field_name" name="text_field" id="text_field" >text</button>
                            <button type="button"  class="btn btn-light field_name" name="email_field" id="email_field" >email</button>
                            <button type="button"  class="btn btn-light field_name" name="textarea_field" id="textarea_field" >textarea</button>
                            <button type="button"  class="btn btn-light field_name" name="password_field" id="password_field" >password</button>
                            <button type="button"  class="btn btn-light field_name" name="submit_field" id="submit_field" >submit</button>
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" name="formbuilder_content" id="formbuilder_content" rows="20" > <?php echo esc_textarea( $form_content ) ?> </textarea>
                        </div>
                        <?php wp_nonce_field( 'formbuilder_form', 'formbuilder_nonce' ); ?>

                        <?php if (empty($form_post_id)) : ?>
                            <input type="submit" name="formbuilder_page_submit" id="formbuilder_page_submit" value="Save Changes">
                        <?php else : ?>
                            <input type="submit" name="formbuilder_update_submit" id="formbuilder_update_submit" value="Update Changes">
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    <?php
    
}
