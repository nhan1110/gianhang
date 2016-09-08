<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Demystifying Email Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8">
</head>
<body style="margin: 0; padding: 0;">
	<table align="center" style="border: 1px solid #eee; float : none; margin: 40px auto;" bgcolor="#eee" cellpadding="0" cellspacing="0" width="600">
	    <tr>
	        <td align="center" bgcolor="#e5e5e5" style="padding: 40px 0 30px 0;">
	        	<!--HEADER-->
			    <?php 
					//$pages = new Email_Templates();
					//$pages->where(array('ID' => '2'))->get(1);
					//echo $pages->Header;
				?>
				<img src="http://gianhangcuatoi.com/skins/images/logo.png" alt="gianhangcuatoi" width="300" height="auto" style="display: block;" />
			    <!--/HEADER-->
			</td>
	    </tr>
	    <tr>
	        <td bgcolor="#eee" style="padding: 40px 20px 40px 20px;">
	        	<!--CONTENT-->
	        	<p>Chào bạn <strong><?php echo $to_email_name; ?>,</strong></p>
	        	<br>
			    <?php 
					$pages = new Email_Templates();
					$pages->where(array('ID' => '2'))->get(1);
					echo $pages->Content;
				?>
			    <!--/CONTENT-->
			</td>
	    </tr>
	    <tr>
	        <td bgcolor="#e5e5e5" style="padding: 20px 20px 20px 20px;">
	        	<!--FOOTER-->
			    <?php 
					//$pages = new Email_Templates();
					//$pages->where(array('ID' => '2'))->get(1);
					//echo $pages->Footer;
				?>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				        <td>
						    <?php 
		    					$pages = new Pages();
						    	$pages->where(array('Page_Slug' => 'about'))->get(1);
						    	echo $pages->Page_Content;
		    				?>
				        </td>
				    </tr>
				    <tr>
				    	<td>
				    		<?php 
		    					//$pages = new Pages();
						    	//$pages->where(array('Page_Slug' => 'footer-bottom'))->get(1);
						    	//cho $pages->Page_Content;
		    				?>
				    	</td>
				    </tr>
				</table>
				<!--/FOOTER-->
			</td>
	    </tr>
	</table>
</body>
</html>
<style type="text/css">
	.msg-pane-v2 .thread-item.expanded .thread-body{text-align: inherit;}
</style>








