<?php
	ob_start();
	if(!isset($_SESSION)){
		session_start();
	}
	$hotel_id=0;
	if(isset($_SESSION['added_hotel_id'])){
		$hotel_id = $_SESSION['added_hotel_id'];
?>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/jquery.asmselect.js"></script>




	<script type="text/javascript">

		$(document).ready(function() {

			$("#sports").asmSelect({
				animate: true,
				highlight: true,
				sortable: true
			});

			$("#add_sports_btn").click(function() {

				var city = $("#add_sports").val();
				var $option = $("<option></option>").text(city).attr("selected", true);

				$("#sports").append($option).change();
				$("#add_sports").val('');

				return false;
			});

		});

	</script>


    <link rel="stylesheet" type="text/css" href="css/jquery.asmselect.css" />


<div id="container" align="left"  style="height: 450px !important;">
	<div class="form">
    	<div>
        <?php
			echo '<ul>';
			$arr=array();
			$rs = getResultSet("SELECT s.sport_name FROM tbl_sports_recreation AS s INNER JOIN tbl_hotel_sports AS hs ON s.sport_id = hs.sport_id WHERE hs.hotel_id = " . $hotel_id);
			$i=0;
			if(mysql_num_rows($rs)>0){
				echo '<h5>Your Hotel sports:</h5>';
				while($r = mysql_fetch_array($rs)){
					echo '<li>' . $r[0] . '</li>';
					$arr[$i] = $r[0];
					$i++;
				}
			}
			$rs = getResultSet("SELECT sport_description FROM tbl_hotel_sports WHERE sport_id=0 AND hotel_id = " . $hotel_id);

			if(mysql_num_rows($rs)>0){
				while($r = mysql_fetch_array($rs)){
					echo '<li>' . $r[0] . '</li>';
				}
			}
			echo '</ul>';
		?>
        </div>

		<form action="php_ajax/db_save_sports.php" method="post">


        <input type="hidden" value="facility" name="hiden_paramet" />
		<select id="sports" multiple="multiple" name="sports[]" title="Please Choose Sports and Recreations">
        	<?php
				$rs = getResultSet("SELECT sport_id,sport_name FROM tbl_sports_recreation");

				while($r=mysql_fetch_array($rs)){
					echo "<option value=" . $r[0] . ">" . $r[1] . "</option>";
				}
			?>
		</select>

        <p>
        	<table><tr>
            <td width="400"><label for="add_sport">Add more Sports and Recreation?</label></td>
            <td><input type="text" id="add_sports" value="" /></td>
            <td><button type="button" id="add_sports_btn" href="#">Add</button></td>
            </tr>
            </table>
		</p>

    	<p align="right"><input type="submit" name="submit" value="" class="send submit" style="float:right;" /></p>
        <br /><br />

	</form>
	
    </div>
</div>

<div id="finish_saved">

</div>

<?php 
	}
	else{
 ?>
 <div id="container">
 	<div class="form">
 	<h2>Please add hotel first.</h2>
    </div>
 </div>
 
 <?php
	}
 ?>
 