<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Business $business
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/businesses">
            Corporate Groups
        </a></li>
        <li>Edit</li>
        <li><?= $business->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Corporate Group : <?= $business->name ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/businesses"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($business) ?>
                <div class="row">
                <div class="col-md-8"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('business_number', array('class' => 'form-control', "label" => "Company Number *", "placeholder" => "Company Number")); ?></div>
                    
                </div>
                    
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
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