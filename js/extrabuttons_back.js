jQuery( document ).ready( function( $ ) {
$(document).on('change','#qanvaeebselect',function(){
	var gotourl = $(this).val();
	window.location = 'post.php?post=' + gotourl + '&action=elementor';
});

$(document).on('click','#elclone',function(){
	$('#qanvaeeboverlay').show();
});

	function addbuttonstoelementormenu(){

		$( '.elementor-panel .elementor-panel-menu-item-exit-to-dashboard a[href]' ).eq( 0 ).prop( 'href', './');
			var qanva_select = '<div class="elementor-panel-menu-group-title qebheader">QUICKCHANGER</div>';
			qanva_select += '<div class="elementor-panel-menu-item elementor-panel-menu-item qanvaselect" style="display:none;cursor:auto;background:none;" >';
			qanva_select += '<select name="qanvaeebselect" id="qanvaeebselect"><option>' + seltext + '</option>';
			qanva_select += linkliste ;
			qanva_select += '</select>';
			qanva_select += '</div>';
			if('on' == cloning){
				qanva_select += '<input type="button" id="elclone" value="' + qanva_extrabutton_clone + '">';
			}
			if( $( '.elementor-panel .qanvaselect' ).length < 1 && 'on' == jumper){
				$( qanva_select ).insertAfter( '.elementor-panel .elementor-panel-menu-item-exit-to-dashboard' );
			}
		
		for( var i = 0; i < qanva_extrabutton_url.length; i++ ){
			var qanva_url = qanva_extrabutton_url[ i ];
			var qanva_target = qanva_extrabutton_target[ i ];
			var qanva_text = qanva_extrabutton_text[ i ]; 
			var qanva_class = qanva_text.replace(/#|-|_|\s/g, '' ).toLowerCase();
			var qanva_class_l =  $( '.elementor-panel .qanvabutton-' + qanva_class ).length;
			var eicon = 'eicon-editor-link';
			var linktitel = qanva_extrabutton_self;
			if( qanva_target == '_blank' ){ eicon = 'eicon-editor-external-link'; linktitel = qanva_extrabutton_new; }
			var qanva_html = '<div class="elementor-panel-menu-item elementor-panel-menu-item-exit-to-dashboard qanvabutton-' + qanva_class + '" style="display:none" title="' + linktitel + '"><div class="elementor-panel-menu-item-icon"><i class="' + eicon + '"></i></div><a href="' + qanva_url + '" target="' + qanva_target + '"><div class="elementor-panel-menu-item-title">' + qanva_text + '</div></a></div>';
			if( qanva_class_l < 1 ){
				$( qanva_html ).insertAfter( '.elementor-panel .elementor-panel-menu-item-exit-to-dashboard' );
			}
			$( '.qanvabutton-' + qanva_class ).eq( 1 ).remove();
			$( '.qanvabutton-' + qanva_class ).eq( 0 ).fadeIn();
		}
			$( '.qanvaselect' ).fadeIn();
	}
	var addbuttonstoelementormenucheck = setInterval( addbuttonstoelementormenu, 200 );
	
	setInterval(function(){
		if(1 == $('#qanvanewpname').length){
				var proofdash = $('#qanvanewpname').val();
				if('-' == proofdash.substring(0,1)){
					proofdash = proofdash.substring(1,proofdash.length);
				}
				proofdash = proofdash.toLowerCase().replace(/[^a-zA-Z0-9-]+/g, "");
				$('#qanvanewpname').val(proofdash);
		}
	},100);
	
				$(document).on('click','#qanvasaveperma',function(){
					var parts = window.location.href.split('?');
					var checkfordash = $('#qanvanewpname').val(); 
								if('-' == checkfordash.substring(checkfordash.length - 1)){
									insertstring = checkfordash.substring(0,checkfordash.length - 1);
									$('#qanvanewpname').val(insertstring);
								}
								var data = {
									'action': 'setnewpermaname',
									'newname': insertstring,
									'postid': parts[1].replace( /\D/g, '')
								};

								jQuery.post(ajaxurl, data, function(response) {
									// alert(response);
								});
				});

});