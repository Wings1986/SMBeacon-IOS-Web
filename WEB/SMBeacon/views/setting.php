<div class="box">
	<div class="box-head tabs">
		<div class="tab-pane" id="condensed">
			<div class="box-content">
				<form action="index.php?page=settings" class='validate form-horizontal' method="post" name="adduser" enctype="multipart/form-data">
					<div class="control-group">
						<label for="pw3" class="control-label">User Name</label>
						<div class="controls">
							<input type="text" name="users_name" value="<?php echo $user['username']?>" class='{required:true} ' readonly/>
						</div>
					</div>
								
					<div class="control-group">
						<label for="pw3" class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="users_email" value="<?php echo $user['email']?>" class='{required:true} email'>
						</div>
					</div>
					<!-- 			
					<div class="control-group">
						<label for="pw3" class="control-label">Tele Phone</label>
						<div class="controls">
							<input type="text" name="users_cellphone" value="<?php echo $user['telephone']?>">
						</div>
					</div>
					 -->		
					<div class="control-group">
						<label for="pw3" class="control-label">Password</label>
						<div class="controls">
							<input type="password" name="users_password" value="<?php echo $user['password']?>" class='{required:true}'>
						</div>
					</div>
								
					<div class="form-actions">
						<input type="submit"  value="Update" name="UpdateSettings" class='btn btn-primary' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>