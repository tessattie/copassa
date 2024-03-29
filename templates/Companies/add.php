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
        <li><a href="<?= ROOT_DIREC ?>/companies">
            Insurance Companies
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Insurance Company
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/companies"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($company) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('type', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $company_types, "label" => "Type *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('address', array('class' => 'form-control', "label" => "Address", "placeholder" => "Address", "required" => false)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('phone', array('class' => 'form-control', "placeholder" => 'Phone', "label" => "Phone", "required" => false)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "placeholder" => 'Email', "label" => "Email", "required" => false)); ?></div>   
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Add'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->

<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label{
        margin-top: 15px;
      }

      
    }
</style>