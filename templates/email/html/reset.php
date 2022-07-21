<div style="width:100%;background:#008be5!important;text-align:center;padding-top:40px;padding-bottom:40px">
	<div style="margin-top:30px;margin:auto;background:white!important;width:45%;text-align:center;border-radius:3px;padding-top:30px;padding-bottom:30px;padding-right:15px;padding-left:15px">
		<img src="cid:f3453452dse4e453" style="width:130px">
		<h1 style="border-bottom:1px solid #ddd;padding-bottom:23px">Reset your Password</h1>
		<p style="font-size:18px;line-height:1.8em">Hello <?= $user->name ?>, please click on the button below to reset your password. </p>
		<p style="font-size:18px;line-height:1.8em">This link is only available for one hour. Please note that our password reset links are <strong>ONLY</strong> sent out from info@agencyreportsystem.com. Do not trust any other email to reset your password. </p>
		<p style="font-size:18px;line-height:1.8em">If you are not the one trying to reset your password, contact us and let us know.</p>
		<a href="https://agencyreportsystem.com/main/users/resetpassword/<?= $user->token ?>"><button style="background:#ff6600;color:white;padding:15px;border-radius:3px;border:none;font-size:18px">Reset your Password</button></a>
	</div>
	
</div>
