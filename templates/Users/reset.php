<div class="row" style="margin-top:3%">
	<div class="col-md-4 col-md-offset-4" style="text-align:center">
		
		<div class="login-panel panel panel-default" style="text-align:center;padding:30px">
			<?php echo $this->Html->image("logo.png", [
                    'style' => "width:200px",
                    "alt" => "AR Logo",
                    'url' => 'https://agencyreportsystem.com'
                ]); ?>
			<div class="panel-heading">Reset your password</div>
			<div class="panel-body">
				<?php if($message['success'] == false) : ?>
				<p style="text-align:left;font-size:15px">Fear not. We’ll email you instructions to reset your password. If you don’t have access to your email anymore, use your username or contact us through Live Chat.</p>
				<hr>
				<?= $this->Form->create() ?>
						<div class="form-group">
							<?= $this->Form->control("username", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Enter your username")) ?>
						</div>

						<div class="form-group">
							<?= $this->Form->control("email", array('label' => false, "class" => "form-control loginForm", "placeholder" => "or your email")) ?>
						</div>
						
                		<?= $this->Form->button("Send Instructions", array('class' => "btn btn-success loginForm", 'style' => "background:#ff6600;border:none")) ?>

            		<?= $this->Form->end() ?>

            		<?php endif; ?>
            		<div style="margin-top:20px;text-align:right">
            			<a href="<?= ROOT_DIREC ?>/users/login" style="text-decoration:underline;color:black">Back to log in</a>
            		</div>
            		<?php if(!empty($message['message'])) : ?>
            			<p style="text-align:left;font-size:15px;margin-top:20px" class="<?= ($message['success'] == false) ? "error_class" : 'success_class' ?>"><?= $message['message'] ?></p>
            		<?php endif; ?>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->	

<style type="text/css">
	.error_class{
		background: #f2dede;
		padding: 10px;
	}

	.success_class{
		background: #dff0d8;
		padding: 10px;
	}
</style>