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
            Companies
        </a></li>
        <li>Edit</li>
        <li><?= $company->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit <?= $company->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/companies">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
        <div class="panel-body articles-container">       
            <?= $this->Form->create($company) ?>
                <div class="row">
                    <div class="col-md-9">
                        <?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                        
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('type', array('class' => 'form-control', 'options' => $company_types, "label" => "Type", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right;height:44px")) ?>
                    </div>
                </div>  
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Options
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/companies">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
        <div class="panel-body articles-container">       
            <?= $this->Form->create($option, array("url" => "/options/add")) ?>
                <div class="row">
                    <div class="col-md-11">
                        <?= $this->Form->control('company_id', array('type' => 'hidden', "value" => $company->id)); ?>
                        <?= $this->Form->control('name', array('class' => 'form-control', "label" => "Add Option", "placeholder" => "Name")); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->button(__('Add'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right;height:44px;width:100%")) ?>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" style="margin-top:15px">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Created by</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center">Last modified</th>
                                    <th style="width:70px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($company->options as $option) : ?>
                                    <tr>
                                        <td class="text-center"><?= $option->name ?></td>
                                        <td class="text-center"><?= $option->user->name ?></td>
                                        <td class="text-center"><?= date("M d Y", strtotime($option->created)) ?></td>
                                        <td class="text-center"><?= date("M d Y H:i", strtotime($option->modified)) ?></td>
                                        <td class="text-right">
                                            <a href="<?= ROOT_DIREC ?>/options/edit/<?= $option->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                                            <a href="<?= ROOT_DIREC ?>/options/delete/<?= $option->id ?>" onclick="return confirm('Are you sure you would like to delete the option <?= $option->name ?>')" style="font-size:1.3em!important;margin-left:10px"><span class="fa fa-xl fa-trash color-red"></span></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div><!--End .articles-->