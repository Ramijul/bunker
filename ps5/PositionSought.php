
<!--
Author: Ramijul Islam

-->

			</ul>
		</div>
		
		<div id="body">
			<div id="form">
				<h3>Position Sought</h3>
				
				<p>
				<b>This section requires you to provide a description of the type of job desired 
				in the field provided. Click on the submit button when you're done.</b>
				</p>
				
				<form method ="post" action="position.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					
					<span class="errMessage"><?php echo $errMsg;?></span>
					<span class="saved"><?php echo $savedMsg;?></span> 
					
					<table>
						
						<tr>
							<td><textarea rows="4" cols="50" name="position"><?php echo $position;?></textarea></td>
							<td><span class="errMessage"><?php echo $positionErr;?></span></td>
						</tr>
						
						<tr>
						<td align="center" colspan="2"> <input id="submit" type="submit" value="Submit" /></td>
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