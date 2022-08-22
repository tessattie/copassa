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
        <li><?= h($option->company->name) ?></li>
        <li><?= h($option->name) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Option : <?= h($option->company->name ?> - <?= $option->name) ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/companies/edit/<?= $option->company->id ?>"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($option) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Product Name *", "placeholder" => "Product Name")); ?></div>
                    <div class="col-md-4">
                            <?= $this->Form->control('option_name', array('class' => 'form-control', "label" => 'Option Name *', "placeholder" => "Option")); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('plan', array('class' => 'form-control', "label" => 'Plan', "empty" => "-- Plan --", 'options' => $plans)); ?>
                    </div>    
                    
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                            <?= $this->Form->control('deductible', array('class' => 'form-control', "label" => 'Ouside USA Deductible', "placeholder" => "Ouside USA Deductible")); ?>
                    </div>
                    <div class="col-md-4">
                            <?= $this->Form->control('usa_deductible', array('class' => 'form-control', "label" => 'Inside USA Deductible', "placeholder" => "Inside USA Deductible")); ?>
                    </div>
                    <div class="col-md-4">
                            <?= $this->Form->control('max_coverage', array('class' => 'form-control', "label" => 'Maximum Coverage', "placeholder" => "Maximum Coverage")); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->