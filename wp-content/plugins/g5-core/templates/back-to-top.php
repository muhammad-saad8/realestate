<?php
/**
 * The template for displaying back-to-top
 *
 */
$back_to_top = G5CORE()->options()->get_option('back_to_top');
if ($back_to_top !== 'on') return;
?>
<a class="g5core-back-to-top" href="#"><i class="fal fa-angle-up"></i></a>