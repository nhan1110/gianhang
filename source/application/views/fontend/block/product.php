<?php if (isset($product)): ?>
    <div class="thumbnail relative">
        <?php
        $price = "Liên hệ";
        if ($product["Is_Main"] == 1 && $product["Price"] != 0) {
            $price = $product["Price"] . " VND";
        }
        $thumbnail = ( $product["Path_Thumb"] != null && file_exists(FCPATH . "/" . $product["Path_Thumb"])) ? $product["Path_Thumb"] : "/skins/images/thumbnail-default.jpg";
        $date = date("Y-m-d");
        ?> 
        <div class="box-photo relative">
            <?php
            echo '<span class="price">' . @$price . '</span>';
            if ($product["Is_Main"] == 1 && $product["Special_Price"] != 0 && $product["Special_Price"] < $product["Price"] && (strtotime($date) >= strtotime($product["Special_Start"]) && strtotime($date) <= strtotime($product["Special_End"]))) {
                echo "<div class='sale'><img src = '" . base_url("skins/images/sale.png") . "'></div>";
            }
            ?>
            <a href="<?php echo base_url("product/details/" . $product["Slug"] . "") ?>">
                <div class="thumb-product" style="background-image:url('<?php echo base_url($thumbnail); ?>')"></div>
            </a>   
            <?php
            if (isset($user_id) && $user_id == $product["Member_ID"] && isset($page) && $page == "my_product") {
                echo '<div class="owner-bar text-center">
                            <a href="' . base_url("profile/edit_product/" . $product["Slug"] . "/?category-type=" . $product["Ct_Slug"]) . '" title="edit product"><i class="fa fa-edit"></i></a>
                            <a href="#" id="delete-my-product" data-id="' . $product["ID"] . '" title="delete product"><i class="fa fa-trash-o"></i></a>
                            <a href="' . base_url("profile/copy_product/" . $product["ID"]) . '" id="copy-product" title="copy product"><i class="fa fa-copy"></i></a>
                            <a href="" title="share product"><i class="fa fa-share-alt"></i></a>
                        </div>';
            }
            ?>
        </div>
        <div class="caption">
            <h3><a href="#"><?php echo $product["Name"]; ?></a></h3>
            <p><?php echo $product["Description"]; ?></p>
        </div>
        <hr>
        <div class="tracking">
            <p>
                <span class="like">
                    <span class="number-like">10</span>
                    <span><i class="fa fa-heart-o"></i></span>
                </span>

                <span class="comment">
                    <span class="number-comment">10</span>
                    <span><i class="fa fa-comment-o"></i></span>
                </span>

                <span class="view">
                    <span class="number-view">10</span>
                    <span><i class="fa fa-eye"></i></span>
                </span>

                <span class="microsite">
                    <a href="#"><i class="fa fa-link"></i></a>
                </span>
            </p>
        </div>
    </div>
<?php endif; ?>