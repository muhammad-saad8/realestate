<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$agent_toolbar = G5ERE()->options()->get_option('agent_toolbar');

$agent_toolbar_mobile = G5ERE()->options()->get_option('agent_toolbar_mobile');
if (!is_array($agent_toolbar) && !is_array($agent_toolbar_mobile)) return;

$agent_toolbar_left = (!isset($agent_toolbar['left']) || !is_array($agent_toolbar['left']) || (count($agent_toolbar['left']) === 0)) ? false : $agent_toolbar['left'];
$agent_toolbar_right = (!isset($agent_toolbar['right']) || !is_array($agent_toolbar['right']) || (count($agent_toolbar['right']) === 0)) ? false : $agent_toolbar['right'];

$agent_toolbar_mobile_left = (!isset($agent_toolbar_mobile['left']) || !is_array($agent_toolbar_mobile['left']) || (count($agent_toolbar_mobile['left']) === 0)) ? false : $agent_toolbar_mobile['left'];
$agent_toolbar_mobile_right = (!isset($agent_toolbar_mobile['right']) || !is_array($agent_toolbar_mobile['right']) || (count($agent_toolbar_mobile['right']) === 0)) ? false : $agent_toolbar_mobile['right'];

if (!$agent_toolbar_left && !$agent_toolbar_right && !$agent_toolbar_mobile_left && !$agent_toolbar_mobile_right) return;

unset($agent_toolbar_left['__no_value__']);
unset($agent_toolbar_right['__no_value__']);
unset($agent_toolbar_mobile_left['__no_value__']);
unset($agent_toolbar_mobile_right['__no_value__']);
$agent_toolbar_layout = G5ERE()->options()->get_option('agent_toolbar_layout');
$wrapper_classes = array(
	'g5ere__toolbar',
	'g5ere__agent-toolbar',
	$agent_toolbar_layout
);

$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>" hidden="hidden">
	<div class="g5ere__toolbar-inner">
		<?php if ($agent_toolbar_left || $agent_toolbar_right): ?>
			<div class="g5ere__toolbar-desktop">
				<div class="container">
					<div class="g5ere__toolbar-content-inner">
						<?php if ($agent_toolbar_left): ?>
							<div class="g5ere__toolbar-left">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($agent_toolbar_left as $k => $v): ?>
										<li><?php G5ERE()->get_template("agent/loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<?php if ($agent_toolbar_right): ?>
							<div class="g5ere__toolbar-right">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($agent_toolbar_right as $k => $v): ?>
										<li><?php G5ERE()->get_template("agent/loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($agent_toolbar_mobile_left || $agent_toolbar_mobile_right): ?>
			<div class="g5ere__toolbar-mobile">
				<div class="container">
					<div class="g5ere__toolbar-content-inner">
						<?php if ($agent_toolbar_mobile_left): ?>
							<div class="g5ere__toolbar-left">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($agent_toolbar_mobile_left as $k => $v): ?>
										<li><?php G5ERE()->get_template("agent/loop/toolbar/{$k}.php") ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<?php if ($agent_toolbar_mobile_right): ?>
							<div class="g5ere__toolbar-right">
								<ul class="g5ere__toolbar-list">
									<?php foreach ($agent_toolbar_mobile_right as $k => $v): ?>
										<li><?php G5ERE()->get_template("agent/loop/toolbar/{$k}.php") ?></li>
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
