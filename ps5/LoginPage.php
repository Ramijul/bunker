
<!--
Author: Ramijul Islam

-->
			</ul>
		</div>
		
		<div id="body">
		
			<div id="form">
			
				<h3>Login</h3>
								
				<form method ="post" action="login.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					
					<span class="errMessage"><?php echo $errMsg;?></span>
					
					<table>						
						<tr>
							<td> <b>Login Name:</b> </td>
							<td>
								<input type="text" name="loginName" size="20" maxlength="45" value="<?php echo $loginName;?>"/>
							</td>
						</tr>
						
						<tr>
							<td> <b>Password:</b> </td>
							<td>
								<input type="password" name="pass" size="20" />
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
								<br/>
								<input id="cancel" type="submit" value="Cancel" onclick="return go(this.id);"/>
								<input id="login" type="submit" value="Login" onclick="return go(this.id);"/>
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
		function go(id)
		{
			$('input[name=submission]').val(id);
			return true;
		}
		
	</script>
	
	</body>
</html>