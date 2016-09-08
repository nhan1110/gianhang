<div class="container">
   <div id="breadcrumb">
      <ol class="breadcrumb container">
         <li><a href="http://demopavothemes.com/pav_food_store/index.php?route=common/home"><span><i class="fa fa-home"></i></span></a></li>
         <li><a href="http://demopavothemes.com/pav_food_store/index.php?route=checkout/cart"><span>Shopping Cart</span></a></li>
      </ol>
   </div>
   <div class="row">
      <section id="sidebar-main" class="col-md-12">
         <div id="content">
            <h1>Shopping Cart</h1>
            <form action="http://demopavothemes.com/pav_food_store/index.php?route=checkout/cart/edit" method="post" enctype="multipart/form-data">
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <td class="text-center">Image</td>
                           <td class="text-left">Product Name</td>
                           <td class="text-left">Model</td>
                           <td class="text-left">Quantity</td>
                           <td class="text-right">Unit Price</td>
                           <td class="text-right">Total</td>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td class="text-center">                  <a href="http://demopavothemes.com/pav_food_store/index.php?route=product/product&amp;product_id=34"><img src="http://demopavothemes.com/pav_food_store/image/cache/catalog/demo/product/img-produce08-65x77.jpg" alt="Mollis eleifend" title="Mollis eleifend" class="img-thumbnail"></a>
                           </td>
                           <td class="text-left"><a href="http://demopavothemes.com/pav_food_store/index.php?route=product/product&amp;product_id=34">Mollis eleifend</a>
                           </td>
                           <td class="text-left">Product 7</td>
                           <td class="text-left">
                              <div class="input-group btn-block" style="max-width: 200px;">
                                 <input type="text" name="quantity[1381]" value="2" size="1" class="form-control">
                                 <span class="input-group-btn">
                                 <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Update"><i class="fa fa-refresh"></i></button>
                                 <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" onclick="cart.remove('1381');" data-original-title="Remove"><i class="fa fa-times-circle"></i></button></span>
                              </div>
                           </td>
                           <td class="text-right">$122.00</td>
                           <td class="text-right">$244.00</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </form>
            <div class="buttons">
               <div class="pull-left"><a href="http://demopavothemes.com/pav_food_store/index.php?route=common/home" class="button btn btn-theme-default">Continue Shopping</a></div>
               <div class="pull-right"><a href="http://demopavothemes.com/pav_food_store/index.php?route=checkout/checkout" class="button btn btn-theme-default">Checkout</a></div>
            </div>
         </div>
      </section>
   </div>
</div>