<?php
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;


class Qanvapowerusertoolscontrols{

	public static function start(){
		add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ __CLASS__,'qanvapowertoolcontrols'], 1 );
	#	add_action( 'elementor/element/wp-post/document_settings/before_section_end', [ __CLASS__,'qanvapowertoolcontrols'], 10,2 );
	}
	
	public static function qanvapowertoolcontrols( \Elementor\Core\DocumentTypes\PageBase $page ){
#	public function qanvapowertoolcontrols( Element_Base $page ){
			global $post;
			
			$page->start_controls_section(
			'qanva_poweruser',
			[
				'label' => 'Poweruser tools',
				'tab' => Controls_Manager::TAB_SETTINGS,
			]
		);

				$page->add_control(
					'qanva_pt_use',
					[
						'label' => __( 'Remove widget names', 'qanva-powertools-for-elementor' ), 
						'description' => __( 'Remove widget names to save space.', 'qanva-powertools-for-elementor' ), 
						'separator' => '', 
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'qanva-powertools-for-elementor' ),
						'label_off' => __( 'No', 'qanva-powertools-for-elementor' ),
						'return_value' => 'yes',
						'default' => 'no',
						'frontend_available' => false,
					]
				);	
			
				$page->add_control(
					'qanva_pt_use_tt',
					[
						'label' => __( 'Tooltip widget names', 'qanva-powertools-for-elementor' ), 
						'description' => __( 'Show widget names as tooltip.', 'qanva-powertools-for-elementor' ), 
						'separator' => 'after', 
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'qanva-powertools-for-elementor' ),
						'label_off' => __( 'No', 'qanva-powertools-for-elementor' ),
						'return_value' => 'yes',
						'default' => 'no',
						'frontend_available' => false,
						'condition' => [
									'qanva_pt_use' => 'yes', 
								],
					]
				);	

				$page->add_control(
					'qanva_pt_width',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => '<div style="margin-top:5px;width:47%;float:left;">' . __( 'Widget column count', 'qanva-powertools-for-elementor' ) . '</div><div id="qanva_pt_width_after"><select id="qanva_pt_width" onchange="ptwidthchange(this.value,\'x\')"><option value="2" selected>standard</option><option value="3">3</option><option value="4">4</option></select><i class="eicon-sort-down" id="qanva_pt_width_after_icon"></i></div>',
					]
				);		
			
				$page->add_control(
					'qanva_pt_rem_wp',
					[
						'label' => __( 'Remove WP widgets', 'qanva-powertools-for-elementor' ), 
						'description' => __( 'Remove the WordPress widgets from Elementor editor.', 'qanva-powertools-for-elementor' ), 
						'separator' => 'before', 
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'qanva-powertools-for-elementor' ),
						'label_off' => __( 'No', 'qanva-powertools-for-elementor' ),
						'return_value' => 'yes',
						'default' => 'no',
						'frontend_available' => false,
					]
				);	
				
				$page->add_control(
					'qanva_pt_tipp',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => "<script id='tta'>setInterval(function(){
							if(document.querySelector('[data-setting=\"qanva_pt_use\"]') !== null && document.querySelector('[data-setting=\"qanva_pt_use_tt\"]') !== null){if(document.querySelector('[data-setting=\"qanva_pt_use\"]').checked === true && document.querySelector('[data-setting=\"qanva_pt_use_tt\"]').checked === true && 
							localStorage.getItem('qanva_powertools_tt') === null){ 
								localStorage.setItem('qanva_powertools_tt','yes');
							}
							if(document.querySelector('[data-setting=\"qanva_pt_use_tt\"]').checked === false || document.querySelector('[data-setting=\"qanva_pt_use\"]').checked === false){
								localStorage.removeItem('qanva_powertools_tt');
							};
						}},200);</script><style>#qanva_pt_width{appearance:none;-webkit-appearance:none;float:right;padding: 0 0 0 5px;} #qanva_pt_width_after{width:52%;height:27px;position:relative;float:right}#qanva_pt_width_after_icon{position:absolute;right:6px;top:6px}</style>",
					]
				);		

				$page->add_control(
					'control_qpt_id',
					[
						'label' => __( 'Set Page Permalink', 'qanva-powertools-for-elementor' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
					
				$page->add_control(
					'qanva_qpt_perma',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => '<div id="qanvaeebwrapper"><input type="text" pattern="[a-z0-9]{2,}[-][a-z0-9]{1,}" value="' . $post->post_name . '" name="qanvanewpname" id="qanvanewpname"><input type="submit" id="qanvasaveperma" value="' . __( 'Save', 'qanva-powertools-for-elementor' ) . '"><div id="qptistsaved"></div></div>',
					]
				);

				$page->add_control(
					'control_qpt_fav',
					[
						'label' => __( 'Save your favorites', 'qanva-powertools-for-elementor' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
					
				$page->add_control(
					'qanva_qpt_email',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => '<input type="email" value="" name="qanvaptmail" id="qanvaptmail" placeholder="' . __( 'Your email', 'qanva-powertools-for-elementor' ) . '">',
					]
				);

				$page->add_control(
					'qanva_qpt_pw',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => '<input type="text" pattern="[a-zA-Z0-9]{8}" value="" name="qanvaptpw" id="qanvaptpw" placeholder="' . __( 'Your password', 'qanva-powertools-for-elementor' ) . '"><br><button id="qanvasavefav">' . __( 'Save', 'qanva-powertools-for-elementor' ) . '</button>',
					]
				);				
				$page->end_controls_section();
	}
}
?>