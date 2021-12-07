 <?php
		wp_enqueue_style( 'uikitcss', plugin_dir_url( __FILE__ ) . 'css/uikit.min.css', true, '3.6.3', 'all' );
		wp_register_script( 'quikitjs', plugin_dir_url( __FILE__ ) . 'js/uikit.min.js', ['jquery'], '3.6.3', true );
		wp_enqueue_script('quikitjs');
		
?>

<div class="wrap">
<?php

	/** sanitize alle $_POST variables **/
	$cleanedpost = [];
	if ( isset( $_POST ) ) {
		foreach( $_POST AS $key => $val ){
			$cleanedpost[ $key ] = sanitize_text_field( $val );
		}
	}
	
	if ( isset( $cleanedpost[ 'qanvasubmit' ] ) ) {
	}
	
			/* speichern */
   if ( isset( $cleanedpost[ 'qanvasubmit' ]  ) && wp_verify_nonce( $_POST[ 'qanvaproofone' ], 'qanvasubmit' ) ) {
					/** Quickchanger speichern **/
						if( isset( $cleanedpost[ 'active' ] ) && 1 == $cleanedpost[ 'active' ] ){
							update_option( 'qanva_buttons_for_elementor_select', 1 );
						}
						if( !isset( $cleanedpost[ 'active' ] ) ){
							update_option( 'qanva_buttons_for_elementor_select', 0 );
						}
					/** Clonen speichern **/
						if( isset( $cleanedpost[ 'cloneactive' ] ) && 1 == $cleanedpost[ 'cloneactive' ] ){
							update_option( 'qanva_buttons_for_elementor_clone', [1,get_option( 'qanva_buttons_for_elementor_clone' )[1]] );
						}
						if( !isset( $cleanedpost[ 'cloneactive' ] )){
							update_option( 'qanva_buttons_for_elementor_clone', [0,get_option( 'qanva_buttons_for_elementor_clone' )[1]] );
						}
					/** Clone open speichern **/
						if( isset( $cleanedpost[ 'cloneopen' ] ) && 1 == $cleanedpost[ 'cloneopen' ] ){
							update_option( 'qanva_buttons_for_elementor_clone', [get_option( 'qanva_buttons_for_elementor_clone' )[0],1] );
						}
						if( !isset( $cleanedpost[ 'cloneopen' ] ) ){
							update_option( 'qanva_buttons_for_elementor_clone', [get_option( 'qanva_buttons_for_elementor_clone' )[0],0] );
						}
				/** Links speichern **/
    $newarr = [];
				$suche = [ 'Ü','ü','Ö','ö', 'Ä', 'ä', 'ß', '*'  ];
				$ersatz = [ '&Uuml;','&uuml;','&Ouml;','&uuml;', '&Auml;', '&auml;', 'ss', '<br />' ];
						if( ( !empty( $cleanedpost[ 'pagetarget' ] ) || !empty( $cleanedpost[ 'pagetargettext' ] ) ) && !empty( $cleanedpost[ 'pagename' ] ) ){
							$new_arr[] = [ $cleanedpost[ 'pagetarget' ] . $cleanedpost[ 'pagetargettext' ] , $cleanedpost[ 'linktarget' ] , str_replace( $suche, $ersatz, $cleanedpost[ 'pagename' ] ) ] ;
																								
								$old_arr = get_option( 'qanva_buttons_for_elementor' );
								if( !empty( $old_arr ) ){
												$old_arr = array_merge( $old_arr, $new_arr );
								}
								else{
												$old_arr = $new_arr;
								}
									update_option( 'qanva_buttons_for_elementor', $old_arr );
				}
	}
	
	/* Links löschen */
 if ( isset( $cleanedpost[ 'deleter' ]  ) && wp_verify_nonce( $_POST[ 'qanvaprooftwo' ], 'qanvasubmitb' ) ) {
		$old_arr = get_option( 'qanva_buttons_for_elementor' ); 
			unset( $old_arr[ $cleanedpost[ 'deleter' ][0] ] );
				update_option( 'qanva_buttons_for_elementor', $old_arr );
	}
		
	if( '' != get_option( 'qanva_buttons_for_elementor' ) ){
		$savevalues =  get_option( 'qanva_buttons_for_elementor' );
	}
	
	$clonesel = '';
	$cloneop = '';
	if( '' != get_option( 'qanva_buttons_for_elementor_clone' ) ){
		$clonevalues =  get_option( 'qanva_buttons_for_elementor_clone' );
		if(1 == $clonevalues[0]){
			$clonesel = 'checked';
		}
		if(1 == $clonevalues[1]){
			$cloneop = 'checked';
		}
	}
	
	/** verlinkbare Optionen **/
		function qanvaebe_get_links(){
				global $menu;
				global $submenu;
						$reval = '';
						$allposts = get_posts();
						$allpages = get_pages( [ 'post_type' => 'page', 'sort_column' => 'ID','post_status' => 'publish,draft' ] );
						$alltemplates = new WP_Query( ['post_type' => 'elementor_library' ] ); 
						$mainlinks = [];
						$mainname = [];
						foreach( $menu AS $key => $vala ){
							if( '' != $vala[ 0 ] ){
								array_push( $mainlinks, $vala[ 2 ] );
								array_push( $mainname, preg_replace( '/[0-9]+/', '', $vala[ 0 ] ) );
							}
						}
		for( $i = 0; $i < count( $mainlinks ); $i++ ){;
			$name = $mainname[ $i ]; 
			if( array_key_exists( $mainlinks[ $i ], $submenu ) ){
				foreach( $submenu[ $mainlinks[ $i ] ] AS $key => $val ){ 
					$subname = $val[ 0 ];
					$target = $val[ 2 ];
					if( '' != $subname ){
						$reval .= '<option value="' . $target . '">' . __( $name ) . ' &rarr; ' . __( preg_replace( '/[0-9]+/', '', $subname ) ) . '</option>'; 
					}
					if( $target == 'edit.php' ){
						for( $x = 0; $x < count( $allposts ); $x++ ){
							$reval .= '<option value="post.php?post=' . $allposts[ $x ] -> ID . '&action=elementor">' . __( $name ) . ' &rarr; '  . ucfirst( __( 'post' ) ) . '-' . __( 'Name' ) . ' &rarr; ' . ucfirst( __( $allposts[ $x ] -> post_name ) ) . '</option>'; 
						}
					}
					if( $target == 'edit.php?post_type=page' ){
						for( $y = 0; $y < count( $allpages ); $y++ ){ 
							$reval .= '<option value="post.php?post=' . $allpages[ $y ] -> ID . '&action=elementor">' . __( $name ) . ' &rarr; '  . ucfirst( __( 'page' ) ) . '-'  . __( 'Name' ) . ' &rarr; ' . ucfirst( __( $allpages[ $y ] -> post_name ) ) . '</option>'; 
						}
					}
					if( strpos( $target, 'tabs_group=library' ) !== false ){
						for( $z = 0; $z < count( $alltemplates -> posts ); $z++ ){ 
							if( 'standard-kit' != $alltemplates -> posts[ $z ] -> post_name ){
								$reval .= '<option value="post.php?post=' . $alltemplates -> posts[ $z ] -> ID . '&action=elementor">' . __( $name ) . ' &rarr; '  . ucfirst( __( 'templates' ) ) . '-'  . __( 'Name' ) . ' &rarr; ' . ucfirst( __( $alltemplates -> posts[ $z ] -> post_name ) ) . '</option>'; 
							}
						}
					}
				}
			}
			else{
				$target = $mainlinks[ $i ];
				if( strpos( $target, 'php' ) < 1 ){
					$target = './admin.php?page=' . preg_replace( '/[0-9]+/', '', $name );
				}
				if( $target == 'edit-comments.php' ){
					$name = __( 'Comments' );
				}
				$reval .= '<option value="' . $target . '">' . __( $name ) .'</option>'; 
			}
					
		}		

		return $reval;
	}

?>

	<script type="text/javascript">
	window.addEventListener( 'load', function(){
		document.getElementById( 'wpfooter' ).remove();
		document.getElementsByTagName("title")[0].text = 'Powertools Settings';
	});
	
	jQuery( document ).ready( function( $ ) {
		$( 'select[name=pagetarget]' ).on( 'change', function(){
			if( $( this ).val() != '' ){
				$( 'input[name=pagetargettext]' ).hide();
			}
			else{
				$( 'input[name=pagetargettext]' ).show();
			}
		});
		
		$( 'input[name=pagetargettext]' ).on( 'change keyup', function(){
			if( $( this ).val() != '' ){
				$( 'select[name=pagetarget]' ).hide();
			}
			else{
				$( 'select[name=pagetarget]' ).show();
			}
		});
		
		$( '#switch-1' ).on( 'change', function(){
			if( $( this ).is( ':checked' ) ){
				$( "#switch-1" ).prop( "checked", true );
			}
			else{
				$( "#switch-1" ).prop( "checked", false );
			}
		});
		
		<?php 
			if( 1 == get_option( 'qanva_buttons_for_elementor_select' ) ){
		?>
				$( "#switch-1" ).prop( "checked", true );
		<?php		
			}
			else{
		?>
				$( "#switch-1" ).prop( "checked", false );
		<?php				
			}
		?>
		setInterval(function(){$('[class*="notice"],[class*="error"]').remove();},200);
	});
	</script>

<form id="qanvaebeform" method="post" action="">
<?php wp_nonce_field( 'qanvasubmit', 'qanvaproofone' ); ?>
</form>
<form id="qanvaebeformb" method="post" action="">
<?php wp_nonce_field( 'qanvasubmitb', 'qanvaprooftwo' ); ?>
</form>
<div class="qanva uk-container-center uk-margin-top uk-margin-large-bottom">
<h1><img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/qanvalogo.svg" class="logo">Qanva <?php _e( "Extra Menu-Buttons, page cloning and special settings for Elementor", "qanva-powertools-for-elementor" ); ?>*</h1>
        <div class="uk-grid uk-margin-remove-left uk-margin-right" data-uk-grid-margin>
            <div class="uk-width-1-3 uk-card uk-card-default uk-card-body">
<h4><?php _e( "Settings", "qanva-powertools-for-elementor" ); ?></h4>
<?php _e( "With this widget to add extra menu buttons and a select to Elementor", "qanva-powertools-for-elementor" ); ?>.
<hr>
<?php _e( "Select a target or enter a individual link", "qanva-powertools-for-elementor" ); ?>:
<br>
			<select class="uk-form-small uk-width-1-1" name="pagetarget" form="qanvaebeform" autocomplete="off" >
					<option value=''><?php _e( "Please choose a target", "qanva-powertools-for-elementor" );?></option>
					<?php echo qanvaebe_get_links(); ?>
			</select>
		<p>
		<input type="text" name="pagetargettext" form="qanvaebeform"  class="uk-input uk-form-small uk-width-1-1" placeholder="<?php _e( "Individual link", "qanva-powertools-for-elementor" ); ?>"  autocomplete="off"/>
		</p>
		<p>
		<?php _e( "Give your link a name", "qanva-powertools-for-elementor" ); ?>:
		<br>
		<input type="text" name="pagename" form="qanvaebeform"  class="uk-input uk-form-small uk-width-1-1" placeholder="<?php _e( "Linkname", "qanva-powertools-for-elementor" ); ?>" autocomplete="off"/>
		</p>
		<p>
		<?php _e( "Same window", "qanva-powertools-for-elementor" ); ?>:&nbsp;<input type="radio" name="linktarget" form="qanvaebeform"  class="uk-radio" value="_self" checked />
		<?php _e( "or new one", "qanva-powertools-for-elementor" ); ?>:&nbsp;<input type="radio" name="linktarget" form="qanvaebeform"  class="uk-radio" value="_blank" />
		</p>
		<hr>
		<h5><?php _e( "Enable \"Quickchanger\" in Elementor", "qanva-powertools-for-elementor" ); ?></h5>
		<div class="switchbox  uk-width-1-1">
		<label for="switch-1" class="switch">
   <input type="checkbox" id="switch-1" name="active" class="uk-switch"  form="qanvaebeform" value="1" autocomplete="off">
			<span class="slider round"></span>
  </label>
		</div>
		<span class="small red"><?php _e( " Notice", "qanva-powertools-for-elementor" ); ?>:</span><br><span class="small"><?php _e( " \"Quickchanger\" is a dropdown link-list to post, pages, landing-pages and templates.", "qanva-powertools-for-elementor" ); ?></span>
		<hr>
		<h5><?php _e( "Enable cloning of pages,posts and templates in Elementor", "qanva-powertools-for-elementor" ); ?></h5>
		<div class="switchbox  uk-width-1-1">
		<label for="switch-2" class="switch">
  	<input type="checkbox" id="switch-2" name="cloneactive" class="uk-switch"  form="qanvaebeform" value="1" autocomplete="off" <?php echo esc_attr($clonesel);?>>
			<span class="slider round"></span>
  </label>
		</div>
		<h5><?php _e( "Open cloned page/post/template directly", "qanva-powertools-for-elementor" ); ?></h5>
		<div class="switchbox  uk-width-1-1">
		<label for="switch-3" class="switch">
   <input type="checkbox" id="switch-3" name="cloneopen" class="uk-switch"  form="qanvaebeform" value="1" autocomplete="off" <?php echo esc_attr($cloneop);?>>
			<span class="slider round"></span>
   </label>
		</div>
<hr>
		<p>
		<button type="submit" name="qanvasubmit" form="qanvaebeform"  class="uk-button uk-button-primary uk-form-small uk-width-1-1" ><?php _e( "Save", "qanva-powertools-for-elementor" ); ?></button>
		</p>
* Elementor is the trademark of elementor.com  This project is <strong class="red">NOT</strong> affiliated with Elementor!
<style>

</style>
</div>  

		    
				<div class="uk-width-2-3 uk-card uk-card-default uk-card-body qanvaexample">
					<!-- content right -->
					<?php 
						if ( !empty( $savevalues ) ) {
							foreach( $savevalues AS $key => $val ){
								echo '<button type="submit" name="deleter" value="' . esc_attr($key) . '" form="qanvaebeformb" class="uk-button uk-button-danger uk-form-small uk-width-1-3 uk-margin-small-top" >' . __( 'Delete' ) . ' &rarr; ' . esc_attr($val[ 2 ]) . '</button><br>';
							}
							
						}
					?>
				</div>
		</div>  
		<div class="uk-text-right uk-text-meta uk-text-small uk-margin-right"><small>&copy; <?php echo date( "Y");?> <a href="https://qanva.tech" target="_blank" class="uk-link-text" >QANVA.TECH</a> All rights reserved.</small></div>
</div>
</div>

