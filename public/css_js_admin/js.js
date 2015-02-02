$(document).ready(function() {
	window_resize();
	
	var $tree = $('.tree');

	/*
	$tree.on('click', '.open_btn', function(e) {
		var $this = $(this),
			$parent = $this.parents('.list-group-item:first'),
			id = $parent.attr('data-id'),
			time = 500;
		
		if ($this.hasClass('glyphicon--opacity')) {
			return false;
		}

		if ($this.hasClass('glyphicon-plus')) {
			if ($parent.next('.list-group').length) {
				$parent.next('.list-group').slideDown(time);
				$this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
			} else {
				my.post('/admin/pages/tree', {id: id}, function(data) {
					$data = $(data.data);
					if ($data.is('.list-group')) {
						$parent.after($data);
						$data.hide();
						$data.slideDown(time);
						$this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
						$.cookie( 'admin_pages['+id+']', '1', { path: '/' });
					}
				}, 'json');
			}
		} else {
			if ($parent.next('.list-group').length) {
				$parent.next('.list-group').slideUp(time);
				$this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
				$.removeCookie('admin_pages['+id+']');
			}
		}
		
		return false;
	});
	*/

	$tree.on('click', '.eye_btn', function(e) {
		var $this = $(this),
			$parent = $this.parents('.dd-item:first'),
			id = $parent.attr('data-id');
		
		my.post('/admin/pages/active', {objects: [id]}, function(data) {
			if (data.error == 0){

				if ($this.hasClass('glyphicon-eye-open')) {
					$this.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
				} else {
					$this.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
				}
				
			}
		}, 'json');
		
		return false;
	});

	$('.dd').nestable({
		onEndEvent: function() {
			var $this = $(this),
				id = $this.attr('data-id'),
				$parent = $this.parents('li:first'),
				$prev = $this.prev('.dd-item');
			
			var parent_id = 0,
				before_id = 0;
			
			if ($parent.length) {
				parent_id = $parent.attr('data-id');
				$.cookie( 'admin_pages['+parent_id+']', '1', { path: '/' });
			}
			
			if ($prev.length) {
				before_id = $prev.attr('data-id');
			}
			
			$.post('/admin/pages/position', {id: id, parent_id: parent_id, before_id: before_id}, function(data) {
				if (data.error > 0) {
					my.alert(data.text);
				}
			}, 'json');
		}
	});
	
	var $error = $('#shake_message');
	if ($error.length) {
		$error.modal('show');
	}
	
	
	$('.pagination__count select').on('change', function() {
		var $this = $(this);
		location.href = $this.val();
	});
	
});

$(window).load(function() {

});