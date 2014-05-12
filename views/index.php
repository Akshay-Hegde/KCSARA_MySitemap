<div id="exams-content">

	<div class="one_full">

		<section class="title">
			<h2>Site Map</h2>
		</section>

		<ul>
			<?php

				$lastdepth = 0;
				$i = 0;
				foreach($links as $key => $value)
				{
					$depth = substr_count($key, '/');

					if ( $depth < $lastdepth )
					{
						for ($x=$depth; $x<$lastdepth; $x++)
						{
							echo "</ul>\n";
							echo "</li>\n";
						}
					}

					if ( $depth > $lastdepth )
					{
						echo "<ul>\n";
					}

					if ( $depth == $lastdepth and $i != 0 )
					{
						echo "</li>\n";
					}

					echo "<li>";
					echo '<a href="' . site_url( $key ) . '">' . ( $value ) . '</a>';

					$lastdepth = $depth;
					$i++;
				}

			?>
			</li>
		</ul>

	</div>

</div>