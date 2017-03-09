<?php
// all the possible page blocks as defined in the Page Content flexible layout field

$row_index = 0;

if( have_rows('page_layouts') ) {

	while( have_rows('page_layouts') ) {

		the_row();

		$block = "template-parts/blocks/" . str_replace('_','-',get_row_layout()) . ".php";

		include(locate_template($block));

		$row_index++;

		}
}
