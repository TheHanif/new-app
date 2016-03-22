var $menu_structure, $last_index;

$(function(){

	$menu_structure = $('#menu-structure');

	// Initial draggable all items
	make_draggable();

	// Index proper index
	reindex_order();

	// Bind key up for porlet name on item label
	$menu_structure.find('li').find("[name$='[label]']").on('keyup', function(e) {
		e.preventDefault();
		var $this = $(this);
		
		$this.parents('li:first()').find('h4:first()').text($this.val());
	});

	$menu_structure.on('click', '.box-close', function(event) {
		event.preventDefault();
		var $this = $(this);
		$this.parents('li:first()').remove();
		/* Act on the event */
	});
	
	// ADD TO MENU STRUCTURE
	$('.add-menu').click(function(e) {
		e.preventDefault();

		var btn = $(this);
		var container = btn.parents('.items-for-menu');

		container.find("input:checked").each(function(index, el) {
			var box = $(el);

			var type = box.data('type');
			var label = box.data('label');
			var url = box.data('url');
			var object_id = box.data('object-id');
			var original_label = box.data('original-label');
			var original_url = box.data('original-url');


			create_element(type, label, url, object_id, original_label, original_url);
		});
	});

	// CUSTOM LINK ADD TO MENU STRUCTURE
	$('.custom-add-menu').click(function(e) {
		e.preventDefault();

		var btn = $(this);
		var container = btn.parents('.portlet-body');

		var type = 'custom';
		var label = container.find('.custom-link-label').val();
		var url = container.find('.custom-link-url').val()

		create_element(type, label, url);
	});

})

function create_element(type, label, url, object_id = '', original_label = '', original_url = ''){

	var index = $last_index+1;

	var display_type = type.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		    return letter.toUpperCase();
		});

	var $e = '<li data-index="'+index+'">'+
			'<input type="hidden" name="items['+index+'][parent]" value="">'+
			'<input type="hidden" name="items['+index+'][objectid]" value="'+object_id+'">';

	// Add slug if not custom link
	if (type != 'custom') {
			$e += '<input type="hidden" name="items['+index+'][url]" value="'+url+'">';
	}

	$e +=	'<input type="hidden" name="items['+index+'][type]" value="'+type+'">'+
			'<div class="portlet">'+
				'<div class="portlet-heading">'+
					'<div class="portlet-title">'+
						'<h4>'+label+'</h4>'+
					'</div>'+
					'<div class="portlet-widgets">'+
						'<a href="#panel_'+index+'" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>'+
						'<span class="divider"></span>'+
						'<a title="*Remove" class="box-close" href="#"><i class="fa fa-times text-danger"></i></a>'+
					'</div>'+
					'<div class="portlet-widgets">'+
						'<small class="text-sx">'+display_type+'</small>'+
					'</div>'+
					'<div class="clearfix"></div>'+
				'</div>'+
				'<div class="panel-collapse collapse" id="panel_'+index+'">'+
					'<div role="form" class="portlet-body form-horizontal">'+
						'<div class="row">'+
							'<div class="col-xs-12 col-sm-6">'+
								'<div class="form-group">'+
									'<label class="label-control">*Navigation label</label>'+
									'<input type="text" class="form-control input-sm" name="items['+index+'][label]" value="'+label+'">'+
								'</div>'+
							'</div>'+
							'<div class="col-xs-12 col-sm-6">'+
								'<div class="form-group">'+
									'<label class="label-control">*Title attribute</label>'+
									'<input type="text" class="form-control input-sm" name="items['+index+'][title]" value="">'+
								'</div>'+
							'</div>'+
						'</div>';
		
		// Add field to enter custom URL
		if (type == 'custom') {
			$e +=		'<div class="form-group">'+
							'<label class="label-control">Custom URL</label>'+
							'<input type="text" class="form-control input-sm" name="items['+index+'][url]" value="'+url+'">'+
						'</div>';
		};

		$e +=			'<div class="form-group">'+
							'<label class="label-control">*CSS Classes (Optional)</label>'+
							'<input type="text" class="form-control input-sm" name="items['+index+'][css]" value="">'+
						'</div>'+

						'<div class="form-group">'+
							'<label class="label-control">*Description</label>'+
							'<textarea class="form-control input-sm" rows="4" name="items['+index+'][description]"></textarea>'+
						'</div>'+

						'<div class="form-group">'+
							'<label class="label-control">*Image</label>'+
								'<div class="thumbnail'+index+'"></div>'+
								'<span data-output="id" data-value=".value'+index+'" data-thumbnail=".thumbnail'+index+'" data-media="0" class="btn btn-file1 browse-media">*Browse</span>'+
								'<input type="hidden" name="items['+index+'][image]" value="" class="value'+index+'">'+
						'</div>';
		
		// Display original meta if not custom link
		if (type != 'custom') {
			$e +=		'<div class="well white">'+
							'*Original: <a href="'+original_url+'">'+original_label+'</a>'+
						'</div>';
		};


		$e +=		'</div>'+
				'</div>'+
			'</div>'+

			'<ul class="sub-items menu-target"></ul>'+
		'</li>';

	// Append to list and bind keyup to change label
	$($e).appendTo($menu_structure.find('ul:first()')).find("[name$='[label]']").on('keyup', function(e) {
		e.preventDefault();
		var $this = $(this);
		
		$this.parents('li:first()').find('h4:first()').text($this.val());
		
		$this.find('.box-close').click(function(event) {
			event.preventDefault();
			$this.remove();
		});

	});

	// reindex all elements
	reindex_order();
	make_draggable();

	return $($e);

} // create_element();

function reindex_order(){
	$menu_structure.find('li').each(function(index, el) {

		var item = $(el);
		var old_index = item.data('index');
		var new_index = index+1;
		
		var parent = item.parents('li').data('index');
			parent = parent? parent : 0;

		// Reset index and old index for 
		item.data('index', new_index);

		// Reset parent index
		item.attr('data-parent', parent);

		// Reset form field index
		item.find("[name*='["+old_index+"]']").each(function() {
			$(this).attr('name', $(this).attr('name').replace(old_index, new_index));
		});

		// Set parent input value
		item.find("[name*='[parent]']").val(parent);

		// Cache for future use
		$last_index = new_index;
	});
} // reindex_order();

function make_draggable(){
	$( ".menu-target" ).sortable({
		placeholder: "ui-state-highlight",
		connectWith: ".menu-target",
		revert: 250,
		opacity: 0.4,
		update: function(event, ui) {
			// reindex();
			reindex_order();
		}
	});
	// $( ".menu-target" ).disableSelection();
} // make_draggable();