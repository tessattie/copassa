<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/users">
            Users
        </a></li>
        <li class="active">add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New User
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/users"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($user) ?>
                <div class="row">
                <div class="col-md-5"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Nom")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "Email *", "placeholder" => "Email")); ?></div>
                <div class="col-md-3"><?= $this->Form->control('role_id', array('class' => 'form-control', 'options' => $roles, "label" => "Access *", "value" => 2, "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div>
                    
                </div>  
                <div class="row" style="margin-top:15px">
                <div class="col-md-4"><?= $this->Form->control('username', array('class' => 'form-control', "label" => "Username *", "placeholder" => "Username")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('password', array('class' => 'form-control', "type" => "text", "label" => "Password *", "placeholder" => "Password")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "options" => $status, 'style' => "height:46px", "label" => "Status *", "value" => 1)); ?></div>
    
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->

<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }
    }
</style>