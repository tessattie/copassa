<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouping $grouping
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/groupings">
            Groups
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Group
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/groupings"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($grouping) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('grouping_number', array('class' => 'form-control', "label" => "Group Number *", "placeholder" => "Group Number")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('business_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $businesses, "label" => "Company", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('company_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $companies, "label" => "Insurance", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                  <div class="col-md-4"><?= $this->Form->control('effective_date', array('class' => 'form-control', "label" => "Created Date *")); ?></div>
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
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }

      
    }
</style>
