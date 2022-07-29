<div class="row" style="margin-top:3%">
	<div class="col-md-4 col-md-offset-4" style="text-align:center">
		
		<div class="login-panel panel panel-default" style="text-align:center;padding:30px">
			<?php echo $this->Html->image("logo.png", [
                    'style' => "width:200px",
                    "alt" => "AR Logo",
                    'url' => 'https://agencyreportsystem.com'
                ]); ?>
			<div class="panel-heading">Log In</div>
			<div class="panel-body">

				<?= $this->Form->create() ?>
						<div class="form-group">
							<?= $this->Form->control("username", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Username")) ?>
						</div>
						<div class="form-group">
							<?= $this->Form->control("password", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Password")) ?>
						</div>
						
                		<?= $this->Form->button("Log In", array('class' => "btn btn-success loginForm", 'style' => "background:#ff6600;border:none")) ?>

            		<?= $this->Form->end() ?>
            		<div style="margin-top:20px;text-align:right;margin-bottom:20px">
            			<a href="<?= ROOT_DIREC ?>/users/reset" style="text-decoration:underline;color:black">Forgot Password</a>
            		</div>
            		
            		<?= $this->Flash->render() ?>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->	