<div class="container">
   <h1 class="page-header">Danh Mục Sản Phẩm</h1>
   <div class="row">
     <div class="col-md-3">
        <h4>Thêm mới:</h4>
        <div id="wrapp-box">
          <div class="form-group">
            <input type="text" id="add-method" class="form-control">
          </div>
          <div class="form-group">
            <select id="category_parent" class="form-control">
                <option value="0">— Parent Category —</option>
                <?php echo isset($select_cat) ? $select_cat : ""?>
            </select>
          </div>
          <div class="form-group">
            <a href="#" id="add-button" class="btn btn-success col-md-12">Add New Category</a>
          </div>
        </div>
     </div>
     <div class="col-md-9">
     <?php $number_cat = (isset($record_cat)) ? count($record_cat) : "0" ; ?>
     <h4>Tất cả danh mục (<?php echo $number_cat;?>)</h4>
      <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Number Order</th>
                <th>Parent</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
     </div>
   </div>
</div>