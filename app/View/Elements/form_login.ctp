<?php
echo $this->Form->create
(
		'User',
		array
		(
				'url' => array
				(
						'controller' => 'users',
						'action'	 => 'login'
				),
				'class'			=> 'form-signin',
				'inputDefaults' => array
				(
						'label' => false,
						'error' => false
				)
		)
);

?>
<div id="login_div">
	<p class="muted text-center">Enter your username and password</p>
	<input type="text" placeholder="Username" class="input-block-level"
		name="data[User][username]"> <input type="password"
		placeholder="Password" class="input-block-level"
		name="data[User][password]">
	<button class="btn btn-large btn-primary btn-block" type="submit">Sign
		in</button>
	<!-- &nbsp; <a href="#" onclick="reset_pass();"><p class="muted text-center">Forgot
			Password !!!</p> </a> -->

</div>

</form>

<?php
echo $this->Form->create
(
		'User',
		array
		(
				'url' => array
				(
						'controller' => 'users',
						'action'	 => 'reset_password'
				),
				'class'			=> 'form-signin',
				'inputDefaults' => array
				(
						'label' => false,
						'error' => false
				)
		)
);

?>

<div id="reset_pass_div" class="text-center" style="display: none;">
	<p class="muted text-center">Enter your email address</p>

	<input type="text" placeholder="Email Address"
		class="input-block-level" name="data[User][email]">

	<p style="font-size: 0.8em;" class="muted text-center">*** Please
		specify a valid email address from where you can collect your
		password!!!</p>

	<button class="btn btn-primary " type="submit" onclick="reset_password();">Reset</button>
	<button class="btn btn-primary " type="button" onclick="enable_login();">Login</button>
</div>

</form>

<script type="text/javascript">
	var APP_URL_ROOT = "<?php echo $this->webroot;?>";
	var APP_XHR=null;
</script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/scripts.js"></script>
<script type="text/javascript">
function reset_pass(){
	$("#reset_pass_div").show();
	$("#login_div").hide();
};

function enable_login(){
	$("#reset_pass_div").hide();
	$("#login_div").show();
};

function reset_password(){
	APP_HELPER.ajaxRequestModelAction('users/reset_password');
}
</script>



