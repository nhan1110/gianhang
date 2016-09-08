$(document).ready(function(){
	var menu_serialized;
	var fixSortable = function() {
		if (!$.browser.msie) return;
		//this is fix for ie
		$('#easymm').NestedSortableDestroy();
		$('#easymm').NestedSortable({
			accept: 'sortable',
			helperclass: 'ns-helper',
			opacity: .8,
			handle: '.ns-title',
			onStop: function() {
				fixSortable();
			},
			onChange: function(serialized) {
				menu_serialized = serialized[0].hash;
				$('#btn-save-menu').attr('disabled', false);
			}
		});
	};
	$('#easymm').NestedSortable({
		accept: 'sortable',
		helperclass: 'ns-helper',
		opacity: .8,
		handle: '.ns-title',
		onStop: function() {
			fixSortable();
		},
		onChange: function(serialized) {
			menu_serialized = serialized[0].hash;
            $('#btn-save-menu').attr('disabled', false);
		}
	});

    /*Update position menu item*/
    $('#btn-save-menu').click(function() {
        var current = $(this);
        current.attr('disabled','disabled');
        current.addClass('loading');
        $.ajax({
	      type: 'POST',
	      url: base_url+'shop_menu/update_menu',
	      data: menu_serialized,
	      success: function(data) {
            if(data=='true'){}	
	      },
          complete:function(){
			  current.removeAttr('disabled');
			  current.removeClass('loading');
			  location.reload();
	      }
        });
        return false;
    });
});