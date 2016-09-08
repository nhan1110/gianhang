<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Members <?php if($label !='Add' ) : ?>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/members/add">Add New</a> <?php endif; ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url(); ?>admin/members">Members</a></li>
      <li class="active"><?php echo @$label; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box">
              <div class="box-header hidden">
                <h3 class="box-title">Hover Data Table</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                 <form action="<?php echo @$action; ?>" method="post">
                    <?php if(isset($message) && $message!=null ): ?>
                      <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          <?php echo $message; ?>
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Group Member</label>
                        <select name="group" id="group" class="form-control">
                            <option value="0"> -- Không thuộc nhóm -- </option>
                            <?php
                              foreach ($member_group as $value_group) :
                                if ($value_group->ID == @$group) {
                                  echo '<option selected="selected" value="' . $value_group->ID . '">' . $value_group->Group_Title . '</option>';  
                                } else {
                                  echo '<option value="' . $value_group->ID . '">' . $value_group->Group_Title . '</option>';  
                                }
                              endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" value="<?php echo @$member->Firstname; ?>" name="firstname" class="form-control required" placeholder="First name">
                    </div>
                    <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" value="<?php echo @$member->Lastname; ?>" name="lastname" class="form-control required" placeholder="Last name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" <?php echo $label == 'Add' ? '' : 'readonly'; ?> value="<?php echo @$member->Email; ?>" name="email" class="form-control required" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" value="<?php echo @$member->Address; ?>" name="address" class="form-control" placeholder="Địa chỉ">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" value="<?php echo @$member->Phone; ?>" name="phone" class="form-control" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="Password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="Password" name="configpassword" class="form-control" placeholder="Confirm password">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                        	<option <?php echo @$member->status == 0 ? 'selected' : ''; ?> value="0">Enable</option>
                        	<option <?php echo @$member->status == 1 ? 'selected' : ''; ?> value="1">Disable</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn" type="button" onclick="document.location.href='<?php echo base_url().'admin/members'; ?>'">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save / Update</button>
                    </div>
                 </form>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div>
    </div>
  </section>
</div>