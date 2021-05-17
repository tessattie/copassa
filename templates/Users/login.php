<div class="row" style="margin-top:3%">
	<div class="col-md-4 col-md-offset-4">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Log In</div>
			<div class="panel-body">
				<?= $this->Form->create() ?>
						<div class="form-group">
							<?= $this->Form->control("username", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Username")) ?>
						</div>
						<div class="form-group">
							<?= $this->Form->control("password", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Password")) ?>
						</div>
						<?= $this->Flash->render() ?>
                		<?= $this->Form->button("Submit", array('class' => "btn btn-success loginForm")) ?>
            		<?= $this->Form->end() ?>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->	