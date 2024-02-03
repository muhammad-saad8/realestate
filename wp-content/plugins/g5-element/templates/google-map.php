<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $values
 * @var $address
 * @var $title
 * @var $description
 * @var $map_height
 * @var $map_height_lg
 * @var $map_height_md
 * @var $map_height_sm
 * @var $map_height_xs
 * @var $image
 * @var $image_marker
 * @var $map_zoom
 * @var $zoom_mouse_wheel
 * @var $marker_effect
 * @var $color_effect1
 * @var $color_effect2
 * @var $map_style
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Heading
 */
$address = $title = $description = $image = $image_marker = $map_zoom = $zoom_mouse_wheel = $marker_effect = '';
$map_style = $image_size = $icon_type = $icon = $image = $image_marker = $color_effect1 = $color_effect2 = '';
$values = $map_height = $map_height_lg = $map_height_md = $map_height_sm = $map_height_xs = $el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('google_map');

$wrapper_classes = array(
	'gel-google-map',
	$this->getExtraClass($el_class),
	vc_shortcode_custom_css_class($css),
);
$wrapper_class = implode(' ', array_filter($wrapper_classes));
$google_map_class = 'gel' . uniqid();
$google_map_css = '';
if ($map_height !== '') {
	$google_map_css .= <<<CSS
	.{$google_map_class}{
		height: {$map_height}px;
	}
CSS;
}
if ($map_height_lg !== '') {
	$google_map_css .= <<<CSS
	    @media (max-width: 1199px) {
	        .{$google_map_class}{
				height: {$map_height_lg}px;
			}
	    }
CSS;
}
if ($map_height_md !== '') {
	$google_map_css .= <<<CSS
		@media (max-width: 991px) {
			.{$google_map_class}{
				height: {$map_height_md}px;
			}
		}
CSS;
}
if ($map_height_sm !== '') {
	$google_map_css .= <<<CSS
		@media (max-width: 767px) {
			.{$google_map_class}{
				height: {$map_height_sm}px;
			}
        }
CSS;
}

if ($map_height_xs !== '') {
	$google_map_css .= <<<CSS
		@media (max-width: 575px) {
			.{$google_map_class}{
				height: {$map_height_xs}px;
			}
		}
CSS;
}

if ($marker_effect == 'on' && $color_effect1 != ''):
	if (!g5core_is_color($color_effect1)) {
		$color_effect1 = g5core_get_color_from_option($color_effect1);
	}
	$google_map_css .= <<<CSS
	.{$google_map_class} .gel-map-point-animate::before{
		-webkit-box-shadow: inset 0 0 35px 10px $color_effect1;
		box-shadow: inset 0 0 35px 10px $color_effect1;
	}
CSS;
endif;
if ($marker_effect == 'on' && $color_effect2 != ''):
	if (!g5core_is_color($color_effect2)) {
		$color_effect2 = g5core_get_color_from_option($color_effect2);
	}
	$google_map_css .= <<<CSS
	.{$google_map_class} .gel-map-point-animate::after{
		-webkit-box-shadow: inset 0 0 35px 10px $color_effect2;
		box-shadow: inset 0 0 35px 10px $color_effect2;
	}
CSS;
endif;

if ($google_map_css != ''):
	$wrapper_classes[] = $google_map_class;
	G5Core()->custom_css()->addCss($google_map_css);
endif;

$google_map_api_key = G5CORE()->options()->get_option('google_map_api_key');

wp_enqueue_script('google-map', '//maps.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($google_map_api_key), array('jquery'), '1.0', false);
$map_style_snippet = '';
switch ($map_style) {
	case 'theme':
		$map_style_snippet = '[{"featureType":"all","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#f3f2ee"}]},{"featureType":"poi.attraction","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.business","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.government","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.medical","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c9dfb0"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.school","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"poi.sports_complex","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#e5e5e1"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#e5e5e1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#141414"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#fefd89"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#a6c0db"}]}]';
		break;
	case 'light':
		$map_style_snippet = '[{"featureType":"all","elementType":"geometry.fill","stylers":[{"weight":"2.00"}]},{"featureType":"all","elementType":"geometry.stroke","stylers":[{"color":"#9c9c9c"}]},{"featureType":"all","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#f1f0ef"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#7b7b7b"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#edf7fb"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#edf7fb"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#070707"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]}]';
		break;
	case 'cool-grey':
		$map_style_snippet = '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]';
		break;
	case 'sliver':
		$map_style_snippet = '[{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]';
		break;
	case 'retro':
		$map_style_snippet = '[{"elementType":"geometry","stylers":[{"color":"#ebe3cd"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#523735"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f1e6"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c9b2a6"}]},{"featureType":"administrative.land_parcel","elementType":"geometry.stroke","stylers":[{"color":"#dcd2be"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#ae9e90"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#93817c"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#a5b076"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#447530"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#fdfcf8"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#f8c967"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#e9bc62"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#e98d58"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.stroke","stylers":[{"color":"#db8555"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#806b63"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"transit.line","elementType":"labels.text.fill","stylers":[{"color":"#8f7d77"}]},{"featureType":"transit.line","elementType":"labels.text.stroke","stylers":[{"color":"#ebe3cd"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#b9d3c2"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#92998d"}]}]';
		break;
	case 'dark':
		$map_style_snippet = '[{"elementType":"geometry","stylers":[{"color":"#212121"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#212121"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#757575"}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"administrative.land_parcel","stylers":[{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#181818"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#1b1b1b"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#2c2c2c"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8a8a8a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#373737"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3c3c3c"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#3d3d3d"}]}]';
		break;
	case 'dark2':
		$map_style_snippet = '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]';
		break;
	case 'night':
		$map_style_snippet = '[{"elementType":"geometry","stylers":[{"color":"#242f3e"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#746855"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#242f3e"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#263c3f"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#6b9a76"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#38414e"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#212a37"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#9ca5b3"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#746855"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#1f2835"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#f3d19c"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#2f3948"}]},{"featureType":"transit.station","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#17263c"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#515c6d"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#17263c"}]}]';
		break;
	case 'aubergine':
		$map_style_snippet = '[{"elementType":"geometry","stylers":[{"color":"#1d2c4d"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#8ec3b9"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#1a3646"}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#64779e"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"color":"#334e87"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#023e58"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#283d6a"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#6f9ba5"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#023e58"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#3C7680"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#304a7d"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#2c6675"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#255763"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#b0d5ce"}]},{"featureType":"road.highway","elementType":"labels.text.stroke","stylers":[{"color":"#023e58"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"transit.line","elementType":"geometry.fill","stylers":[{"color":"#283d6a"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#3a4762"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#0e1626"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#4e6d70"}]}]';
		break;
	default:
		$map_style_snippet = '';
}

$values = (array)vc_param_group_parse_atts($values);

$array_marker = array();
$array_overlay = array();

foreach ($values as $value) {
	$address = isset($value['address']) ? esc_html($value['address']) : '';
	$description = isset($value['description']) ? '<div class="gel-map-marker-description">' . esc_html($value['description']) . '</div>' : '';
	$title = isset($value['title']) ? '<h5 class="gel-map-marker-title">' . esc_html($value['title']) . '</h5>' : '';
	
	$image_html = '';
	if (!empty($value['image'])):
		$image_src = '';
		$image_src = g5core_get_url_by_attachment_id($value['image']);
		$image_html = sprintf('<img class="gel-map-marker-image" src="%s"%s>',
			esc_url($image_src),
			empty($value['title']) ? '' : sprintf(' alt="%s"', esc_attr($value['title'])));
	
	endif;
	
	$_data = "0";
	if (($title !== '') || ($description !== '') || ($image_html !== '')) {
		$_data = sprintf('<div class="gel-map-marker-wrap">%s%s%s</div>',
			$image_html,
			$title,
			$description);
	}
	
	$image_src = !empty($value['image_marker']) ? g5core_get_url_by_attachment_id($value['image_marker']) : '';

	$img_title = '';
	if (($image_src !== '') && !empty($value['image'])) {
		$img_title = $title !== '' ? $title : get_the_title($value['image']);
	}

	ob_start();
	?>
	<div class="gel-map-point-animate<?php echo ($image_src === '' ? ' no-image' : '') ?>">
		<div class="gel-map-point-center">
			<?php if ($image_src !== ''): ?>
				<img src="<?php echo esc_url($image_src) ?>"<?php echo ($img_title !== '' ? sprintf(' alt="%s"', esc_attr($img_title)) : '')  ?>>
			<?php endif; ?>
		</div>
	</div>
	<?php
	$_data_overlay = ob_get_clean();
	
	if ($marker_effect == 'on'):
		$array_overlay[] = array(
			'address' => $address,
			'data'    => $_data,
			'options' => array(
				'content' => $_data_overlay
			)
		);
		$array_marker[] = array(
			'address' => $address,
			'data'    => $_data,
			'options' => array(
				'visible' => ($image_src === '')
			)
		);
	else:
		$array_marker[] = array(
			'address' => $address,
			'data'    => $_data,
			'options' => array(
				'icon' => $image_src
			)
		);
	endif;
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>"
	 data-marker='<?php echo esc_attr(json_encode($array_marker)) ?>'
	 data-overlay='<?php echo esc_attr(json_encode($array_overlay)) ?>'
	 data-map-style='<?php echo esc_attr($map_style_snippet) ?>'
	 data-map-zoom='<?php echo esc_attr($map_zoom) ?>'
	 data-zoom-mouse-wheel='<?php echo $zoom_mouse_wheel == 'on' ? 'true' : 'false'; ?>'>
</div>


