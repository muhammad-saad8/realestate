<?php
if ( is_singular() ) {
	the_title( '<h1 class="entry-title">', '</h1>' );
} elseif ( is_front_page() && is_home() ) {
	the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
} else {
	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
}