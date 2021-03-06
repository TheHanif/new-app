$(document).ready(function() {
	// Browse media
	$('.browse-media').each(function(index, el) {
		$(this).click(function(e) {
			e.preventDefault();

			var el = $(this);
// console.log(el.data('media'));
			if (el.data('media') == 1) {
				remove_media(el);
			}else{
				get_media(el);
			}

		});
	}); // end of browse media
});


// Remove inserted media
function remove_media(browser){
	// Selectors
	var preview = browser.data('preview');
	var thumbnail = browser.data('thumbnail');
	var value = browser.data('value');

	// Media value
	$(value).val('');

	// Remove if any image already
	$(preview).find('img').remove();
	$(thumbnail).find('img').remove();

	// Change browser text and set media true
	browser.text(browser_text).data('media', 0);

} // end of remove_media


// Insert selected media in form
function insert_media(browser, media){
	
	// return if nothing selected
	if(media.length == 0) return;

	// Selectors
	var preview = browser.data('preview');
	var thumbnail = browser.data('thumbnail');
	var value = browser.data('value');

	// Media value
	$(value).val(media.val());

	// Remove if any image already
	$(preview).find('img').remove();
	$(thumbnail).find('img').remove();

	// Thumbnail
	$('<img>',{
		src: media.data('thumbnail')
	}).appendTo(thumbnail);

	// Preview
	$('<img>',{
		src: media.data('preview')
	}).appendTo(preview);

	// Change browser text and set media true
	browser.text(browser_remove).data('media', 1);
} // end of insert media

function get_media(browser, editor = null){

	var Buttons = {}

	$.ajax({
		url: 'include/media_ajax.php',
		type: 'POST',
		data: {action: 'browse'},
		dataType: 'json',
	})
	.done(function(data) {
		
		var gallery = 'Sorry! You do not have any media in library.';

		if ($.type(data) != 'null') {
			gallery = '<ul class="tc-gallery-2 clearfix" id="media_browser">';
				
			for (var i = data.length - 1; i >= 0; i--) {

				var media = data[i];
				
				var value = media.ID;

				var date = media.date.split(' ');
				var date = date[0].split('-');

				var d = date[2];
				var m = date[1];
				var y = date[0];

				var path = SITEURL+'contents/uploads/'+y+'/'+m+'/'+d+'/';
			
				if (editor != null || (browser != null && browser.data('output') == 'url')) { value = path+media.file};

				// Set data from footer file for custom media sizes
				var data_attr = '';
				$(media_sizes).each(function() {
					data_attr += ' data-'+this.key+'="'+path+media.file.replace('.', '-'+this.key+'.')+'"';
				})

				gallery += '<li class="thumbnail">'+
					'<div class="thumb-preview">'+
						'<div class="thumb-image">'+
							'<img src="'+path+media.file.replace('.', '-thumbnail.')+'" alt="" style="width:150px; height: 150px;">'+
						'</div>'+
						'<div class="gl-thumb-options">'+
							'<a class="gl-zoom" href="'+path+media.file.replace('.', '-large.')+'" data-rel="colorbox" title="'+media.title+'">'+
								'<i class="fa fa-search"></i>'+
							'</a>'+
							'<div class="gl-toolbar">'+
								'<div class="gl-option checkbox-inline">'+
									'<input class="tc media_select" type="checkbox" id="file_'+media.ID+'" name="media" data-preview="'+path+media.file.replace('.', '-large.')+'" '+data_attr+' value="'+value+'">'+
									'<label class="labels media" for="file_'+media.ID+'"> Select</label>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<h5 class="gl-title">'+media.file.split('.')[0]+'<small>.'+media.file.split('.')[1]+'</small></h5>'+
					'<div class="gl-description">'+
						'<small class="pull-right">'+d+'/'+m+'/'+y+'</small>'+
					'</div>'+
				'</li>';
			};
			gallery += '</ul>';

			Buttons["success"] = {
						"label" : "<i class='fa fa-check'></i> Insert!",
						"className" : "btn-sm btn-success",
						"callback": function() {
							var media_select = $('.media_select:checked');

							if(editor == null){
								insert_media(browser, media_select);
							}else{
								var message = "<strong>Select Size</strong>";

								// Set data from footer file for custom media sizes
								$(media_sizes).each(function() {
									message += '<div class="tcb">'+
													'<label>'+
														'<input type="radio" name="optionsRadios" value="'+this.key+'" class="tc sizes">'+
														'<span class="labels"> '+this.description+'</span>'+
													'</label>'+
												'</div>';
								})

									// Original
									message += '<div class="tcb">'+
													'<label>'+
														'<input type="radio" name="optionsRadios" value="original" class="tc sizes">'+
														'<span class="labels"> Original</span>'+
													'</label>'+
												'</div>';

								bootbox.dialog({
									message: message,
									buttons: 			
									{
										"success" :
										  {
											"label" : "<i class='fa fa-check'></i> OK!",
												"className" : "btn-sm btn-success",
												"callback": function() {
													var file = ($('.sizes:checked').val() == 'original')? media_select.val() : media_select.data($('.sizes:checked').val());
													editor.editor.composer.commands.exec("insertImage", file);
													return;
													}
												}
										 }
								});
								
							} // end else
						} // call back
					} // end of button
			}

		

		
			Buttons['cancel'] = {
					"label" : "Cancel",
						"className" : "btn-sm btn-inverse",
						"callback": function() {
							//Example: console.log("");
						}
					}

		bootbox.dialog({
			message: gallery,
			buttons: Buttons		
		}); // end bootbox

		$('#media_browser').slimScroll({
			height: '450px',
			disableFadeOut: true,
			touchScrollStep: 50
		});

		//colorbox function
		jQuery(function($) {
			var $overflow = '';
			var colorbox_params = {
				rel: 'colorbox',
				reposition:true,
				scalePhotos:true,
				scrolling:true,
				previous:'<i class="fa fa-arrow-left text-gray"></i>',
				next:'<i class="fa fa-arrow-right text-gray"></i>',
				close:'<i class="fa fa-times text-primary"></i>',
				current:'{current} of {total}',
				maxWidth:'100%',
				maxHeight:'100%',
				onOpen:function(){
					$overflow = document.body.style.overflow;
					document.body.style.overflow = 'hidden';
				},
				onClosed:function(){
					document.body.style.overflow = $overflow;
				},
				onComplete:function(){
					$.colorbox.resize();
				}
			};

			$('.thumbnail [data-rel="colorbox"]').colorbox(colorbox_params); // for enable gallery style 2

			$("#cboxLoadingGraphic").append("<i class='fa fa-spinner fa-spin'></i>");//let's add a custom loading icon for colorbox
		})
	}) // end done
} // end of get_media()

