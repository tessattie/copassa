<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Type $type
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/claims">
            Claims
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/types">
            Settings
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Settings
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/types"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($type) ?>
                <div class="row">
                <div class="col-md-8"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('color', array('class' => 'form-control', "label" => "Color *", "placeholder" => "Color", "type" => "Color")); ?></div>
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