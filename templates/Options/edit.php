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
            Options
        </a></li>
        <li>Edit</li>
        <li><?= $option->company->name ?></li>
        <li><?= $option->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Option : <?= $option->company->name ?> - <?= $option->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/companies/edit/<?= $option->company->id ?>">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($option) ?>
                <div class="row">
                <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Product Name *", "placeholder" => "Product Name")); ?></div>
                <div class="col-md-4">
                        <?= $this->Form->control('option_name', array('class' => 'form-control', "label" => 'Option', "placeholder" => "Option")); ?>
                </div>
                <div class="col-md-4">
                        <?= $this->Form->control('deductible', array('class' => 'form-control', "label" => 'Deductible', "placeholder" => "Deductible")); ?>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->