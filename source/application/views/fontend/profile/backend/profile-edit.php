<script src="<?php echo skin_url(); ?>/js/edit-profile.js"></script>
<div class="content-box-large">
  	<div class="panel-body">
    	<?php if(isset($error) && $error != null ): ?>
	    	<div class="alert alert-danger">
	    	  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			  <?php echo $error; ?>
			</div>
		<?php endif; ?>
		<?php if(isset($success) && $success != null): ?>
			<div class="alert alert-success">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			  <?php echo $success; ?>
			</div>
		<?php endif; ?>
    	<form role="form" method="post" action="<?php echo @$action; ?>">
		    <div class="row">
		    	<div class="col-md-3">
		    		<div class="profile-image" style="max-width:225px;margin: 20px auto;">
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
			            <div class="profile-edit-photo custom-logo">
			                <div class="profile-action-edit">
			                    <a class="text-white" href="#" onclick="$('#imageCropper-modal #ImageUploader_image').click();return false;"><i class="fa fa-camera"></i></a>
			                </div>
			            </div>
			        </div>
		    	</div>
		    	<div class="col-md-9">
		    		<div class="form-group row">
		               <label class="col-sm-2 control-label">First name:</label>
		               <div class="col-sm-10">
		                  <input class="form-control required" name="first_name" value="<?php echo @$member->Firstname; ?>" type="text">
		               </div>
		            </div>
		            <div class="form-group row">
		               <label class="col-sm-2 control-label">Last name:</label>
		               <div class="col-sm-10">
		                  <input class="form-control required" name="last_name" value="<?php echo @$member->Lastname; ?>" type="text">
		               </div>
		            </div>
		            <div class="form-group row">
		               <label class="col-sm-2 control-label">Email:</label>
		               <div class="col-sm-10">
		                  <input class="form-control required" readonly name="email" value="<?php echo @$member->Email; ?>" type="email">
		               </div>
		            </div>
		            <div class="form-group row">
		               <label class="col-sm-2 control-label">Địa chỉ:</label>
		               <div class="col-sm-10">
		                  <input class="form-control required" name="address" value="<?php echo @$member->Address; ?>" type="text">
		               </div>
		            </div>
		            <div class="form-group row">
		               <label class="col-sm-2 control-label">Số điện thoại:</label>
		               <div class="col-sm-10">
		                  <input class="form-control required" name="phone" value="<?php echo @$member->Phone; ?>" type="text">
		               </div>
		            </div>
		    	</div>
		    </div>
		    <div class="form-group text-right">
                <button class="btn btn-primary" id="save-profile" type="submit">Lưu thay đổi</button>
            </div>
            <h4>Đánh dấu vị trị của bạn trên bảng đồ</h4>
            <hr style="margin: 10px 0;">
            <div id="map_canvas" style="width:100%;height:300px;margin-bottom:15px;"></div>
            <input type="hidden" id="lat" name="lat" class="form-control" value="<?php echo @$member->Lat; ?>">
            <input type="hidden" id="lng" name="lng" class="form-control" value="<?php echo @$member->Lng; ?>">
            <div class="text-right">
                <button class="btn btn-primary" id="save-profile" type="submit">Lưu thay đổi</button>
            </div>
		</form>
	</div>
</div>
<!--model bootstrap avatar-->
<div class="modal fade" id="imageCropper-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url('/profile/save_media'); ?>" enctype="multipart/form-data" id="crop-avatar">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Chỉnh sữa ảnh đại diện</h4>
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
              <button id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2">Cập nhập / Lưu</button>
           </div>
        </form>
      </div>
   </div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	var lat = 21.033300399780273;
	var lng = 105.8499984741211;
	<?php if(isset($member->Lat) && $member->Lat!=null && isset($member->Lng) && $member->Lng!=null): ?>
			lat = <?php echo $member->Lat; ?>;
			lng = <?php echo $member->Lng; ?>;
	<?php endif;?>
	initialize(lat,lng);
	<?php if(! (isset($member->Lat) && $member->Lat!=null && isset($member->Lng) && $member->Lng!=null) ): ?>
		geoFindMe();
	<?php endif;?>
	function initialize(lat,lng) {
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
			draggable:true
		});

		/*google.maps.event.addListener(map,'click',function(event) {
				marker = new google.maps.Marker({
				position: event.latLng,
				map: map,
				title: 'Click Generated Marker',
				draggable:true
				});
		});*/

		google.maps.event.addListener(
			marker,
			'drag',
			function(event) {
				document.getElementById('lat').value = this.position.lat();
				document.getElementById('lng').value = this.position.lng();
				//alert('drag');
		});


		google.maps.event.addListener(marker,'dragend',function(event) {
	        document.getElementById('lat').value = this.position.lat();
	        document.getElementById('lng').value = this.position.lng();
	        //alert('Drag end');
	    });
  }

  function geoFindMe() {
		if (!navigator.geolocation){
			alert('Geolocation is not supported by your browser');
			return;
		}

		function success(position) {
			var lat  = position.coords.latitude;
			var lng = position.coords.longitude;
			$('#lat').val(lat);
			$('#lng').val(lng);
			initialize(lat,lng);
		};

		function error() {
			alert('Unable to retrieve your location');
		};

		navigator.geolocation.getCurrentPosition(success, error);
	}
</script>
<style type="text/css">
	.custom-loading {
	    position: absolute;
	    top: 43%;
	    left: 0;
	    right: 0;
	    text-align: center;
	    z-index: 1000;
	    display: none;
	}
	.jcrop-keymgr{
	    opacity: 0;
	}
	.profile-image{
	    position: relative;
	}
	.profile-image:hover .profile-edit-photo {
	    display: block;
	}
	.profile-edit-photo {
	    display: none;
	    position: absolute;
	    text-align: center;
	    z-index: 99;
	    top: 0;
	    left: 0;
	    border-radius: 50%;
	    width: 100%;
	    background: rgba(0, 0, 0, 0.65);
	    height: 100%;
	}
	.profile-edit-photo .profile-action-edit {
	    width: 100%;
	    height: 100%;
	    display: table;
	    table-layout: fixed;
	}
	.profile-edit-photo .profile-action-edit a {
	    padding: 5px 10px;
	    font-size: 16px;
	    color: #fff;
	    display: table-cell;
	    vertical-align: middle;
	}
	.owner-bar{
	    position: absolute;
	    bottom: 0;
	    left: 0;
	    width: 100%;
	    background: rgba(0, 0, 0, 0.42);
	}
	.owner-bar i {color: #fff ;font-size: 16px;}
	.owner-bar a {padding: 3px 5px;}
</style>