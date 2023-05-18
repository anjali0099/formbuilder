<div class="card">
    <div class="card-body">
        <h4 class="card-title"><?php _e(  the_title(), 'formbuilder' ) ?></h4><hr>
        <?php 
            ?>
            <form action="" method="POST">
            <?php
                foreach ($result as $key => $value) {
                    $type = $value['type'];
                    $name = $value['name'];
                    $id = $value['id'];

                    if ( ! empty( $type ) ) {
                        switch ( $type ) {
                            case 'label':
                                echo '<label> '. $name .' </label>';
                                break;
                            case 'textarea':
                                echo '<textarea class="form-control" name="' . $name . '" id="' . $id . '" rows="3"></textarea>';
                                echo '<br>';
                                break;
                            case 'submit':
                                echo '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" class="btn btn-sm btn-light" > ';
                                echo '<br>';
                                break;
                            default:
                                echo '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" class="form-control" >';
                                echo '<br>';
                        }
                    }
                }
            ?>
            </form>
            <?php
        ?>
    </div>
</div>
