<section class="regulation">
	<div class="container">
		<div class="row">
		    <div class="col-md-12 text-center">
			    <div class="title"><h1>CHÍNH SÁCH BẢO MẬT THÔNG TIN</h1></div>
		    </div>
	    </div>
	    <div class="row">
		    <div class="col-md-12">
			    <div class="content">
				    <?php
				        $pages = new Pages();
				        $pages->where(array('ID' => 16))->get(1);
					    echo $pages->Page_Content;
				    ?>		
			    </div>
		    </div>
	    </div>
	</div>
</section>
<style type="text/css">
	.regulation{padding-top: 20px;padding-bottom: 30px;}
</style>