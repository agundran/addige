<!doctype html>
<html>
<head>


</head>
<body>
<div class="container">

<div class="main">
<form action="" method="post"> 

<label>Name :</label><br> 
<input type="text" name="sname" id="Name"/>

<label>Date Of Birth :</label><br> 
<input type="text" name="selected_date" id="datepicker"/>
 
<label>Select Date Format :</label><br>
  <select id="format">
	<option value="mm/dd/yy">Default - mm/dd/yyyy</option>
	<option value="dd/mm/yy">dd/mm/yyyy</option>
    <option value="yy-mm-dd">ISO 8601 - yyyy-mm-dd</option>
    <option value="d M, y">Short - d M, y</option>
    <option value="d MM, y">Medium - d MM, y</option>
    <option value="DD, d MM, yy">Full - DD, d MM, yyyy</option>
    <option value="&apos;day&apos; d &apos;of&apos; MM &apos;in the year&apos; yy">With text - 'day' d 'of' MM 'in the year' yyyy</option>
  </select>

<input type="submit" id="submit" value="Submit">
</form> 
</div>


<!-- Div Fugo is Advertisement div -->
        <div id="fugo">
          <a href="http://www.formget.com/app/"><img src="images/formGetadv-1.jpg" /></a>  
        </div>

</div> 
</body>
</html>