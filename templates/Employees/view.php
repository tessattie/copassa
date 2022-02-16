<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/employees">Employees</a></li>
        <li>View</li>
        <li><?= $employee->first_name. " ". $employee->last_name ?></li>
    </ol>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
            Employee Profile : <?= $employee->first_name. " ". $employee->last_name ?>
        </div>
        <div class="panel-body articles-container">       
            <table class="table table-striped">
                <tr>
                    <th><?= __('Full Name') ?></th>
                    <td class="text-right"><?= $employee->first_name. " ". $employee->last_name ?></td>
                </tr>
                <tr>

                    <th><?= __('Business') ?></th>
                    <td class="text-right"><?= $employee->has('business') ? $this->Html->link($employee->business->name, ['controller' => 'Businesses', 'action' => 'view', $employee->business->id]) : '' ?></td>
                </tr>
                
                <tr>
                    <th><?= __('Group') ?></th>
                    <td class="text-right"><?= $employee->has('grouping') ? $this->Html->link($employee->grouping->grouping_number, ['controller' => 'Groupings', 'action' => 'view', $employee->grouping->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Membership Number') ?></th>
                    <td class="text-right"><?= h($employee->membership_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deductible') ?></th>
                    <td class="text-right"><?= $this->Number->format($employee->deductible) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td class="text-right"><?= date("F d Y", strtotime($employee->created)) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Modified') ?></th>
                    <td class="text-right"><?= date("F d Y", strtotime($employee->modified)) ?></td>
                </tr>
            </table>
            </div>
            
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Family Members
                    <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#new_family">New Family Member</button>
                </div>
                <div class="panel-body articles-container">       
                    <div class="table-responsive">
                     <table class="table table-stripped datatable">
                <thead> 
                    <th>Full Name</th>
                    <th class="text-center">Relationship</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Residence</th>
                    <th class="text-center">Premium</th>
                    <th class="text-center">Status</th>
                    <th></th>

                </thead>
            <tbody> 
            <?php $total =0; foreach($employee->families as $family) : ?>
            <?php
            if($family->status ==1){
                $total = $total + $family->premium ;
            }
             ?>
                <tr>
                    <td><?= $family->first_name." ".$family->last_name ?></td>
                    <td class="text-center"><?= $relationships[$family->relationship] ?></td>
                    <td class="text-center"><?= $genders[$family->gender] ?></td>
                    <td class="text-center"><?= date("F d Y", strtotime($family->dob)) ?></td>
                    <td class="text-center"><?= $family->country ?></td>
                    <td class="text-center"><?= number_format($family->premium,2,".",",") ?></td>
                    <?php if($family->status == 1) : ?>
                        <td class="text-center"><span class="label label-success">Active</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger">Inactive</span></td>
                    <?php endif; ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/families/edit/<?= $family->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/families/delete/<?= $family->id ?>" onclick="return confirm('Are you sure you would like to delete the family member <?= $family->first_name." ".$family->last_name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="5">Total</th><th class="text-center"><?= number_format($total, 2, ".", ",") ?> USD</th><th></th><th></th></tr>
            </tfoot>
        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({

    } );
} );</script>

<style>
    .dt-button{
        padding:5px;
        background:black;
        border:2px solid black;
        border-radius:2px;;
        color:white;
        margin-bottom:-10px;
    }
    .dt-buttons{
        margin-bottom:-25px;
    }
</style>

<div class="modal fade" id="new_family" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Family Member</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/employees/addfamily')) ?>
      <div class="modal-body">
            <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('relationship', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $relationships, "label" => "Relationship", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                </div>
                <hr>
                <div class="row">
                    <?= $this->Form->control('business_id', array('type' => 'hidden',"value" => $employee->business_id)); ?>
                <?= $this->Form->control('grouping_id', array('type' => 'hidden',"value" => $employee->grouping_id)); ?>
                <?= $this->Form->control('employee_id', array('type' => 'hidden',"value" => $employee->id)); ?>
                    <div class="col-md-6"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium *", "placeholder" => "Premium")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('dob', array('class' => 'form-control', "label" => "Date of Birth *", 'type' => 'date')); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('gender', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $genders, "label" => "Gender *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-6"><?= $this->Form->control('country', array('class' => 'form-control', "label" => "Country of Residence *", "placeholder" => "Country of Residence")); ?></div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
