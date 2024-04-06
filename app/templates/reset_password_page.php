<?php $this->layout('basic');?>
<div class="grd-row-col-2-6--md">
	
</div>
<div class="brdr--light-gray grd-row-col-2-6--md p1">
<h3>Change Password</h3>

<form action="/reset-password/<?= $uuid;?>" method="POST">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="password2">Repeat Password:</label>
        <input type="password" id="password2" name="password2" required>
        <button class="btn" type="submit">Change Password</button>
</form>
</div>