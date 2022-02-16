<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Business $business
 */
$total = 0;
foreach($business->employees as $employee){
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
        <li><a href="<?= ROOT_DIREC ?>/businesses">Companies</a></li>
        <li>View</li>
        <li><?= $business->name ?></li>
    </ol>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
            Company Profile : <?= $business->name ?>
        </div>
        <div class="panel-body articles-container">       
                <table class = "table table-striped">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td class="text-right"><?= h($business->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Business Number') ?></th>
                        <td class="text-right"><?= h($business->business_number) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td class="text-right"><?= date("F d Y", strtotime($business->created)) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Last Modified') ?></th>
                        <td class="text-right"><?= date("F d Y", strtotime($business->modified)) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Total Premium') ?></th>
                        <td class="text-right"><span class="label label-info"><?= number_format($total, 2, ".", ",") ?></span></td>
                    </tr>
                </table>
            </div>
            
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
        <div class="panel-heading">
            Groups
            <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#new_group">New Group</button>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Insurance</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-center">Premium</th>
                    <th class="text-left"></th>
                </thead>
            <tbody> 
            <?php $real_total = 0; foreach($business->groupings as $group) : ?>
                <?php  
                $total = 0;
                foreach($group->employees as $employee){
                    if($employee->status == 1){
                        foreach($employee->families as $family){
                            if($family->status = 1){
                                $total = $total + $family->premium;
                            }
                        }
                    }
                }
                $real_total = $real_total + $total;
                ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/groupings/view/<?= $group->id ?>"><?= $group->grouping_number ?></a></td>
                    <td class="text-center"><?= $group->company->name ?></td>
                    <td class="text-center"><?= $group->company->country->name ?></td>
                    <td class="text-center"><?= date('F d Y', strtotime($group->effective_date)) ?></td>
                    <td class="text-center"><?= number_format($total, 2, ".", ",") ?></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/groupings/edit/<?= $group->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/groupings/delete/<?= $group->id ?>" onclick="return confirm('Are you sure you would like to delete the group <?= $group->grouping_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="4">Total</th><th class="text-center"><?= number_format($real_total, 2, ".", ",") ?></th><th></th></tr>
            </tfoot>
        </table>
        </div>
    </div>
    <?php echo $this->element('employees', array("employees" => $business->employees)); ?>
</div>

<?php echo $this->element('family_members', array("employees" => $business->employees)); ?>


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


<div class="modal fade" id="new_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/businesses/addgroup')) ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('grouping_number', array('class' => 'form-control', "label" => "Group Number *", "placeholder" => "Group Number")); ?></div>
                <?= $this->Form->control('business_id', array('type' => 'hidden', 'value' => $business->id)); ?> 
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('company_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $companies, "label" => "Insurance", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
              <div class="col-md-6"><?= $this->Form->control('effective_date', array('class' => 'form-control', "label" => "Effective Date *", 'type' => 'date', 'value' => date("Y-m-d"))); ?></div>
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

<div class="modal fade" id="new_employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/businesses/addemployee')) ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-4"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('membership_number', array('class' => 'form-control', "label" => "Membership Number *", "placeholder" => "Membership Number")); ?></div>
            </div>
            <hr>
            <div class="row">
                <?= $this->Form->control('business_id', array('type' => 'hidden',"value" => $business->id)); ?>
                <div class="col-md-4"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Choose Group --', "label" => "Group", "option" => $groupings, 'required' => true, 'style' => "height:46px")); ?></div> 
                <div class="col-md-4"><?= $this->Form->control('deductible', array('class' => 'form-control', "label" => "Deductible *", "placeholder" => "Deductible")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('effective_date', array('class' => 'form-control', "label" => "Effective Date *", 'type' => 'date', 'value' => date('Y-m-d'))); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px", 'value' => 1)); ?></div> 
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