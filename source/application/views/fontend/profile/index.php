<div class="container">
   <h1 class="page-header">Profile</h1>
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
         </div>
      </div>
      <!-- edit form column -->
      <div class="col-sm-9 col-xs-12">
         <form class="form-horizontal" id="form-edit-profile" role="form">
            <div class="form-group">
               <label class="col-sm-3 control-label">First name:</label>
               <div class="col-sm-9">
                  <input class="form-control" name="first_name" value="<?php echo @$member->Firstname; ?>" type="text">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Last name:</label>
               <div class="col-sm-9">
                  <input class="form-control" name="last_name" value="<?php echo @$member->Lastname; ?>" type="text">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Email:</label>
               <div class="col-sm-9">
                  <input class="form-control" name="email" value="<?php echo @$member->Email; ?>" type="email">
               </div>
            </div>
         </form>
      </div>
      <div class="col-sm-12">
         <h3 class="personal-info">Location:</h3>
         <div id="map" style="width:100%;height:250px;"></div>
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