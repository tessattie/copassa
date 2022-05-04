<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouping $grouping
 */

$total = 0;
foreach($grouping->employees as $employee){
    if($employee->status == 1){
        foreach($employee->families as $family){
            if($family->status = 1){
                $total = $total + $family->premium;
            }
        }
    }
}
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/groupings">Groups</a></li>
        <li>View</li>
        <li><?= $grouping->grouping_number ?></li>
    </ol>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
            Group Profile : <?= $grouping->grouping_number ?>
        </div>
        <div class="panel-body articles-container">       
               <table class="table table-striped">
                <tr>
                    <th><?= __('Corporate Group') ?></th>
                    <td class="text-right"><?= $grouping->has('business') ? $this->Html->link($grouping->business->name, ['controller' => 'Businesses', 'action' => 'view', $grouping->business->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Group Policy Number') ?></th>
                    <td class="text-right"><?= h($grouping->grouping_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Insurance') ?></th>
                    <td class="text-right"><?= $grouping->company->name ?></td>
                </tr>
                <tr>
                    <th><?= __('Created Date') ?></th>
                    <td class="text-right"><?= date('F d Y',strtotime($grouping->effective_date)) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Modified') ?></th>
                    <td class="text-right"><?= date('F d Y',strtotime($grouping->modified)) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td class="text-right"><span class="label label-info"><?= number_format($total, 2, ".", ",") ?></span></td>
                </tr>
            </table>
            </div>
            
        </div>
        </div>
    </div>
    <?php echo $this->element('employees', array("employees" => $grouping->employees)); ?>

            
   
</div>

<?php echo $this->element('family_members', array("employees" => $grouping->employees)); ?>

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

<div class="modal fade" id="new_employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/groupings/addemployee')) ?>
      <div class="modal-body">
            <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('membership_number', array('class' => 'form-control', "label" => "Membership / Policy # *", "placeholder" => "Membership Number")); ?></div>
                </div>
                <hr>  
                <div class="row">
                  <div class="col-md-4"><?= $this->Form->control('dob', array('class' => 'form-control', "label" => "Date of Birth *", "type" => "date")); ?></div>
                  <div class="col-md-4"><?= $this->Form->control('gender', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $genders, "label" => "Gender", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                  <div class="col-md-4"><?= $this->Form->control('country', array('class' => 'form-control', "label" => "Country of Residence *", "placeholder" => "Country of Residence")); ?></div>
                </div>
                <hr>
                <div class="row">
<?= $this->Form->control('business_id', array('type' => 'hidden', 'value' => $grouping->business_id )); ?>
<?= $this->Form->control('grouping_id', array('type' => 'hidden',"value" => $grouping->id)); ?>
                    <div class="col-md-4"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Group --', "label" => "Group", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-4"><?= $this->Form->control('deductible', array('class' => 'form-control', "label" => "Deductible *", "placeholder" => "Deductible")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('effective_date', array('class' => 'form-control', "label" => "Created Date *", "type" => 'date')); ?></div>
                </div>
                <hr>
                <div class="row">
                  
                  <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                  <div class="col-md-4"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium *", "placeholder" => "Premium")); ?></div>
                </div>
                <hr> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>