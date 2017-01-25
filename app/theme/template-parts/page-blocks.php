<?php
// all the possible page blocks as defined in the Page Content flexible layout field

$row_index = 0;
if( have_rows('page-content') ) {
	while( have_rows('page-content') ) {
		the_row();
		$block = "blocks/". get_row_layout() .".php";
		include(locate_template($block));
		$row_index++;
    }
}
