<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Page / Block <?php if($label !='Add' ) : ?>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/page/add">Add New</a> <?php endif; ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url(); ?>admin/page">Page / Block</a></li>
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
                        <label>Title</label>
                        <input type="text" value="<?php echo @$pages->Page_Title; ?>" name="title" class="form-control required" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label>Featured Image</label>
                        <img src="<?php echo @$pages->Page_Feature_Image; ?>" style="<?php echo @$pages->Page_Feature_Image == '' ? 'display:none;' : ''; ?>margin-right:10px;" id="xImagePathClient" width="200px" />
                        <input type="button" value="Browse Server" onclick="BrowseServer('xImagePath' );" />
                        <input type="button" value="Remove File" onclick="ClearFile('xImagePath' );" />
                        <input type="hidden" id="xImagePath" value="<?php echo @$pages->Page_Feature_Image; ?>" name="feature_image" class="form-control" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <?php echo $this->ckeditor->editor('description',@$pages->Page_Description);?>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <?php echo $this->ckeditor->editor('content',@$pages->Page_Content);?>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                          <option <?php echo @$pages->Page_Type == 0 ? 'selected' : ''; ?> value="0">Page</option>
                          <option <?php echo @$pages->Page_Type == 1 ? 'selected' : ''; ?> value="1">Block</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option <?php echo @$pages->Page_Status == 0 ? 'selected' : ''; ?> value="0">Enable</option>
                          <option <?php echo @$pages->Page_Status == 1 ? 'selected' : ''; ?> value="1">Disable</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary" type="submit" >Save / Update</button>
                    </div>
                 </form>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div>
    </div>
  </section>
</div>
<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
function BrowseServer( inputId )
{
    var finder = new CKFinder() ;
    finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
    finder.SelectFunction = SetFileField ;
    finder.SelectFunctionData = inputId ;
    finder.Popup() ;
}

function ClearFile( inputId )
{
    document.getElementById( inputId ).value = '' ;
    document.getElementById( inputId + "Client" ).src = '' ;
    document.getElementById( inputId + "Client" ).style.display = 'none' ;
}

function SetFileField( fileUrl, data )
{
    document.getElementById( data["selectActionData"] ).value = fileUrl ;
    document.getElementById( data["selectActionData"] + "Client" ).src = fileUrl ;
    document.getElementById( data["selectActionData"] + "Client" ).style.display = '' ;
}
</script>