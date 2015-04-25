jQuery(function($){
	$("textarea#description").click(function() {
	   $(this).height(134);
	}).blur(function() {
        $(this).css('height', '56');
    });
});

jQuery(function($){
	$( "input#submit" ).addClass( "btn btn-submit" );
	$( ".list-group a" ).addClass( "list-group-item" );
});

jQuery(function($){
	$("#post_format").change(function(){
    	if($(this).val() == "quote") {
    	   $('#quote_field').removeClass('hidden');
    	} else {
    	   $('#quote_field').addClass('hidden');
    	}
		if($(this).val() == "link") {
    	   $('#link_field').removeClass('hidden');
    	} else {
    	   $('#link_field').addClass('hidden');
    	}
	});
});
jQuery(function($){
    $('form').validate({
        rules: {
            description: {
                minlength: 3,
                maxlength: 50,
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
		
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                // error.insertAfter(element.parent());
            } else {
                // error.insertAfter(element);
            }
        }
		
    });
});