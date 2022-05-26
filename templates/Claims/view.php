<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Claim $claim
 */
$age = "N/A";
if(!empty($claim->policy->customer->dob)){
    $dob = $claim->policy->customer->dob->year."-".$claim->policy->customer->dob->month."-".$claim->policy->customer->dob->day;
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dob), date_create($today));
    $age = $diff->format('%y');
}
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/claims">Claims</a></li>
        <li><?= $claim->policy->customer->name ?></li>
        <li><?= $claim->policy->policy_number ?></li>
        <li><?= $claim->title ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Claim Profile : <?= $claim->title ?> <a href="<?= ROOT_DIREC ?>/claims/edit/<?= $claim->id ?>" style="float:right"><button class="btn btn-warning">Edit</button></a><a target="_blank" href="<?= ROOT_DIREC ?>/claims/export/<?= $claim->id ?>" style="float:right;margin-right:5px"><button class="btn btn-default">Export</button></a>
                </div>
            <div class="panel-body articles-container">
                   <table class="table table-striped">
                    <tr>
                        <th><?= __('Policy Holder') ?></th>
                            <td class="text-right"><?= $claim->policy->customer->name ?></td>
                        </tr>
                        <tr>

                            <th><?= __('Policy Number') ?></th>
                            <td class="text-right"><?= $claim->policy->policy_number ?></td>
                        </tr>
                        <?php if(!empty($claim->policy->customer->dob)) : ?>
                            <tr>
                                <th>Date of Birth</th>
                                <td class="text-right"><?= date("M d Y", strtotime($claim->policy->customer->dob)) ?></td>
                            </tr>
                            <tr>
                                <th>Age</th>
                                <td class="text-right"><?= $age ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            
                            <th><?= __('Company') ?></th>
                            <td class="text-right"><?= $claim->policy->company->name ?></td>
                        </tr>
                        <tr>
                            
                            <th><?= __('Option') ?></th>
                            <td class="text-right"><?= $claim->policy->option->name ?></td>
                        </tr>
                        <tr>
                            
                            <th><?= __('Outside USA Deductible') ?></th>
                            <td class="text-right"><?= number_format($claim->policy->deductible, 2, ".", ",") ?></td>
                        </tr>
                        <tr>
                            
                            <th><?= __('USA Deductible') ?></th>
                            <td class="text-right"><?= number_format($claim->policy->usa_deductible, 2, ".", ",") ?></td>
                        </tr>
                        <tr>
                            
                            <th><?= __('Max Coverage') ?></th>
                            <td class="text-right"><?= number_format($claim->policy->max_coverage, 2, ".", ",") ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Title') ?></th>
                            <td class="text-right"><?= $claim->title ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Description') ?></th>
                            <td class="text-right"><?= $claim->description ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created By') ?></th>
                            <td class="text-right"><?= $claim->user->name ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td class="text-right"><?= date('M d Y', strtotime($claim->created)) ?></td>
                        </tr>
                        
                        <tr>
                            <th><?= __('Status') ?></th>
                            <?php if($claim->status == 1): ?>
                                <td class="text-right"><span class="label label-warning">Open</span></td>
                            <?php else : ?>
                                <td class="text-right"><span class="label label-success">Closed</span></td>
                            <?php endif; ?>
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
                    Details
                    <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#new_ct">Add</button>
                    <a href="<?= ROOT_DIREC ?>/claims/deductible/<?= $claim->id ?>/1" class="btn btn-primary" style="float:right;margin-right:5px" data-toggle="modal">Apply Full Deductible</a>
                    <a href="<?= ROOT_DIREC ?>/claims/deductible/<?= $claim->id ?>/0" class="btn btn-warning" style="float:right;margin-right:5px" data-toggle="modal">Apply 0 Deductible</a>
                </div>
                <div class="panel-body articles-container">
                  <div class="table-responsive">
                     <table class="table table-stripped datatable">
                <thead> 
                    <th>Description</th>
                    <th class="text-center">Attachment</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Received</th>
                    <th class="text-center">Serviced</th>
                    <th class="text-center">Processed</th>
                    <th class="text-center">Added By</th>
                    <th class="text-center">Type</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php $total=0; foreach($claim->claims_types as $ct) : ?>
                    <?php $total = $total + $ct->amount ?>
                        <tr style="background:<?= $ct->type->color ?>">
                            <td><strong><?= $ct->title ?></strong><br><?= $ct->description ?></td>
                            <?php if(!empty($ct->attachment)) : ?> 
                                <td class="text-center"><?= $this->Html->link('View', '/img/claims/'.$ct->attachment ,array('download'=> $ct->attachment)); ?></td>
                            <?php else : ?>
                                <td class="text-center"></td>
                            <?php endif; ?>
                            <td class="text-center"><?= number_format($ct->amount, 2, ".", ",") ?></td>
                            <?php if(!empty($ct->received_date)) : ?>
                                <td class="text-center"><?= date('M d Y', strtotime($ct->received_date)) ?></td>
                            <?php else : ?>
                                <td class="text-center"></td>
                            <?php endif; ?>

                            <?php if(!empty($ct->service_date)) : ?>
                                <td class="text-center"><?= date('M d Y', strtotime($ct->service_date)) ?></td>
                            <?php else : ?>
                                <td class="text-center"></td>
                            <?php endif; ?>

                            <?php if(!empty($ct->processed_date)) : ?>
                                <td class="text-center"><?= date('M d Y', strtotime($ct->processed_date)) ?></td>
                            <?php else : ?>
                                <td class="text-center"></td>
                            <?php endif; ?>
                            <td class="text-center"><?= $ct->user->name ?></td>
                            <td class="text-center"><?= $ct->type->name ?></td>
                            <td class="text-right"><a href="<?= ROOT_DIREC ?>/claimstypes/edit/<?= $ct->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                                <a href="<?= ROOT_DIREC ?>/claimstypes/delete/<?= $ct->id ?>" onclick="return confirm('Are you sure you would like to delete this detail')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th></th>
                        <th class="text-center"><?= number_format($total, 2, ".", ",") ?></th>
                        <th colspan="7"></th>
                    </tr>
                </tfoot>   
        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="new_ct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Information</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/claims/addct', 'type' => 'file')) ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('title', array('class' => 'form-control', "label" => "Title *", "placeholder" => "Title")); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description")); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('type_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $claims_types, "label" => "Type", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                <?= $this->Form->control('claim_id', array('type' => 'hidden',"value" => $claim->id)); ?>
                <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputFile">Attachment</label>
                        <input type="file" id="exampleInputFile" name="attachment">
                        <p class="help-block">Upload Attachment here.</p>
                      </div>
                    </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('amount', array('class' => 'form-control', "label" => "Amount *", "placeholder" => "Amount", 'value' => 0)); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4"><?= $this->Form->control('received_date', array('class' => 'form-control', "type" => "date", "label" => "Date Received", 'value' => date("Y-m-d"))); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('service_date', array('class' => 'form-control', "type" => "date", "label" => "Date of Service")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('processed_date', array('class' => 'form-control', "type" => "date", "label" => "Date Processed")); ?>
                    </div>
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


<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
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
    td, td.text-center{
        vertical-align: middle!important;
    }
</style>