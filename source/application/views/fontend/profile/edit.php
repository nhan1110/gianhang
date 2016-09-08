<script src="<?php echo skin_url(); ?>/js/edit-profile.js"></script>
<div class="container">
   <h1 class="page-header">Edit Profile</h1>
   <div class="row">
      <!-- left column -->
      <div class="col-sm-3 col-xs-12">
         <div class="profile-image" style="max-width:188px;margin: 0 auto;">
            <?php
              $member=$wrapper['member'];
              $src=skin_url("images/default_avatar.png");
              if (isset($member->Avatar) && $member->Avatar != null) {
                  if(!preg_match("~^(?:f|ht)tps?://~i", $member->Avatar)){
                      if(file_exists('.' . $member->Avatar)){
                          $src = $member->Avatar;
                      }
                  }
                  else{// avatar facebook,google+
                     $src = $member->Avatar;
                  }
              }
            ?>
            <img  src="<?php echo $src;?>" class="avatar img-circle img-thumbnail" alt="avatar">
            <div class="profile-edit-photo custom-logo">
                <div class="profile-action-edit">
                    <a class="text-white" href="#" onclick="$('#imageCropper-modal #ImageUploader_image').click();return false;"><i class="fa fa-camera"></i></a>
                </div>
            </div>
         </div>
      </div>
      <!-- edit form column -->
      <div class="col-sm-9 col-xs-12">
         <form class="form-horizontal" id="form-edit-profile" role="form">
            <div class="form-group">
               <label class="col-sm-3 control-label">First name:</label>
               <div class="col-sm-9">
                  <input class="form-control required" name="first_name" value="<?php echo @$member->Firstname; ?>" type="text">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Last name:</label>
               <div class="col-sm-9">
                  <input class="form-control required" name="last_name" value="<?php echo @$member->Lastname; ?>" type="text">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Email:</label>
               <div class="col-sm-9">
                  <input class="form-control required" readonly name="email" value="<?php echo @$member->Email; ?>" type="email">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Address:</label>
               <div class="col-sm-9">
                  <input class="form-control required" name="address" value="<?php echo @$member->Address; ?>" type="text">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Phone:</label>
               <div class="col-sm-9">
                  <input class="form-control" name="phone" value="<?php echo @$member->Phone; ?>" type="text">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Password:</label>
               <div class="col-sm-9">
                  <input class="form-control" name="password" id="password" type="password">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Confirm password:</label>
               <div class="col-sm-9">
                  <input class="form-control" name="confirmpassword" id="confirmpassword" type="password">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label"></label>
               <div class="col-sm-9 text-right">
                  <button class="btn btn-primary" id="save-profile" type="submit">Save Changes</button>
               </div>
            </div>
         </form>
      </div>
      <div class="col-sm-12">
         <h3 class="personal-info">Share your location:</h3>
         <div id="map" style="width:100%;height:250px;"></div>
      </div>
   </div>
</div>


<!--model bootstrap avatar-->
<div class="modal fade" id="imageCropper-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url('/profile/save_media'); ?>" enctype="multipart/form-data" id="crop-avatar">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Crop Avatar</h4>
           </div>
           <div class="modal-body" style="position: relative;">
            <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
              <input type="hidden" class="hidden" id="choose" name="choose" value="avatar">
              <input type="hidden" class="hidden" id="x" name="x">
              <input type="hidden" class="hidden" id="y" name="y">
              <input type="hidden" class="hidden" id="w" name="w">
              <input type="hidden" class="hidden" id="h" name="h">
              <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
              <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
              <input style="display:none;" accept="image/*" onchange="readURL(this);" name="fileupload" id="ImageUploader_image" type="file">
              <img id="uploadPreview" src="" style="display:none; max-width:100%;">
           </div>
           <div class="modal-footer text-right">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
              <button id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2">Save and View</button>
           </div>
        </form>
      </div>
   </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
  function initialize() {
      var mapCanvas = document.getElementById('map');
      var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(mapCanvas, mapOptions)
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<style type="text/css">
  #catalog_menu,
  .flexslider{
    display: none;
  }
</style>