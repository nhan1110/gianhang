          </div>
        </div>
      </div>
      <footer>
         <div class="container">
            <div class="copy text-center">
               Copyright 2016 <a href="<?php echo base_url(); ?>">VN-Market.com</a>
            </div>
         </div>
      </footer>
      <?php $this->load->view("fontend/include/upload");?>
      <script type="text/javascript">
      		$(document).ready(function(){
      			var url = window.location.href;
      			$(".sidebar .nav li a").each(function(){
      				if($(this).attr('href') == url){
      					$(this).parent().addClass('current');
      				}
      			});

            $('select').each(function(){
                var val = $(this).attr('data-value');
                if (typeof attr !== typeof undefined && attr !== false) {
                    $(this).val(val);
                }
            });


      			$('form').submit(function(){
      				var check = true;
      				$(this).find('.required').each(function(){
      					var value = $(this).val();
      					if($.trim(value) == '' || $.trim(value) ==null ){
      						$(this).addClass('border-error');
      						check = false;
      					}
      					else{
      						$(this).removeClass('border-error');
      					}
      				});
      				return check;
      			});

            if($('#slug').length > 0 && $('#title').length > 0){
                $('#title').blur(function(){
                      if($.trim($('#slug').val()) == '' || $.trim($('#slug').val()) == null) {
                         var value = $(this).val();
                         if($.trim(value) !='' && $.trim(value) !=null){
                            var slug = ChangeToSlug(value);
                            $('#slug').val(slug);
                         }
                      }
                });
            }
      		});
            var ChangeToSlug = function(title){
                var slug;
                slug = title.toLowerCase();
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                slug = slug.replace(/ /gi, " - ");
                slug = slug.replace(/(\s+)/g, '-');
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                return $.trim(slug);
            }
      </script>
      <style type="text/css">
      	.border-error{
      		  border:1px solid red;
      	}
        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #e5e5e5;
            background-color: #ff7436;
            color: #fff;
            border-top-right-radius: 6px;
            border-top-left-radius: 6px;
        }
        #modal_upload .container.custom-container{
            max-width: 98%;
        }
      </style>
   </div><!--end wrap -->
  </body>
</html>