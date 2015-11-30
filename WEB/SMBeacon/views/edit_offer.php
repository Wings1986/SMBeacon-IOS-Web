<div class="box">
	<div class="box-head tabs">
		<h3><?php echo $Title;?></h3>
	</div>
	<div class="box-head tabs">
		<div class="tab-pane" id="condensed">
			<div class="box-content">
				<form action="index.php?page=editoffer&mID=<?php echo $_REQUEST['mID'] ?>" class='validate form-horizontal' method="post" name="editmerchant" enctype="multipart/form-data">
				    <div class="control-group">
						<label for="title" class="control-label">Code</label>
						<div class="controls">
							<input type="text" name="code" value="<?php echo $offer['code'] ?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Title</label>
						<div class="controls">
							<input type="text" name="title" value="<?php echo $offer['title']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Description</label>
						<div class="controls">
						    <textarea name="description" rows="5" cols="" class='{required:true} span8'><?php echo $offer['description']?></textarea>
						</div>
					</div>
					<?php
					if (is_file($offer['picture'])) {
					?>
					<div class="control-group">
						<div class="controls">
							<ul>
								<li class="span2" style="z-index: 0 !important;">
									<a href="<?php echo $offer['picture'] ?>" class="fancy"><img src="<?php echo $offer['picture'] ?>" width="200"/></a>
								</li>
							</ul>
						 </div>
					</div>
					<?php
					}
					?>
					<div class="control-group">
						<label for="logo" class="control-label">Picture</label>
						<div class="controls">
							<input class="input-file uniform_on" id="picture" name="picture" type="file" >
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Original Price</label>
						<div class="controls">
							<input type="text" name="original_price" value="<?php echo $offer['original_price']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Offer Price</label>
						<div class="controls">
							<input type="text" name="offer_price" value="<?php echo $offer['offer_price']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Time Limit(hr)</label>
						<div class="controls">
							<input type="number" min="1" max="72" name="time_limit" value="<?php echo $offer['time_limit']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Time Limit</label>
						<div class="controls">
							<input type="text" name="expire_date" value="<?php echo date('Y-m-d', strtotime($offer['expire_date']))?>" class='{required:true} span8'>
						</div>
					</div>

					<div class="form-actions">
						<input type="hidden" name="oID" value="<?php echo $offer['id']?>">
						<input type="submit"  value="Save" name="UpdateOffer" class='btn btn-primary'>
						<input type="button" class="btn btn-danger" onClick="location.href='<?php echo "index.php?page=offer&mID={$_REQUEST['mID']}"?>'" value="Cancel"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>