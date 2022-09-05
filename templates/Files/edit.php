<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File $file
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/folders">
            Files
        </a></li>
        <li>Edit</li>
        <li><?= h($file->name) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit File : <?= h($file->name) ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/folders"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($file) ?>
                <div class="row">
                <div class="col-md-6"><?= $this->Form->control('folder_id', array('class' => 'form-control', "label" => "Folder *", "empty" => "-- Choose --", "options" => $folders)); ?></div>
                <div class="col-md-6"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                    
                </div>
                <hr>
                <div class="row">
                <div class="col-md-12"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
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

