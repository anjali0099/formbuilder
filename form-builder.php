<?php
/**
 * Plugin Name:     Form Builder
 * Plugin URI:      https://myblog.com/formbuilder
 * Description:     Create your own form design and enjoy!!
 * Version:         1.0.0
 * Author:          Anjali Shrestha
 * TextDomain:      formbuilder
 */

/**
 * Resigter 'formbuilder' Post Type.
 * 
 * @since 1.0.0
 * @return void
 */
function formbuilder_post_type(){
    $labels = array(
        'name' => __( 'Form Builder', 'formbuilder' ),
        'singular_name' => __( 'Form Builder', 'formbuider' ),
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'has_archive' => false,
        'capability_type' => 'page',
        'capabilities' => array(
            'add_posts' => 'add_forms',
        ),
    );
    register_post_type( 'formbuilder', $args );
}
add_action( 'init', 'formbuilder_post_type' );

/**
 * Add new menu/submenu page.
 * Admin Form Builder for listing forms.
 * Add New Forms for adding new forms.
 */
function formbuilder_page(){
    add_menu_page(
        __( 'Admin Form Builder', 'formbuilder' ),// the page title
        __('Form Builder', 'formbuilder'),//menu title
        'edit_posts',//capability 
        'admin-form-builder',//menu slug/handle this is what you need!!!
        'formbuilder_admincallback',//callback function
        'dashicons-forms', //icon
        10, //position
    );
    add_submenu_page(
        'admin-form-builder', //parent menu slug
        __( 'Admin Form', 'formbuilder' ), //page title
        __( 'Add New Forms', 'formbuilder' ), //menu title
        'edit_posts', //capability,
        'admin-form',//menu slug
        'formbuilder_callback_menu' //callback function
    );
    add_submenu_page(
        'admin-form-builder', //parent menu slug
        __( 'Form Data View', 'formbuilder' ), //page title
        __( 'Submission View', 'formbuilder' ), //menu title
        'edit_posts', //capability,
        'form-data-view',//menu slug
        'formbuilder_view_callback' //callback function
    );
}
add_action('admin_menu', 'formbuilder_page');

/**
 * Callback function for formbuilder_page add_menu_page
 * formbuilder_admincallback
 */
function formbuilder_admincallback(){
    include('templates/formbuilder-view.php');
}

/**
 * Shortcode for the post
 * 
 * @param array $formbuilder_view Shortcode value from table.
 * @return void
 */
function formbuilder_view_shortcode( $atts ){
    wp_enqueue_style( 'formbuilder-bootstrap' );
    wp_enqueue_script( 'formbuilder-js' );

    $shortcode_args = shortcode_atts(
        array(
            'id' => '',
        ), $atts
    );
    $args = array(
        'post_type' => 'formbuilder',
        'posts_per_page' => '1',
        'post_status' => 'publish',
        'p' => $shortcode_args['id'],
    );

    $query = new WP_Query( $args );
    ob_start();
    ?>
    <div class="card">
        <div class="card-body">
            
    <?php

    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            $form_id = get_the_ID();
            date_default_timezone_set('Asia/Kathmandu');
            $currentDate = date('Y-m-d h:i:s');
            ?>
                <h4 class="card-title"><?php _e(  the_title(), 'formbuilder' ) ?></h4><hr>
                <form action="" method="POST">
                    <input type="hidden" name="formbuilder_formid" id="formbuilder_formid" value=<?php echo $form_id ?>>
                    <input type="hidden" name="formbuilder" id="formbuilder_newform_id" value="formbuilder">
                    <input type="hidden" name="formbuilder_submission_date" id="formbuilder_submission_date" value= "<?php echo $currentDate; ?>" >
            <?php
            $content = get_the_content();
            $explode_data = explode( ']', $content );

            $pattern = '/(\w+)\s*=\s*("[^"]*")/'; 
            foreach ($explode_data as $element) {
                preg_match_all($pattern, $element, $matches, PREG_SET_ORDER);
                if (!empty($matches)) {
                    $attribute_value = [];
                    foreach ($matches as $match) {
                        $key = $match[1];
                        $value = isset($match[2]) ? trim($match[2], '"') : '';
                        $attribute_value[$key] = $value;
                    }
                    $type = isset( $attribute_value['type'] ) ? $attribute_value['type'] : '';
                    $name = isset( $attribute_value['name'] ) ? $attribute_value['name'] : '';
                    $id = isset( $attribute_value['id'] ) ? $attribute_value['id'] : '';
                    $placeholder = isset( $attribute_value['placeholder'] ) ? $attribute_value['placeholder'] : '';
                    $label = isset( $attribute_value['label'] ) ? $attribute_value['label'] : $placeholder;
                    $value = isset( $attribute_value['value'] ) ? $attribute_value['value'] : $type;
                    $for = $id;
                    
                    switch ( $type ) {
                        case 'textarea':
                            echo '<label for="' . $for . '">'.$label.'</label>';
                            echo '<textarea class="form-control" name="' . $name . '" id="' . $id . '" placeholder="'. $placeholder .'" rows="3"></textarea>';
                            echo '<br>';
                            break;
                        case 'submit':
                            echo '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . $value . '"  class="btn btn-sm btn-outline-primary" > ';
                            echo '<br>';
                            break;
                        default:
                            echo '<label for="' . $for . '">'.$label.'</label>';
                            echo '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" placeholder="'. $placeholder .'" class="form-control" >';
                            echo '<br>';
                    }
                }
            }
        }
    }
    wp_reset_postdata();
    ?>
            <?php wp_nonce_field( 'formbuilder_newform', 'formbuilder_newnonce' ); ?>
            </form>
        </div>
    </div>
    <?php
    $result = ob_get_clean();
    return $result;
}
add_shortcode( 'formbuilder-shortcode', 'formbuilder_view_shortcode' );

/**
 * Form Submit
 */
function formbuilder_newform_submit(){
    if( isset( $_POST['action'] ) == 'new_form_submit' ){
        $data = $_POST['data'];

        // Parse the query string
        parse_str( $data, $params );
        if( isset( $params['formbuilder'] ) != 'formbuilder' ){
            return;
        }
        if( ! wp_verify_nonce( wp_unslash( $params['formbuilder_newnonce'] ), 'formbuilder_newform' ) ) {
            return;
        };

        // Get form ID.
        $form_id = $params['formbuilder_formid'];

        $omit_postdata_firstkey = array_slice( $params, 1 );
        $omit_postdata_lastkeys = array_slice( $omit_postdata_firstkey, 0, -2 );

        $errors = array();
        foreach ($omit_postdata_lastkeys as $key => $value) {
            # code...
            if(empty($value)){
                wp_send_json_error( 'Some fields are empty .' );
                return;
            }
        }

        $postdata = $params;

        // Get old post meta.
        $existing_postmeta = get_post_meta( $form_id, 'formbuilder_postmeta', true );

        if ( ! empty( $existing_postmeta ) ){
            $new_values = $existing_postmeta;
            $new_values[] = $postdata;
        }else{
            $new_values = array($postdata);
        }

        $save_formbuilder_newform_data = update_post_meta( $form_id, 'formbuilder_postmeta', $new_values );

        if ( $save_formbuilder_newform_data ) {
            $omit_first_key = array_slice( $postdata, 1 );
            $omit_last_keys = array_slice( $omit_first_key, 0, -2 );

            // Mail contents.
            $to = 'anjali.codewing@gmail.com';
            $subject = 'Form Values';
            
            $table = '<table class="table table-bordered">';
            foreach ($omit_last_keys as $key => $value) {
                $table .= '<tr><td>' . $key  . ':'.'</td><td>' . $value . '</td></tr>';
            }
            $table .= '</table>';

            $message = $table;

            $headers = array('Content-Type: text/html; charset=UTF-8');

            // Send mail.
            wp_mail( $to, $subject, $message, $headers );

            wp_send_json_success( 'Form submission successful' );
        } else {
            wp_send_json_error( 'Form submission failed' );
        }
    }

    wp_die();
}
add_action( 'wp_ajax_new_form_submit', 'formbuilder_newform_submit' );

/**
 * Callback function for 
 * formbuilder_view_callback.
 * 
 * @return void.
 */
function formbuilder_view_callback() {
    wp_enqueue_style('formbuilder-css');
    $args = array(
        'post_type' => 'formbuilder',
        'post_status' => 'publish',
        'order' => 'ASC',
    );

    $query = new WP_Query( $args );
    ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2> <?php _e('Submitted Values', 'formbuilder') ?> </h2><hr>
                    <table class="table table-bordered">
                        <tr>
                            <th >
                                <?php _e('Form ID', 'formbuilder') ?>
                            </th>
                            <th >
                                <?php _e('Form Values', 'formbuilder') ?>
                            </th>
                            <th >
                                <?php _e('Submission Date', 'formbuilder') ?>
                            </th>
                        </tr>
                        <?php
                            if( $query->have_posts() ){
                                while ( $query->have_posts() ){
                                    $query->the_post();
                                    
                                    $get_postmeta_values = get_post_meta( get_the_ID(), 'formbuilder_postmeta', true );

                                    if ( isset( $get_postmeta_values ) && ! empty( $get_postmeta_values ) ){
                                        foreach ( $get_postmeta_values as $key => $value ) {
                                            $array_value = $value;
                                            $omit_first_key = array_slice( $array_value, 1 );
                                            $omit_last_keys = array_slice( $omit_first_key, 0, -2 );
                                            ?>
                                                <tr>
                                                    <td > <?php _e( isset( $omit_last_keys['formbuilder_formid'] ) ? $omit_last_keys['formbuilder_formid'] : '' ) ?> </td>
                                                    <td>
                                                        <?php
                                                            $array_key_values = array_slice( $omit_last_keys, 3 );
                                                            foreach ($array_key_values as $key => $value) {
                                                                echo esc_attr($key . ': ' . $value);
                                                                echo '<br>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td > 
                                                        <?php _e( isset( $omit_last_keys['formbuilder_submission_date'] ) ? $omit_last_keys['formbuilder_submission_date'] : '' ); ?> 
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            wp_reset_postdata();
                        ?>
                    </table>
                </div>
            </div>
        </div>
    <?php
}

/**
 * Callback function for formbuilder_page add_submenu_page
 * 
 * formbuilder_callback_menu
 */
function formbuilder_callback_menu(){
    include('templates/formbuilder-admin.php');
}

/**
 * Form submit 
 * Update Form
 * 
 * @param array $post_id Post ID
 * @return void
 */ 
function formbuilder_formsubmit( $post_id ){
    if( isset( $_POST['formbuilder_page_submit'] ) ){
        if( ! wp_verify_nonce( wp_unslash( $_POST['formbuilder_nonce'] ), 'formbuilder_form' ) ) {
            return;
        };
        $postdata = [];
        $postdata['post_title'] = sanitize_text_field( wp_unslash( $_POST['formbuilder_title'] ) );
        $postdata['post_content'] = $_POST['formbuilder_content'];
        $postdata['post_status'] = 'publish';
        $postdata['post_type'] = 'formbuilder';

        $save_formbuilder_page_submit = wp_insert_post( $postdata );

    }elseif( isset( $_POST['formbuilder_update_submit'] ) ){
        if( ! wp_verify_nonce( wp_unslash( $_POST['formbuilder_nonce'] ), 'formbuilder_form' ) ) {
            return;
        };
        $postdata = [];
        $postdata['ID'] = $_POST['formbuilder_editid'];
        $postdata['post_title'] = sanitize_text_field( wp_unslash( $_POST['formbuilder_title'] ) );
        $postdata['post_content'] = $_POST['formbuilder_content'];
        $postdata['post_status'] = 'publish';
        $postdata['post_type'] = 'formbuilder';

        $update_formbuilder_page_submit = wp_update_post( $postdata );
    }
}
add_action( 'admin_init', 'formbuilder_formsubmit' );

/**
 * Deletes post of 'Formbuilder' post_type from DB.
 * 
 * @return void
 */
function formbuilder_delete_post(){
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['form_id'] ) ) {
        $form_id = $_GET['form_id'];
        
        wp_delete_post( $form_id ); // Delete data from DB.
        wp_redirect( admin_url( 'admin.php?page=admin-form-builder' ) ); // Redirects to the path.
    }
}
add_action( 'admin_init', 'formbuilder_delete_post' );

/**
 * Enqueue styles and scripts.
 */
function formbuilder_admin_stylesheet() {
    //bootstrap cdn.
    wp_register_style( 'formbuilder-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css' );
    
    // ajax cdn.
    wp_register_script( 'formbuilder-ajax', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js' );
    
    //toastr js cdn.
    wp_register_script( 'formbuilder-toastr_js', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js' );

    //toastr css cdn.
    wp_register_style( 'formbuilder-toastr_css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css' );

    //custom js, css.
    wp_register_script( 'formbuilder-js', plugins_url( 'assets/js/formbuilder-script.js', __FILE__ ), array( 'jquery','formbuilder-ajax', 'formbuilder-toastr_js' ), null, true );
    wp_register_style( 'formbuilder-css', plugins_url( 'assets/css/formbuilder-style.css', __FILE__ ), array( 'formbuilder-bootstrap', 'formbuilder-toastr_css' ) );

}
add_action( 'admin_enqueue_scripts', 'formbuilder_admin_stylesheet' );

/**
 * Enqueue styles and scripts.
 */
function formbuilder_stylesheet() {
    // Bootstrap CDN.
    wp_register_style( 'formbuilder-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css' );
        
    // Ajax CDN.
    wp_register_script( 'formbuilder-ajax', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js' );
    
    //Custom JS.
    wp_register_script( 'formbuilder-js', plugins_url( 'assets/js/formbuilder-frontendscript.js', __FILE__ ), array( 'jquery', 'formbuilder-ajax' ), null, true );

    // Localize the script with the AJAX URL.
    wp_localize_script( 'formbuilder-js', 'custom_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ));
    
    // Custom CSS.
    wp_register_style( 'formbuilder-css', plugins_url( 'assets/css/formbuilder-style.css', __FILE__ ), array( 'formbuilder-bootstrap' ) );

}
add_action( 'wp_enqueue_scripts', 'formbuilder_stylesheet' );