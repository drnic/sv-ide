<h2 class="cats">Categorias</h2>
		<div id="cats">
			<?php if (function_exists ('cattag_tagcloud') ) { echo cattag_tagcloud(8, 16, 2) ; } ?>
		</div>
		</div>
  </div>


<div id="rightPan">
  	<div id="rightTopPan">
	
		<ul>
			<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
			<?php wp_register('<li>','</li>'); ?>
	  </ul>
	</div>
	
    <div id="rightBodyPan">
		<h2>Mini Posts</h2>
		<?php get_mini_posts(2); ?>
	</div>
  </div>
</div>