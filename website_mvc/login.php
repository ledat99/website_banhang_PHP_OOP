
<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check ) {
	header('Location:order.php');
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	// The request is using the POST method
	$insert_Customers = $cs->insert_customers($_POST); //có images thì phải có $_FILES
}
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
	// The request is using the POST method


	$login_Customers = $cs->login_customers($_POST); //có images thì phải có $_FILES

}
?>
<div class="main">
	<div class="content">
		<div class="login_panel">
			<h3>Existing Customers</h3>
			<p>Sign in with the form below.</p>
			<?php

			if (isset($login_Customers)) {
				echo $login_Customers;
			}

			?>
			<form action="" method="post">
				<input type="text" name="email" class="field" placeholder="Enter email">
				<input type="password" name="password" class="field" placeholder="Enter password">

				<p class="note">If you forgot your passoword just enter your email and click <a href="#">here</a></p>
				<div class="buttons">
					<div><input type="submit" name="login" class="grey" value="Sign In"></div>
				</div>
			</form>
		</div>

		<div class="register_account">
			<h3>Register New Account</h3>
			<?php

			if (isset($insert_Customers)) {
				echo $insert_Customers;
			}

			?>
			<form action="" method="POST">
				<table>
					<tbody>
						<tr>
							<td>
								<div>
									<input type="text" name="name" placeholder="Enter name ...">
								</div>

								<div>
									<input type="text" name="city" placeholder="Enter City ...">
								</div>

								<div>
									<input type="text" name="zipcode" placeholder="Enter zipcode ...">
								</div>
								<div>
									<input type="text" name="email" placeholder="Enter E-Mail ...">
								</div>
							</td>
							<td>
								<div>
									<input type="text" name="address" placeholder="Enter Address ...">
								</div>
								<div>
									<select id="country" name="country" onchange="change_country(this.value)" class="frm-field required">
										<option value="null">Select a Country</option>
										<option value="hcm">TPHCM</option>
										<option value="na">Nghệ An</option>
										<option value="hn">Hà Nội</option>
										<option value="dn">Đà Nẵng</option>


									</select>
								</div>

								<div>
									<input type="text" name="phone" placeholder="Enter phone ...">
								</div>

								<div>
									<input type="text" name="password" placeholder="Enter password ...">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="search">
					<div><input type="submit" name="submit" class="grey" value="Create Account"></div>
				</div>
				<p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp; Conditions</a>.</p>
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>