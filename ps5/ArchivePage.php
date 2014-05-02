
<!--
Author: Ramijul Islam

-->
			</ul>
		</div>
		
		<div id="body">
		
			<div id="form">
			
				<h3>The Archive</h3>
				
				<p>Please insert a Resume Name and select the task you wish to be performed.</p>						
				
				
				<form method ="post" action="archive.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					<input type="hidden" name="subType" value="none"/>
					
					<span class="errMessage"><?php echo $errMsg;?></span> 
					<span class="saved"><?php echo $savedMsg;?></span> 
					
					<table>
								
						<tr>
							<td> <b>Resume Name:</b> </td>
							<td> 
								<i id="italics">Do not include spaces, numbers or special characters.</i> <br/>
								<input type="text" name="resumeName" id="auto" size="20" maxlength="20" value="<?php echo $resumename;?>"/>
							</td>
							<td> <span class="errMessage"><?php echo $nameErr;?></span> </td>
						</tr>
						
						<tr>
							<td colspan="3">
								<br/>
								<input id="load" class="action" type="submit" value="Load the Resume" onclick="disable(this.id); this.form.submit();"/>
								<input id="save" class="action" type="submit" value="Save the Resume" onclick="disable(this.id); this.form.submit();"/>
								<input id="view" class="action" type="submit" value="View the Resume" onclick="disable(this.id); this.form.submit();"/>
								<input id="delete" class="action" type="submit" value="Delete the Resume" onclick="disable(this.id); this.form.submit();"/>
							</td>
						</tr>					
					</table>
					<span id="wait"></span>
				</form>
			</div>			
		</div>
	</div>
	
	<!-- decided to add the scrip here so that I can use the header file in resources folder
	in the employment page as well, since it has a seperate javascript functionality-->
	<script>
		$(function(){
			$("#auto").autocomplete({
				source: "resources/autocomplete.php",
				minLength: 3
			});
		});
		
		//width of the list returned from the autocomplete
		//is set according to the width of the text box
		$.extend($.ui.autocomplete.prototype.options, {
			open: function(event, ui) {
				$(this).autocomplete("widget").css({
					"width": ($(this).width() + "px")
				});
			}
		});
		
		function popUp()
		{
			//if the view button was click with a valid input
			<?php if ($openView){?>
			var name = "<?php echo $resumename;?>";
			var user = "<?php echo $login;?>";
			window.open("view.php?resName="+name+"&login="+user);
			<?php }?>
		}
		//helper function that disables all the buttons and
		//changes the values of the hidden input buttons
		function disableAndSend(id)
		{
			//$('input[type=submit]').attr('disabled', 'disabled');
			$('input[name=submission]').val('yes');
			$('input[name=subType]').val(id);
			$('.action').attr('disabled', 'disabled');
			document.getElementById("wait").innerHTML = "This will only take a moment...";			
		}

		//if the delete button is clicked, check for confirmation with the user
		//otherwise submit.
		//if the user confirms teh delete action, submit otherwise stay on this page.
		function disable(id)
		{
			var name = document.getElementById("auto").value;
			
			if (id === "save" || id === "load")
			{
				disableAndSend(id);
			}
			else if (id === "delete")
			{
				var confirm = confirm('Are sure you want to delete '+name+'?');
				if(confirm == true)
					disableAndSend(id);
			}
			else//view
			{
				$('input[name=submission]').val('yes');
				$('input[name=subType]').val(id);
			}
		}
		window.onload = popUp();
	</script>
	
	</body>
</html>