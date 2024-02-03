<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$property_toolbar = G5ERE()->options()->get_option('property_toolbar');
$property_toolbar_mobile = G5ERE()->options()->get_option('property_toolbar_mobile');
if (!is_array($property_toolbar) && !is_array($property_toolbar_mobile)) return;

$property_toolbar_left = (!isset($property_toolbar['left']) || !is_array($property_toolbar['left']) || (count($property_toolbar['left']) === 0)) ? false : $property_toolbar['left'];
$property_toolbar_right = (!isset($property_toolbar['right']) || !is_array($property_toolbar['right']) || (count($property_toolbar['right']) === 0)) ? false : $property_toolbar['right'];

$property_toolbar_mobile_left = (!isset($property_toolbar_mobile['left']) || !is_array($property_toolbar_mobile['left']) || (count($property_toolbar_mobile['left']) === 0)) ? false : $property_toolbar_mobile['left'];
$property_toolbar_mobile_right = (!isset($property_toolbar_mobile['right']) || !is_array($property_toolbar_mobile['right']) || (count($property_toolbar_mobile['right']) === 0)) ? false : $property_toolbar_mobile['right'];

if (!$property_toolbar_left && !$property_toolbar_right && !$property_toolbar_mobile_left && !$property_toolbar_mobile_right) return;

unset($property_toolbar_left['__no_value__']);
unset($property_toolbar_right['__no_value__']);
unset($property_toolbar_mobile_left['__no_value__']);
unset($property_toolbar_mobile_right['__no_value__']);

if ( ! is_search() ) {
	unset($property_toolbar_left['save_search']);
	unset($property_toolbar_right['save_search']);
	unset($property_toolbar_mobile_left['save_search']);
	unset($property_toolbar_mobile_right['save_search']);
}

$property_toolbar_layout = G5ERE()->options()->get_option('property_toolbar_layout');
$wrapper_classes = array(
	'g5ere__toolbar',
	'g5ere__property-toolbar',
	$property_toolbar_layout
);
$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>" hidden="hidden">
	<div class="g5ere__toolbar-inner">
		<?php if ($property_toolbar_left || $property_toolbar_right): ?>
			<div class="g5ere__toolbar-desktop">
				<div class="container">
					<div class="g5ere__toolbar-content-inner">
						<?php if ($property_toolbar_left): ?>
							<div class="g5ere__toolbar-left">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($property_toolbar_left as $k => $v): ?>
										<li><?php G5ERE()->get_template("loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<?php if ($property_toolbar_right): ?>
							<div class="g5ere__toolbar-right">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($property_toolbar_right as $k => $v): ?>
										<li><?php G5ERE()->get_template("loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($property_toolbar_mobile_left || $property_toolbar_mobile_right): ?>
			<div class="g5ere__toolbar-mobile">
				<div class="container">
					<div class="g5ere__toolbar-content-inner">
						<?php if ($property_toolbar_mobile_left): ?>
							<div class="g5ere__toolbar-left">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($property_toolbar_mobile_left as $k => $v): ?>
										<li><?php G5ERE()->get_template("loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<?php if ($property_toolbar_mobile_right): ?>
							<div class="g5ere__toolbar-right">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($property_toolbar_mobile_right as $k => $v): ?>
										<li><?php G5ERE()->get_template("loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
