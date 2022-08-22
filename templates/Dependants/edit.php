<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dependant $dependant
 */
?>

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
        <li><a href="<?= ROOT_DIREC ?>/dependants">
            Dependants
        </a></li>
        <li>Edit</li>
        <li><?= h($dependant->name) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit : <?= h($dependant->name) ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $dependant->policy_id ?>">
                    <em class="fa fa-arrow-left"></em>
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body articles-container">       
            <?= $this->Form->create($dependant) ?>
                <div class="row">
                    <div class="col-md-9">
                        <?= $this->Form->control('policy_id', array('type' => 'hidden', "value" => $dependant->policy_id)); ?>
                        <?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('type', array('class' => 'form-control', 'options' => $company_types, "label" => "Type", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('relation', array('class' => 'form-control', "label" => "Relation *", "empty" => "-- Choose --", 'options' => $relations)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('dob', array('class' => 'form-control', "type" => "date", "label" => "DOB *")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('limitations', array('type' => "text", 'class' => 'form-control', "label" => "Exclusions *", "placeholder" => "Exclusions / Limitations")); ?></div>   
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right;height:44px")) ?>
                    </div>
                </div>  
            <?= $this->Form->end() ?>
        </div>
    </div>
</div><!--End .articles-->