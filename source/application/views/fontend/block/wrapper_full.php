<div class="col-sm-12">
    <div id="content-profile" class="content">
        <div class="panel">
            <?php
            /* $wrapper an array */
            if (isset($view) && file_exists(APPPATH . "views/{$view}.php")):
                $this->load->view($view);
            endif;
            ?>
        </div>
    </div>
</div>