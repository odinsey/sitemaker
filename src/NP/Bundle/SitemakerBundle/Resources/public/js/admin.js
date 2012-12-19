jQuery(document).ready(function(){
	jQuery('.form-horizontal .page-collections .collection-field-row:before').css({
		'content': jQuery('input[id$=menu_title]',this).val()
	});
	jQuery('.collection-field-row > div').hide();
	jQuery('.collection-field-row').bind('click',function(){
		jQuery('> div', this).show();
		jQuery('.collection-field-row').not(this).find('>div').hide();		
	});
		jQuery('input.colorpicker').colorpicker().on('changeColor', function(ev){
		  jQuery(this).css( 'background-color', ev.color.toHex() );
		});;
});