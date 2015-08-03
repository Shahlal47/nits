<div aria-hidden="false" aria-labelledby="loginModalLabel" role="dialog"
	tabindex="-1" class="modal hide fade" id="loginModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">X</button>
		<h3 id="loginModalLabel">
			<i class="icon-external-link"></i> Login
		</h3>
	</div>
	<form accept-charset="utf-8" method="post" id="frmAjaxUserLogin" action="/nits/login">
	<div class="modal-body">
			<div id="login-loader"><img src="<?php echo $this->webroot;?>assets/img/loader.gif"/></div>
			<div id="login-error">Username or password is invalid.</div>
			<input id="ajaxUserName"
				type="text" placeholder="Username" class="input-block-level"
				name="data[User][username]">
			<input id="ajaxUserPassword"
				type="password" placeholder="Password" class="input-block-level"
				name="data[User][password]">
		
	</div>
	<div class="modal-footer">
		<button id="btnAjaxSignIn" class="btn btn-large btn-primary btn-block" type="submit">Sign
		in</button>
	</div>
	</form>
</div>

<style>
#login-loader{
    margin: 10px;
    text-align: center;
    display:none;
}
#login-error{
	color: RED;
	display:none;
}
</style>