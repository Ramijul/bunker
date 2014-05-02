
<!--
Author: Ramijul Islam

-->
			</ul>
		</div>
		
		<div id="body">
		
			<div id="form">
			
				<h3>Registration</h3>
								
				<form method ="post" action="registration.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					
					<span  id="errHeader" class="errMessage"><?php echo $errMsg;?></span>
					
					<table>
								
						<tr>
							<td> <b>Full Name:</b> </td>
							<td> 
								<input type="text" name="realName" size="20" maxlength="45" placeholder="e.g John Doe" value="<?php echo $realName;?>"/>
							</td>
							<td> <span id="nameErr" class="errMessage"><?php echo $nameErr;?></span> </td>
						</tr>
						
						<tr>
							<td> <b>Login Name:</b> </td>
							<td>
								<input type="text" name="loginName" size="20" maxlength="45" value="<?php echo $loginName;?>"/>
							</td>
							<td> <span id="loginErr" class="errMessage"><?php echo $loginErr;?></span> </td>
						</tr>
						
						<tr>
							<td> <b>Password:</b> </td>
							<td>
								<i>Must be atleast 8 characters long</i></br>
								<input type="password" name="pass" size="20" value=""/>
							</td>
							<td> <span id="pass1Err" class="errMessage"><?php echo $passErr;?></span> </td>
						</tr>
						
						<tr>
							<td> <b>Re-type Password:</b> </td>
							<td>
								<i>Must be same as above</i></br>
								<input type="password" name="re_pass" size="20" value=""/>
							</td>
							<td> <span id="pass2Err" class="errMessage"><?php echo $passErr;?></span> </td>
						</tr>
						<tr>
							<td colspan="3">
								<br/>
								<input id="cancel" class="action" type="submit" value="Cancel" onclick="cancel();"/>
								<input id="register" class="action" type="submit" value="Register" onclick="return checkInputs();"/>
							</td>
						</tr>					
					</table>
				</form>
			</div>			
		</div>
	</div>
	
	<!-- decided to add the scrip here so that I can use the header file in resources folder
	in the employment page as well, since it has a seperate javascript functionality-->
	<script>
		function cancel()
		{
			 $('input[name=submission]').val("cancel");
		}
		
		function checkInputs()
		{
			var realName = $('input[name=realName]').val();
			var loginName = $('input[name=loginName]').val();
			var pass1 = $('input[name=pass]').val();
			var pass2 = $('input[name=re_pass]').val();

			var err = false;
			if (realName.trim() == "")
			{
				$("#nameErr").html("You cannot leave this blank");
				err = true;
			} 

			if (loginName.trim() == "")
			{
				$("#loginErr").html("You cannot leave this blank");
				err = true;
			}

			if (pass1.trim() == "")
			{
				$("#pass1Err").html("You cannot leave this blank");
				err = true;
			}

			if (pass2.trim() == "")
			{
				$("#pass2Err").html("You cannot leave this blank");
				err = true;
			}

			if (pass1.trim() != pass2.trim())
			{
				$("#pass1Err").html("The passwords do not match");
				$("#pass2Err").html("The passwords do not match");
				err = true;
			}

			if (pass1.trim().length < 8)
			{
				$("#pass1Err").html("The password is not long enough");
				$("#pass2Err").html("");
				err = true;
			}

			if (err)
			{
				$("#errHeader").html("Please correct the marked input(s)!");
				return false;
			}
			
			else
			{
				 $('input[name=submission]').val("yes");
				 return true;
			}
		}
	</script>
	
	</body>
</html>