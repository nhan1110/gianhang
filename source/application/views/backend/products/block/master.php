<?php

if (isset($content) && is_array($content)):

    $attr_parent = "";

    $html_body = "";

    $group = $content["key"];

    if (isset($content["value"]) && is_array($content["value"]) && count($content["value"]) > 0):

        foreach ($content["value"] as $key => $value_attibute) {
                print_r( $value_attibute);
            $html_body.= "<div class='row' id ='" . $value_attibute["Slug"] . "'><div class='col-md-12'>";

            $html_body.= show_attribute(@$value_attibute,@$attribute, @$attribute_activer);

            $html_body.= "</div></div>";

            if ($value_attibute["Parent_ID"] == 0) {

                $attr_parent.="<option class ='" . $value_attibute["Value"] . "' value='" . $value_attibute["ID"] . "'>" . $value_attibute["Name"] . "</option>";

            }

        }

    endif;

endif;

?>

<div id = "<?php echo $group; ?>-parent-block" class = "tab-pane fade in master-attribute attribute"> 

    <div class = "col-md-12 add-product">

        <div class="panel panel-default">

            <div class="panel-heading"><p>Thuộc Tính Liên Quan</p></div>

            <div class="panel-body">

                <?php echo $html_body; ?>

            </div>

        </div>

    </div>

</div>   

