<div class="container">
   <div class="panel" style="margin-bottom: 0;border-bottom: 1px solid #ccc;">
        <div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
					<?php if(isset($cancel) && $cancel!=null ): ?>
						<div class="alert alert-danger fade in">
						    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						    <?php echo $cancel; ?>
						</div>
					<?php endif; ?>

					<?php if(isset($message) && $message!=null ): ?>
						<div class="alert alert-success fade in">
						    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						    <?php echo $message; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-month">
					    <div class="row">
							<div class="col-md-3"><strong>Số Tháng</strong></div>
							<div class="col-md-7"><strong>Tổng tiền</strong></div>
							<div class="col-md-2"><strong>Lựa chọn</strong></div>
						</div>
					</div>
					<?php 
						if(isset($upgrade) && is_array($upgrade) && $upgrade != null){ 
							foreach ($upgrade as $key => $value) {?>
								<div class="box-month-<?php echo $value["Number_Month"] ;?> box-month">
									<div class="row">
										<div class="col-md-3"><span class="number-month"><?php echo $value["Number_Month"] ;?></span><span class="text-month">Tháng</span></div>
										<div class="col-md-7">
											<p>Số tiền phải chi trả trong 1 tháng : <?php echo number_format($value["Price_One_Month"],3); ?> VND</p>
											<p>Tổng tiền phải chi trả trong <?php echo $value["Number_Month"] ;?> tháng : <?php echo number_format($value["Number_Month"]*$value["Price_One_Month"],3);?> VND</p>
											<p><?php echo $value["Description"]?></p>
										</div>
										<div class="col-md-2"><a href="<?php echo base_url("upgrade/payment/".$value["ID"]);?>" class="btn btn-primary">Lựa chọn</a></div>
									</div>
								</div>
							<?php }
					 	} ?>
				</div>
			</div>
	    </div>
   </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/css/page/upgrade.css");?>">