<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class IALA_Job_Search_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iala_job_search_bar';
	}

	public function get_title() {
		return esc_html__( 'IALA Job Search Bar', 'iala-jobs' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'job', 'search', 'bar', 'filter', 'iala' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Search Fields', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label' => esc_html__( 'Placeholder Text', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Search Here', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Search', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'label' => esc_html__( 'Redirect to Job Board Page URL', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Leave empty to submit on the same page', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'param_name',
			[
				'label' => esc_html__( 'Query Parameter Name', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'job_search',
			]
		);

		$this->end_controls_section();

		// Style Tab
		// 1. Container Style
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container Box', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_max_width',
			[
				'label' => esc_html__( 'Max Width', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_alignment',
			[
				'label' => esc_html__( 'Alignment', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'iala-jobs' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'iala-jobs' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'iala-jobs' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-wrapper' => 'margin-left: {{VALUE}}; margin-right: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'left' => '0 auto 0 0',
					'center' => '0 auto',
					'right' => '0 0 0 auto',
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'container_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-form' => 'background-color: {{VALUE}};',
				],
				'default' => '#ffffff',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'label' => esc_html__( 'Border', 'iala-jobs' ),
				'selector' => '{{WRAPPER}} .iala-job-search-form',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '8',
					'right' => '8',
					'bottom' => '8',
					'left' => '8',
					'unit' => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'iala-jobs' ),
				'selector' => '{{WRAPPER}} .iala-job-search-form',
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '6',
					'right' => '6',
					'bottom' => '6',
					'left' => '16',
					'unit' => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->end_controls_section();

		// 2. Input Field Style
		$this->start_controls_section(
			'section_input_style',
			[
				'label' => esc_html__( 'Input Field', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label' => esc_html__( 'Text Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-input' => 'color: {{VALUE}};',
				],
				'default' => '#334155',
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-input::placeholder' => 'color: {{VALUE}};',
				],
				'default' => '#94a3b8',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} .iala-job-search-input',
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '8',
					'right' => '8',
					'bottom' => '8',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->end_controls_section();

		// 3. Button Style
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Search Button', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-submit' => 'color: {{VALUE}};',
				],
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-submit' => 'background-color: {{VALUE}};',
				],
				'default' => '#0284c7',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-submit:hover' => 'color: {{VALUE}};',
				],
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => esc_html__( 'Background Hover Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-submit:hover' => 'background-color: {{VALUE}};',
				],
				'default' => '#0369a1',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .iala-job-search-submit',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '6',
					'right' => '6',
					'bottom' => '6',
					'left' => '6',
					'unit' => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-job-search-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '10',
					'right' => '24',
					'bottom' => '10',
					'left' => '24',
					'unit' => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-search-btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-search-btn-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$placeholder = ! empty( $settings['placeholder'] ) ? $settings['placeholder'] : esc_html__( 'Search Here', 'iala-jobs' );
		$btn_text = $settings['button_text'];
		$icon = $settings['button_icon'];
		$param_name = ! empty( $settings['param_name'] ) ? $settings['param_name'] : 'job_search';
		
		// If redirect URL is provided, use it; otherwise fallback to Selected Jobs Board Page URL or current page URL
		$redirect_url = ! empty( $settings['redirect_url'] ) ? esc_url( $settings['redirect_url'] ) : '';
		if ( empty( $redirect_url ) ) {
			$internships_page_id = get_option( 'iala_jobs_internships_page_id', 0 );
			if ( ! empty( $internships_page_id ) && is_page( $internships_page_id ) ) {
				$redirect_url = get_permalink( $internships_page_id );
			} else {
				$board_page_id = get_option( 'iala_jobs_board_page_id', 0 );
				if ( ! empty( $board_page_id ) ) {
					$redirect_url = get_permalink( $board_page_id );
				}
			}
			if ( empty( $redirect_url ) ) {
				$redirect_url = esc_url( home_url( add_query_arg( null, null ) ) );
				// Strip query params if they exist to prevent accumulation
				$redirect_url = strtok( $redirect_url, '?' );
			}
		}

		$current_search = isset( $_GET[ $param_name ] ) ? sanitize_text_field( $_GET[ $param_name ] ) : '';
		?>
		<div class="iala-job-search-wrapper" style="box-sizing: border-box; width: 100%;">
			<form method="get" action="<?php echo esc_url( $redirect_url ); ?>" class="iala-job-search-form" style="display: flex; align-items: center; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; outline: none; transition: border-color 0.2s ease;">
				<input type="text" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $current_search ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" class="iala-job-search-input" style="flex-grow: 1; border: none; outline: none; background: transparent; font-family: inherit; font-size: 1rem;" />
				<button type="submit" class="iala-job-search-submit" style="border: none; outline: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-family: inherit; font-weight: 600; transition: background-color 0.2s ease, color 0.2s ease;">
					<?php if ( ! empty( $icon['value'] ) ) : ?>
						<span class="iala-search-btn-icon" style="line-height: 1; display: inline-block;">
							<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
						</span>
					<?php endif; ?>
					<?php if ( ! empty( $btn_text ) ) : ?>
						<span class="iala-search-btn-text" style="line-height: 1; display: inline-block;">
							<?php echo esc_html( $btn_text ); ?>
						</span>
					<?php endif; ?>
				</button>
			</form>
		</div>
		<?php
	}
}
