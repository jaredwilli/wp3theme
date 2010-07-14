	<aside role="complementary" id="sidebar">
	
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">First</a></li>
				<li><a href="#tabs-2">Second</a></li>
				<li><a href="#tabs-3">Third</a></li>
			</ul>
			
			<nav id="tabs-1">
				<ul>
					<li>This is the first tab</li>
					<li>This is the first tab</li>
					<li>This is the first tab</li>
					<li>This is the first tab</li>
				</ul>
			</nav>
			<nav id="tabs-2">
				<ul>
					<li>Second tab this is</li>
					<li>Second tab this is</li>
					<li>Second tab this is</li>
					<li>Second tab this is</li>
					<li>Second tab this is</li>
					<li>Second tab this is</li>
					<li>Second tab this is</li>
				</ul>
			</nav>
			<nav id="tabs-3">
				<ul>
					<li>Tab three here buddy!</li>
					<li>Tab three here buddy!</li>
					<li>Tab three here buddy!</li>
					<li>Tab three here buddy!</li>
				</ul>
			</nav>
		</div><!-- // Tabs -->

		<nav>
			<ul>
				<?php if(function_exists('dynamic_sidebar') && dynamic_sidebar(Sidebar1)) : ?><?php endif; ?>			
			</ul> 
		</nav>
<!-- Additional sidebar widgetized sections
		<nav>
			<ul>
				<?php if(function_exists('dynamic_sidebar') && dynamic_sidebar(Sidebar3)) : ?><?php endif; ?>			
			</ul>    
		</nav>

		<nav>
			<ul>
				<?php if(function_exists('dynamic_sidebar') && dynamic_sidebar(Sidebar4)) : ?><?php endif; ?>			
			</ul>    
		</nav>
-->		
	</aside>