<?php
/**
 * The template for displaying typography.tpl.php
 *
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$field_class   = implode( ' ', array_filter( $field_classes ) );
$font_actives  = GSF_Core_Fonts::getInstance()->getActiveFonts();
$current_font  = array();

$unparse_value = $value;

$value         = json_decode( urldecode($value), true );

if ( ! is_array( $value ) ) {
	$value = array();
}

$value = wp_parse_args( $value, array(
	'font_family'    => '',
	'font_weight'    => '',
	'font_style'     => '',
	'font_size_lg'   => '',
	'font_size_md'   => '',
	'font_size_sm'   => '',
	'font_size_xs'   => '',
	'align'          => '',
	'text_transform' => '',
	'line_height'    => '',
	'letter_spacing' => '',
	'color'          => '',
	'hover_color'    => ''
));

$aligns = array(
	''        => esc_html__( 'Default', 'g5-element' ),
	'initial' => esc_html__( 'Initial', 'g5-element' ),
	'inherit' => esc_html__( 'Inherit', 'g5-element' ),
	'left'    => esc_html__( 'Left', 'g5-element' ),
	'center'  => esc_html__( 'Center', 'g5-element' ),
	'right'   => esc_html__( 'Right', 'g5-element' ),
	'justify' => esc_html__( 'Justify', 'g5-element' ),
);

$text_transforms = array(
	''           => esc_html__( 'Default', 'g5-element' ),
	'none'       => esc_html__( 'None', 'g5-element' ),
	'capitalize' => esc_html__( 'Capitalize', 'g5-element' ),
	'lowercase'  => esc_html__( 'Lowercase', 'g5-element' ),
	'uppercase'  => esc_html__( 'Uppercase', 'g5-element' ),
	'initial'    => esc_html__( 'Initial', 'g5-element' ),
	'inherit'    => esc_html__( 'Inherit', 'g5-element' ),
);
$size_types      = array(
	'lg' => esc_html__( 'Large', 'g5-element' ),
	'md' => esc_html__( 'Medium', 'g5-element' ),
	'sm' => esc_html__( 'Small', 'g5-element' ),
	'xs' => esc_html__( 'Extra small', 'g5-element' ),
);

?>
<div class="g5element-field-typography-wrapper">
	<input type="hidden" name="<?php echo esc_attr( $settings['param_name'] ) ?>"
	       class="<?php echo esc_attr( $field_class ) ?>"
	       value="<?php echo esc_attr($unparse_value) ?>">
	<div class="g5element-field-typography-row">
		<div class="g5element-field-typography-font-family">
			<span><?php esc_html_e( 'Font Family', 'g5-element' ) ?></span>
			<div>
				<select data-element-name="font_family">
					<option value="" <?php g5element_attr_the_selected( '', $value['font_family'] ) ?>><?php esc_html_e( 'Default', 'g5-element' ) ?></option>
					<?php foreach ( $font_actives as $font ): ?>
						<?php if ( $font['family'] === $value['font_family'] ) {
							$current_font = $font;
						} ?>
						<option value="<?php echo esc_attr( $font['family'] ) ?>"
						        data-font-variants="<?php echo esc_attr( join( '|', $font['variants'] ) ); ?>"
							<?php g5element_attr_the_selected( $font['family'], $value['font_family'] ) ?>>
							<?php echo esc_html( $font['family'] ) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="g5element-field-typography-variants">
			<span><?php esc_html_e( 'Font Weight & Style', 'g5-element' ) ?></span>
			<div>
				<input type="hidden" data-element-name="font_weight"
				       value="<?php echo esc_attr( $value['font_weight'] ); ?>"/>
				<input type="hidden" data-element-name="font_style"
				       value="<?php echo esc_attr( $value['font_style'] ); ?>"/>
				<select class="g5element-field-typography-variants-select">
					<option value="" <?php g5element_attr_the_selected( '', $value['font_weight'] . $value['font_style'] ) ?>><?php esc_html_e( 'Default', 'g5-element' ) ?></option>
					<?php if ( is_array( $current_font ) && isset( $current_font['variants'] ) ): ?>
						<?php foreach ( $current_font['variants'] as $variant ): ?>
							<option value="<?php echo esc_attr( $variant ); ?>"
								<?php g5element_attr_the_selected( $variant,
									($value['font_weight'] === '400') && ($value['font_style'] === 'italic')
										? 'italic'
										: $value['font_weight'] . ($value['font_style'] === 'normal' ? '' : 'italic' )) ?>><?php echo esc_html( $variant ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
	</div>
	<div class="g5element-field-typography-row">
		<div class="g5element-field-typography-font-size">
			<span><?php esc_html_e( 'Font Size', 'g5-element' ); ?></span>
			<div class="g5element-vc_number-responsive-inner">
				<?php foreach ( $size_types as $key => $size ) : ?>
					<div class="vc_screen-size vc_screen-size-<?php echo esc_attr( $key ) ?>">
						<?php $icon = '';
						$index      = array_search( $key, array_keys( $size_types ) );
						switch ( $key ) {
							case 'md':
								$icon = 'landscape-tablets';
								break;
							case 'sm':
								$icon = 'portrait-tablets';
								break;
							case 'xs':
								$icon = 'landscape-smartphones';
								break;
							default:
							case 'lg':
								$icon = 'default';
								break;
						} ?>
						<label title="<?php echo esc_attr( $size ) ?>">
							<i class="vc-composer-icon vc-c-icon-layout_<?php echo esc_attr( $icon ) ?>"></i>
						</label>
						<input type="number" data-element-name="font_size_<?php echo esc_attr( $key ); ?>"
						       value="<?php echo esc_attr( $value[ 'font_size_' . $key ] ) ?>"
						       class="g5element-vc-number-responsive-field">
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="g5element-field-typography-row">
		<div class="g5element-field-typography-align">
			<span><?php esc_html_e( 'Align', 'g5-element' ); ?></span>
			<select data-element-name="align">
				<?php foreach ( $aligns as $align_key => $align_value ): ?>
					<option value="<?php echo esc_attr( $align_key ); ?>"
						<?php selected( $align_key, $value['align'] ); ?>><?php echo esc_html( $align_value ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="g5element-field-typography-text-transform">
			<span><?php esc_html_e( 'Text Transform', 'g5-element' ); ?></span>
			<select data-element-name="text_transform">
				<?php foreach ( $text_transforms as $text_transform_key => $text_transform_value ): ?>
					<option value="<?php echo esc_attr( $text_transform_key ); ?>"
						<?php selected( $text_transform_key, $value['text_transform'] ); ?>><?php echo esc_html( $text_transform_value ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="g5element-field-typography-row">
		<div class="g5element-field-typography-line-height">
			<span><?php esc_html_e( 'Line Height', 'g5-element' ); ?></span>
			<input type="text" data-element-name="line_height" value="<?php echo esc_attr( $value['line_height'] ); ?>">
		</div>
		<div class="g5element-field-typography-letter-spacing">
			<span><?php esc_html_e( 'Letter Spacing', 'g5-element' ); ?></span>
			<input type="text" data-element-name="letter_spacing"
			       value="<?php echo esc_attr( $value['letter_spacing'] ); ?>">
		</div>
	</div>
	<div class="g5element-field-typography-row">
		<div class="g5element-field-typography-color">
			<span><?php esc_html_e( 'Text Color', 'g5-element' ); ?></span>
			<?php
			if ($value['color'] === '') {
				$color_name = '';
				$color_code = '';
			}
			else if (g5core_is_color($value['color'])) {
				$color_name = 'custom';
				$color_code = $value['color'];
			}
			else {
				$color_name = $value['color'];
				$color_code = '';
			}
			?>
			<input type="hidden" data-element-name="color" value="<?php echo esc_attr($value['color']) ?>">
			<div class="g5element-vc_gel_color-inner">
				<div class="g5element-vc_gel_color-select" data-vc-shortcode="">
					<select class="gel-colored-dropdown vc_colored-dropdown">
						<?php foreach (G5CORE()->settings()->get_color_list() as $key => $title): ?>
							<option value="<?php echo esc_attr($key) ?>" <?php echo $key === '' ? '' : 'class="' . esc_attr($key) . '"' ?><?php selected($key, $color_name) ?>><?php echo esc_html($title) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="g5element-vc_gel_color-color"<?php echo $color_name !== 'custom' ? ' style="display:none"' : '' ?>>
					<input type="text"
					       maxlength="22"
					       pattern="^((#(([a-fA-F0-9]{6})|([a-fA-F0-9]{3})))|(rgba\(\d+,\d+,\d+,\d?(\.\d+)*\)))$"
					       data-alpha="true"
					       value="<?php echo esc_attr( $color_code ); ?>">
				</div>
			</div>
		</div>
		<div class="g5element-field-typography-color">
			<span><?php esc_html_e( 'Text Hover Color', 'g5-element' ); ?></span>
			<?php
			if ($value['hover_color'] === '') {
				$color_name = '';
				$color_code = '';
			}
			else if (g5core_is_color($value['hover_color'])) {
				$color_name = 'custom';
				$color_code = $value['hover_color'];
			}
			else {
				$color_name = $value['hover_color'];
				$color_code = '';
			}
			?>
			<input type="hidden" data-element-name="hover_color" value="<?php echo esc_attr($value['hover_color']) ?>">
			<div class="g5element-vc_gel_color-inner">
				<div class="g5element-vc_gel_color-select" data-vc-shortcode="">
					<select class="gel-colored-dropdown vc_colored-dropdown">
						<?php foreach (G5CORE()->settings()->get_color_list() as $key => $title): ?>
							<option value="<?php echo esc_attr($key) ?>" <?php echo $key === '' ? '' : 'class="' . esc_attr($key) . '"' ?><?php selected($key, $color_name) ?>><?php echo esc_html($title) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="g5element-vc_gel_color-color"<?php echo $color_name !== 'custom' ? ' style="display:none"' : '' ?>>
					<input type="text"
					       maxlength="22"
					       pattern="^((#(([a-fA-F0-9]{6})|([a-fA-F0-9]{3})))|(rgba\(\d+,\d+,\d+,\d?(\.\d+)*\)))$"
					       data-alpha="true"
					       value="<?php echo esc_attr( $color_code ); ?>">
				</div>
			</div>
		</div>
	</div>
</div>
