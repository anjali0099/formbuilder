<?php
wp_enqueue_script( 'formbuilder-js' );
wp_enqueue_style( 'formbuilder-css' );
?>

<div class="col">
    <h2> <?php _e( 'Forms', 'formbuilder' ) ?> </h2><hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <!-- <th style="text-align: center;">
                    <input type="checkbox" id="delete_all" name="delete_all" value="all_selected">
                </th> -->
                <th scope="col" style="text-align: center;"><?php _e( 'Title', 'formbuilder' ) ?></th>
                <th scope="col" style="text-align: center;"><?php _e( 'Shortcode', 'formbuilder' ) ?></th>
                <th scope="col" style="text-align: center;"><?php _e( 'Date', 'formbuilder' ) ?></th>
                <th scope="col" colspan="2" style="text-align: center;"><?php _e( 'Action', 'formbuilder' ) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $args = array(
                    'post_type' => 'formbuilder',
                    'post_status' => 'publish',
                );
                $query = new WP_Query($args);
                if ( $query->have_posts() ){
                    while ( $query->have_posts() ){
                        $query->the_post();
                        $Post_id = get_the_ID();
                        $formbuilder_view = '[formbuilder-shortcode id="'.$Post_id.'"]';
                        ?>
                            <tr>
                                <!-- <td style="text-align: center;">
                                    <input type="checkbox" class="select_delete_post" name="select_delete_post" value="selected_post">
                                </td> -->
                                <td style="text-align: center;"> 
                                    <?php the_title(); ?> 
                                </td>
                                <td style="text-align: center;"> 
                                    <input type="text" readonly="readonly" value='<?php echo esc_html($formbuilder_view) ?>' class="large-text">
                                </td>
                                <td style="text-align: center;"> 
                                    <?php echo get_the_date( 'Y-m-d', $Post_id ); ?> 
                                </td>
                                <td style="text-align: center;">
                                    <a class="btn btn-sm btn-primary " href="admin.php?page=admin-form&form_id=<?php echo esc_html($Post_id); ?>">
                                        <?php _e( 'Edit', 'formbuilder' ) ?>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="admin.php?page=admin-form-builder&action=delete&form_id=<?php echo esc_html($Post_id); ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                        <?php _e( 'Delete', 'formbuilder' ) ?>
                                    </a>
                                </td>
                            </tr>
                        <?php
                    }
                }else{
                    ?>
                        <tr>
                            <td colspan="4" style="text-align: center;" >
                                <?php _e( 'No Posts Found', 'formbuilder' ); ?>
                            </td>
                        </tr>
                    <?php
                }
                wp_reset_postdata();
            ?>
        </tbody>
    </table>
</div>