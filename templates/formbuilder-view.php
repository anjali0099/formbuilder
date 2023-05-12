<?php
wp_enqueue_script( 'formbuilder-js' );
wp_enqueue_style( 'formbuilder-css' );
?>

<div class="col">
    <h2> <?php _e( 'Forms', 'formbuilder' ) ?> </h2><hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col" style="text-align: center;"><?php _e( 'Title', 'formbuilder' ) ?></th>
                <th scope="col" style="text-align: center;"><?php _e( 'Shortcode', 'formbuilder' ) ?></th>
                <th scope="col" style="text-align: center;"><?php _e( 'Date', 'formbuilder' ) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $args = array(
                    'post_type' => 'formbuilder',
                    'post_status' => 'publish'
                );
                $query = new WP_Query($args);
                if ( $query->have_posts() ):
                    while ( $query->have_posts() ):
                        $query->the_post();
                        $Post_id = get_the_ID();
                        $formbuilder_view = '[formbuilder-shortcode id="'.$Post_id.'"]';
                        ?>
                            <tr>
                                <td style="text-align: center;"> <?php the_title();  ?> </td>
                                <td style="text-align: center;"> 
                                    <input type="text" readonly="readonly" value='<?php echo $formbuilder_view ?>' class="large-text">
                                </td>
                                <td style="text-align: center;"> <?php echo the_date( 'd-m-Y' ); ?> </td>
                                
                            </tr>
                        <?php
                    endwhile;
                endif;
                wp_reset_postdata();
            ?>
        </tbody>
    </table>
</div>

