<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class IALA_Job_Categories_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iala_job_categories_list';
	}

	public function get_title() {
		return esc_html__( 'IALA Job Categories List', 'iala-jobs' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'job', 'categories', 'list', 'iala' ];
	}

	protected function register_controls() {
		// Content tab
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Show Title', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'iala-jobs' ),
				'label_off' => esc_html__( 'Hide', 'iala-jobs' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title Text', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Job Categories', 'iala-jobs' ),
				'placeholder' => esc_html__( 'Enter your title', 'iala-jobs' ),
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label' => esc_html__( 'Hide Empty Categories', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'iala-jobs' ),
				'label_off' => esc_html__( 'No', 'iala-jobs' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'name' => esc_html__( 'Name', 'iala-jobs' ),
					'count' => esc_html__( 'Count', 'iala-jobs' ),
					'slug' => esc_html__( 'Slug', 'iala-jobs' ),
					'id' => esc_html__( 'ID', 'iala-jobs' ),
				],
				'default' => 'name',
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__( 'Ascending', 'iala-jobs' ),
					'DESC' => esc_html__( 'Descending', 'iala-jobs' ),
				],
				'default' => 'ASC',
			]
		);

		$this->add_control(
			'show_count',
			[
				'label' => esc_html__( 'Show Post Count', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'iala-jobs' ),
				'label_off' => esc_html__( 'Hide', 'iala-jobs' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'bullet_style',
			[
				'label' => esc_html__( 'Bullet Style', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'iala-jobs' ),
					'dot' => esc_html__( 'Classic Dot', 'iala-jobs' ),
					'icon' => esc_html__( 'Custom Icon', 'iala-jobs' ),
				],
				'default' => 'dot',
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Choose Icon', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'bullet_style' => 'icon',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab
		// 1. Title Styling
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-title' => 'color: {{VALUE}};',
				],
				'default' => '#0f172a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .iala-cats-widget-title',
			]
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			[
				'label' => esc_html__( 'Margin Bottom', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 15,
					'unit' => 'px',
				],
			]
		);

		$this->end_controls_section();

		// 2. List Items Styling
		$this->start_controls_section(
			'section_list_style',
			[
				'label' => esc_html__( 'List Items', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'list_tabs' );

		$this->start_controls_tab(
			'list_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'item_color',
			[
				'label' => esc_html__( 'Text Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-link' => 'color: {{VALUE}};',
				],
				'default' => '#334155',
			]
		);

		$this->add_control(
			'bullet_color',
			[
				'label' => esc_html__( 'Bullet / Icon Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-bullet' => 'color: {{VALUE}}; background-color: {{VALUE}};',
					'{{WRAPPER}} .iala-cats-widget-icon' => 'color: {{VALUE}};',
				],
				'default' => '#FF3301',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'list_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'iala-jobs' ),
			]
		);

		$this->add_control(
			'item_hover_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-item:hover .iala-cats-widget-link' => 'color: {{VALUE}};',
				],
				'default' => '#FF3301',
			]
		);

		$this->add_control(
			'bullet_hover_color',
			[
				'label' => esc_html__( 'Bullet / Icon Hover Color', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-item:hover .iala-cats-widget-bullet' => 'color: {{VALUE}}; background-color: {{VALUE}};',
					'{{WRAPPER}} .iala-cats-widget-item:hover .iala-cats-widget-icon' => 'color: {{VALUE}};',
				],
				'default' => '#FF3301',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'items_typography',
				'selector' => '{{WRAPPER}} .iala-cats-widget-link',
			]
		);

		$this->add_responsive_control(
			'item_spacing',
			[
				'label' => esc_html__( 'Space Between Items', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iala-cats-widget-item:last-child' => 'margin-bottom: 0;',
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'bullet_spacing',
			[
				'label' => esc_html__( 'Space Between Bullet & Text', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-bullet-container' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Bullet / Icon Size', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iala-cats-widget-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 6,
					'unit' => 'px',
				],
			]
		);

		$this->end_controls_section();

		// 3. Container styling
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container Box', 'iala-jobs' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'container_background',
				'label' => esc_html__( 'Background', 'iala-jobs' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iala-cats-widget-container',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'label' => esc_html__( 'Border', 'iala-jobs' ),
				'selector' => '{{WRAPPER}} .iala-cats-widget-container',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'iala-jobs' ),
				'selector' => '{{WRAPPER}} .iala-cats-widget-container',
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'iala-jobs' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .iala-cats-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$terms = get_terms( array(
			'taxonomy'   => 'job_category',
			'hide_empty' => ( $settings['hide_empty'] === 'yes' ),
			'orderby'    => $settings['orderby'],
			'order'      => $settings['order'],
		) );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			echo '<p>' . esc_html__( 'No categories found.', 'iala-jobs' ) . '</p>';
			return;
		}
		?>
		<div class="iala-cats-widget-container" style="box-sizing: border-box;">
			<?php if ( $settings['show_title'] === 'yes' && ! empty( $settings['title_text'] ) ) : ?>
				<<?php echo esc_attr( $settings['title_tag'] ); ?> class="iala-cats-widget-title" style="margin-top: 0; font-weight: 700;">
					<?php echo esc_html( $settings['title_text'] ); ?>
				</<?php echo esc_attr( $settings['title_tag'] ); ?>>
			<?php endif; ?>

			<ul class="iala-cats-widget-list" style="list-style: none; padding: 0; margin: 0;">
				<?php foreach ( $terms as $term ) : 
					$term_link = get_term_link( $term );
					if ( is_wp_error( $term_link ) ) {
						continue;
					}
					?>
					<li class="iala-cats-widget-item" style="display: flex; align-items: center;">
						<?php if ( $settings['bullet_style'] !== 'none' ) : ?>
							<span class="iala-cats-widget-bullet-container" style="display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<?php if ( $settings['bullet_style'] === 'dot' ) : ?>
									<span class="iala-cats-widget-bullet" style="border-radius: 50%; display: inline-block;"></span>
								<?php elseif ( $settings['bullet_style'] === 'icon' && ! empty( $settings['selected_icon']['value'] ) ) : ?>
									<span class="iala-cats-widget-icon">
										<?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
							</span>
						<?php endif; ?>

						<a href="<?php echo esc_url( $term_link ); ?>" class="iala-cats-widget-link" style="text-decoration: none; font-weight: 500; transition: color 0.2s ease;">
							<?php echo esc_html( $term->name ); ?>
							<?php if ( $settings['show_count'] === 'yes' ) : ?>
								<span class="iala-cats-widget-count">(<?php echo esc_html( $term->count ); ?>)</span>
							<?php endif; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}
