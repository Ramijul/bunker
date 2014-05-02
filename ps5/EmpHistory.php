
<!--
Author: Ramijul Islam

-->

			</ul>
		</div>
		
		<div id="body">
		
			<div id="form">
				
				<h3>Contact Information</h3>
				
				<p>This section requires you to provide information about you employment history.
				This section is optional.
				</p>
				
				<p>
				<b>NOTE: </b>You may add as many jobs as you want by clicking the Add Another button or remove them by clicking 
				the Remove button! 
				</p>			
				
				
				<form method ="post" action="employment.php">
					<!-- Hidden field to identify real submissions -->
					<input type="hidden" name="submission" value="no"/>
					<input type="hidden" name="num" value= "1"/> <!-- indicates the number of jobs -->
					
					<span class="errMessage"><?php echo $errMsg;?></span> 
					<span class="saved"><?php echo $savedMsg;?></span> 
					
					<table>
					<tbody id="job">
						<tr id="1">
							<td>
								<table>
								<tr>
									<td> <b>Starting date:</b> </td>
									<td> <input name="startDate[]" type="text" id="11" placeholder="e.g. mm/dd/yyyy" maxlength="10" size="12" /> 
										 <span class="errMessage" id="12"></span> </td>
									<td rowspan="3" valign="middle"> <button onclick='removeRow(this); return false;'>Remove</button></td>
								</tr>
								
								<tr>
									<td> <b>Ending date:</b> </td>
									<td> <input name="endDate[]" type="text" id="13" placeholder="e.g. mm/dd/yyyy" maxlength="10" size="12" /> 
										 <span class="errMessage" id="14"></span> </td>
								</tr>
								
								<tr>
									<td> <b>Job Description:</b></td>
									<td> <textarea  rows="4" cols="50" id="15" name="text[]"></textarea> <br/>
										 <span class="errMessage" id="16"></span> </td>
								</tr>
								
								<tr>
									<td colspan="3"><hr/></td>
								</tr>
								</table>
							</td>
						</tr>
					</tbody>
					</table>
					<button id="butn" onclick="add(); return false;">Add Another</button><!-- didnt have time to implement -->
					<input id="submit" type="submit" value="Submit"/>
				</form>
			</div>			
		</div>
	</div>
	
	<!-- I have included the script here so that the onload function can have access to the fileds
	stated above after they are creater.
	I also tried to put this in a seperate javascript file but I was unsuccessful in doing so.
	the php tags were getting displayed in the browser console rather than the contents of it.-->
	<script>
		var num = 1;//number of rows/jobs
		$(function () {			
		    // When the submit button is clicked, set the hidden field
		    
			$('input[type=submit]').click(
				function () {
					$('input[name=submission]').val('yes');
					$('input[name=num]').val(num);
					});
		});

		//loads all the jobs from the session
		function loadAllTheJobs(){
			var j = <?php echo $numberOfJobs;?>;
			if (j >= 1)
			{
				<?php for ($k = 1; $k<=$numberOfJobs; $k++){
					if($k > 1){?>//add another box for job history
						addOnReload(<?php echo $k;?>);
					<?php }?>
					
					var startdate = document.getElementById("<?php echo $k;?>1");
					startdate.value = "<?php echo $startdate[$k-1];?>";//input type text
						
					var startdateErr = document.getElementById("<?php echo $k;?>2");
					startdateErr.innerHTML = "<?php echo $startDateErr[$k-1];?>";//span
					
					var enddate = document.getElementById("<?php echo $k;?>3");
					enddate.value = "<?php echo $enddate[$k-1];?>";//input type text
					
					var enddateErr = document.getElementById("<?php echo $k;?>4");
					enddateErr.innerHTML = "<?php echo $endDateErr[$k-1];?>";//span
					
					var txtBox = document.getElementById("<?php echo $k;?>5");
					txtBox.value = "<?php echo $text[$k-1]?>";//textarea
	
					var txtBoxErr = document.getElementById("<?php echo $k;?>6");
					txtBoxErr.innerHTML = "<?php echo $textErr[$k-1];?>";//span
					
				<?php }?>
			}
		}
		
		// removes the group 
		function removeRow(element)
		{
			//get to the tr element that the remove button and its table belong to
			//NOTE: each row has a table containing the three info for one job
			var toDel = element.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
			var id = toDel.id;//get the id of this row that needs to be deleted
			var table = toDel.parentNode;
			table.removeChild(document.getElementById(id));
			num--;
			return false;
		}
	
		//this function is called when the page is being reloaded with pre populated data
		function addOnReload(id)
		{
			//copied it from stack overflow
			//http://stackoverflow.com/questions/1728284/create-clone-of-table-row-and-append-to-table-in-javascript
			
			var row = document.getElementById("1"); // find row to copy
			var table = document.getElementById("job"); // find table to append to
			var clone = row.cloneNode(true); // copy children too
			clone.id = "" + id; // change id or other attributes/contents
			
			var inputs = clone.getElementsByTagName("input");//two inputs
			var span = clone.getElementsByTagName("span");//two spans
			var textbox = clone.getElementsByTagName("textarea")[0];//one textbox
	
			//change the ids such that they represent a combination of parents id and their own 
			//(i.e the id for the satrtdate input box of the first group will be 11, the first span, 
			//which his the second element, in this group will have the id 12, and so on)
			inputs[0].id = id+"1";//start date
			span[0].id = id+"2";//error message blank if theres none
	
			inputs[1].id = id+"3";//end date
			span[1].id = id+"4";//error message blank if theres none
			
			textbox.id = id+"5";//description
			span[2].id = id+"6";//error message blank if theres none
			
			table.appendChild(clone); // add new row to end of table
			num++;
			return false;
		}
	
		//adds a row at the end of the table
		function add()
		{
			//copied it from stack overflow
			//http://stackoverflow.com/questions/1728284/create-clone-of-table-row-and-append-to-table-in-javascript
			num++;

			var a = num-1;
			var group = document.getElementById(a);
			var groupInputs = group.getElementsByTagName("input");
			var groupText = group.getElementsByTagName("textarea")[0];

			if (groupInputs[0].value == "" && groupInputs[1].value == "" && groupText.value == "")
				alert("Please fill out the current group of Information first.");

			else{
				var row = document.getElementById("1"); // find row to copy
		 		var table = document.getElementById("job"); // find table to append to
		 		var clone = row.cloneNode(true); // copy children too
				clone.id = ""+num; // change id or other attributes/contents
	
				//make sure all the fields are blank before adding to the table
				var inputs = clone.getElementsByTagName("input");
				var span = clone.getElementsByTagName("span");//two spans
				var textbox = clone.getElementsByTagName("textarea")[0];//one textbox
				inputs[0].value = "";
				inputs[1].value = "";
	
				span[0].innerHTML = "";
				span[1].innerHTML = "";
				span[2].innerHTML = "";
	
				textbox.value = "";
				
				table.appendChild(clone); // add new row to end of table
			}
			
		}
	
		window.onload = loadAllTheJobs();
	</script>
	
	</body>
</html>
