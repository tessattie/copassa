<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agent $agent
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/agents">
            Agents
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Agent
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/agents"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($agent) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('phone', array('class' => 'form-control', "placeholder" => 'Phone', "label" => "Phone")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "placeholder" => 'Email', "label" => "Email")); ?></div> 
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