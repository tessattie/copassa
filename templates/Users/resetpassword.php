<div class="row" style="margin-top:3%">
	<div class="col-md-4 col-md-offset-4" style="text-align:center">
		
		<div class="login-panel panel panel-default" style="text-align:center;padding:30px">
			<?php echo $this->Html->image("logo.png", [
                    'style' => "width:200px",
                    "alt" => "AR Logo",
                    'url' => 'https://agencyreportsystem.com'
                ]); ?>
			<div class="panel-heading">Reset your Password</div>
			<div class="panel-body">
				<?php if($message['success']) : ?>
				<?= $this->Form->create() ?>
						<div class="form-group">
							<?= $this->Form->control("password", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Password", "type" => "password")) ?>
						</div>
						<div class="form-group">
							<?= $this->Form->control("confirm_password", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Confirm Password", "type" => "password")) ?>
						</div>
						
                		<?= $this->Form->button("Reset Password", array('class' => "btn btn-success loginForm", 'style' => "background:#ff6600;border:none")) ?>

            		<?= $this->Form->end() ?>
            		<div style="margin-top:20px;text-align:right">
            			<a href="<?= ROOT_DIREC ?>/users/login" style="text-decoration:underline;color:black">Back to log in</a>
            		</div>
            		
            		<?php else : ?>
            			<p style="text-align:center;font-size:15px;margin-top:20px" class="<?= ($message['success'] == false) ? "error_class" : 'success_class' ?>"><?= $message['message'] ?></p>
            		<?php endif; ?>

            		<?= $this->Flash->render() ?>
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