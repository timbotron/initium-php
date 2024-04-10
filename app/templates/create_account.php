<?php $this->layout('basic');?>
<div class="grd-row-col-2-6--md">
	
</div>
<div class="brdr--light-gray grd-row-col-2-6--md p1">
<h3>Create Account</h3>

<p>Enter your email address. We will send you an email verifying your address, and provide a link to set your password.</p>

<form action="/create-account" method="POST">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" <?= isset($post_content['email']) ? 'value="' . $post_content['email'] . '"' : '' ?> required>
        <label for="email">Repeat Email Address:</label>
        <input type="email" id="email2" name="email2" <?= isset($post_content['email2']) ? 'value="' . $post_content['email2'] . '"' : '' ?> required>
        <input type="submit" value="Create Account" class="btn">
</form>
</div>