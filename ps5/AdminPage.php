
<!--
Author: Ramijul Islam

-->
			</ul>
		</div>
		
		<div id="body">
		
			<div id="form">
			
				<h3>Administration Page</h3>
				
				
				<form id="form" method ="post" action="admin.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					
					<span class="errMessage"><?php echo $errMsg;?></span> 
					<span class="saved"><?php echo $savedMsg;?></span> 
					
					<br /> <br />
					
					<table class="administration">				
						<tr id="header">
							<td> <b>Login Name</b> </td>
							<td> <b>Name</b> </td>
							<td> <b>Roles</b> </td>
							<td> <b>Delete User<b> </td>
						</tr>
						<?php for ($i = 0; $i < $numOfUsers; $i++){?>
						<tr>
							<td> <?php echo $userid[$i]?> </td>
							<td> <?php echo $user_name[$i]?> </td>
							<td> 
								<select name="roles[]">
									<option value="Client" <?php if ($user_client[$i]) echo 'selected';?> > Client </option>
									<option value="Admin" <?php if ($user_admin[$i]) echo 'selected';?> > Admin </option>
								</select>
							</td>
							<td> <input type="checkbox" name="todel[]" value="<?php echo $userid[$i];?>" /> </td>							
						</tr>
						<?php }?>
						<tr>
							<td colspan="4"> <input id="apply" class="change" type="submit" value="Apply Changes"/> </td>
						</tr>			
					</table>
				</form>
			</div>			
		</div>
	</div>
	
	<!-- decided to add the scrip here so that I can use the header file in resources folder
	in the employment page as well, since it has a seperate javascript functionality-->
	<script>
		//new code
		
		//get all the checked check boxes and send them to be dealt with
		
		$('input[type=submit]').click(function () {
			$('input[name=submission]').val('yes');
		
		
// 			$('input[type=checkbox]:checked').each(function(){
// 		        //toDel.push($(this).id);
// 		        var form = $(".form").id;
// 		        var input = document.createElement('input');
// 		        input.type = 'hidden';
// 		        input.name = 'toDelete[]';
// 		        input.value = $(this).id;
// 		        form.appendChild(input);
// 		    });
		});
	</script>
	
	</body>
</html>