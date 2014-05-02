
<!--
Author: Ramijul Islam

-->
			</ul>
		</div>
		
		<div id="body">
		
			<div id="form">
			
				<p>For all the following sections, fill out each field and press submit. You may choose to navigate 
				to any section at any point by clicking on the links to the left.</p>
				
				<p><b>NOTE:</b> You must press the submit button in order to see your changes in the Resume!</p>
				
				<h3>Contact Information</h3>
				
				<p>This section requires you to provide your contact information. 
				Please fill out the form below completely and press submit. </p>			
				
				
				<form method ="post" action="index.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					
					<span class="errMessage"><?php echo $errMsg;?></span> 
					<span class="saved"><?php echo $savedMsg;?></span> 
					
					<table>
											
						<tr>
							<td> <b>Name:</b> </td>
							<td> <input name="person" type="text" id="person" value="<?php echo $name;?>" /> </td>
							<td> <span class="errMessage"><?php echo $nameErr;?></span> </td>
						</tr>
						
						<tr>
							<td> <b>Address:</b> </td>
							<td> <input name="address" type="text" id="address" value="<?php echo $address;?>"/> </td>
							<td> <span class="errMessage"><?php echo $addressErr;?></span> </td>
						</tr>
						
						<tr>
							<td> <b>Phone Number:</b> </td>
							<td> <input name="number" type="text" maxlength="12" id="number" value="<?php echo $number;?>" placeholder="e.g. 123-123-1234"/></td>
							<td> <span class="errMessage"><?php echo $numberErr;?></span> </td>
						</tr>
						
						<tr>
						<td align="center" colspan="3"> <input id="submit" type="submit" value="Submit" /></td>
						</tr>
					
					</table>
				</form>
			</div>			
		</div>
	</div>
	
	<!-- decided to add the scrip here so that I can use the header file in resources folder
	in the employment page as well, since it has a seperate javascript functionality-->
	<script>
		$(function () {
			// When the submit button is clicked, set the hidden field
				$('input[type=submit]').click(function () {
					$('input[name=submission]').val('yes');
				});
		});
	</script>
	
	</body>
</html>