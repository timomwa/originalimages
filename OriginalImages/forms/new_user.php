<?php 
include_once '../classes/security.php';
?>
<H3>Add a Client to the system</H3>
<p>Here, you can add a user with a valid email address. The Password is auto generated and stored by the system for the customer to use to log into their albums made by you.</p>
<label>Email Address</label><input type="text" id="emailAddress"/>
<label>Password</label><input type="text" id="password" value="<?php echo Security::generatePassword(6,8)?>"/>
<label>Client Name</label><input type="text" id="clientName"/>
<button onclick='OI.addUser()'>Add User</button>

<button onclick='OI.reloadCurPage()'>Cancel</button>
<span id='actions'></span>
