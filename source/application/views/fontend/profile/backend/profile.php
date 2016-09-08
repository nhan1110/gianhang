<div class="content-box-large" style="position: relative;">
    <span style="position: absolute;right: 15px;top: 10px;z-index: 100;"><a style="font-size:20px;" href="<?php echo base_url('/profile/edit'); ?>"><i class="fa fa-pencil"></i></a></span>
  	<div class="panel-body">
	    <div class="row">
	    	<div class="col-md-3">
	    		<div class="profile-image" style="max-width:225px;margin: 0px auto 20px auto;">
		            <?php
		              $src = skin_url("images/default_avatar.png");
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
	    	<div class="col-md-9">
	    		<div class="form-group row">
	               <label class="col-sm-2 control-label">First name:</label>
	               <div class="col-sm-10">
	               	  <p style="font-size: 16px;"><?php echo @$member->Firstname; ?></p>
	               </div>
	            </div>
	            <div class="form-group row">
	               <label class="col-sm-2 control-label">Last name:</label>
	               <div class="col-sm-10">
	                  <p style="font-size: 16px;"><?php echo @$member->Lastname; ?></p>
	               </div>
	            </div>
	            <div class="form-group row">
	               <label class="col-sm-2 control-label">Email:</label>
	               <div class="col-sm-10">
	               	  <p style="font-size: 16px;"><?php echo @$member->Email; ?></p>
	               </div>
	            </div>
	            <div class="form-group row">
	               <label class="col-sm-2 control-label">Địa chỉ:</label>
	               <div class="col-sm-10">
	               	  <p style="font-size: 16px;"><?php echo @$member->Address; ?></p>
	               </div>
	            </div>
	            <div class="form-group row">
	               <label class="col-sm-2 control-label">Số điện thoại:</label>
	               <div class="col-sm-10">
	                  <p style="font-size: 16px;"><?php echo @$member->Phone; ?></p>
	               </div>
	            </div>
	    	</div>
	    </div>
	    <div style="height:20px;"></div>
        <h4>Vị trị của bạn trên bảng đồ</h4>
        <hr style="margin: 10px 0;">
        <div id="map_canvas" style="width:100%;height:300px;margin-bottom:15px;"></div>
	</div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	initialize();
	function initialize() {
		var lat = 21.033300399780273;
		var lng = 105.8499984741211;
		<?php if(isset($member->Lat) && $member->Lat!=null && isset($member->Lng) && $member->Lng!=null): ?>
				lat = <?php echo $member->Lat; ?>;
				lng = <?php echo $member->Lng; ?>;
		<?php endif;?>
		var myLatlng = new google.maps.LatLng(lat,lng);
		var myOptions = {
		  zoom: 6,
		  center: myLatlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP,

		}
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Default Marker',
		});
  }
</script>