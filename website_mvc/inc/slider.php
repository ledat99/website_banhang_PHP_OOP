<div class="header_bottom">
	<div class="header_bottom_left">
		<div class="section group">
			<?php
			$getLastestDell = $product->getLastestDell();
			if ($getLastestDell) {
				while ($resultdell = $getLastestDell->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"> <img src="admin/uploads/<?php echo $resultdell['image'] ?>" alt="" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Dell</h2>
							<p><?php echo $resultdell['productName'] ?></p>
							<div class="button"><span><a href="details.php?proid=<?php echo $resultdell['productId'] ?>">Add to cart</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
			<?php
			$getLastestSamsung = $product->getLastestSamsung();
			if ($getLastestSamsung) {
				while ($resultSamsung = $getLastestSamsung->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"><img src="admin/uploads/<?php echo $resultSamsung['image'] ?>" alt="" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Samsung</h2>
							<p><?php echo $resultSamsung['productName'] ?></p>
							<div class="button"><span><a href="details.php?proid=<?php echo $resultSamsung['productId'] ?>">Add to cart</a></span></div>
						</div>
					</div>

			<?php
				}
			}
			?>
		</div>
		<div class="section group">
			<?php
			$getLastestOppo = $product->getLastestOppo();
			if ($getLastestOppo) {
				while ($resultOppo = $getLastestOppo->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"> <img src="admin/uploads/<?php echo $resultOppo['image'] ?>" alt="" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Oppo</h2>
							<p><?php echo $resultOppo['productName'] ?></p>
							<div class="button"><span><a href="details.php?proid=<?php echo $resultOppo['productId'] ?>">Add to cart</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
			<?php
			$getLastestHuawei = $product->getLastestHuawei();
			if ($getLastestHuawei) {
				while ($resultHuawei = $getLastestHuawei->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"><img src="admin/uploads/<?php echo $resultHuawei['image'] ?>" alt="" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Huawei</h2>
							<p><?php echo $resultHuawei['productName'] ?></p>
							<div class="button"><span><a href="details.php?proid=<?php echo $resultHuawei['productId'] ?>">Add to cart</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="header_bottom_right_images">
		<!-- FlexSlider -->

		<section class="slider">
			<div class="flexslider">
				<ul class="slides">
					<?php
					$get_slider = $product->show_slider();
					if($get_slider) {
						while($result_slider = $get_slider->fetch_assoc()) {
													
					?>
					<!-- <li><img src="images/1.jpg" alt=""></li> -->
					
					<li>
					<img src="admin/uploads/<?php echo $result_slider['slider_image'] ?>" alt="<?php echo $result_slider['sliderName'] ?>"/> 
					</li>
					<?php
					
						}
					}

					?>

				</ul>
			</div>
		</section>
		<!-- FlexSlider -->
	</div>
	<div class="clear">
	</div>
</div>