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
                        if ( $type != "submit" && $type != "textarea" ) {
                            echo '<label> ' . $type . ' </label>';
                            echo '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" class="form-control" >';
                            echo '<br>';
                        }elseif ( $type == "textarea" ){
                            echo '<label> ' . $type . ' </label>';
                            echo '<textarea class="form-control" name="' . $name . '" id="' . $id . '" rows="3"></textarea>';
                            echo '<br>';
                        }elseif ( $type == "submit" ){
                            echo '<button type="' . $type . '" name="' . $name . '" id="' . $id . '" class="btn btn-sm btn-light" > '. ucfirst( $type ) .' </button> ';
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
