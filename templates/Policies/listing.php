<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>Policies</li>
    </ol>
</div>

<div class="modal fade" id="filters" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create() ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            Filter
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('country_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $filter_countries, "label" => "Country", "multiple" => false, 'style' => "height:46px", 'value' => $country_id)); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('agent_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $agents, "label" => "Agent", "multiple" => false, 'style' => "height:46px", 'value' => $agent_id)); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('company_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $companies, "label" => "Company", "multiple" => false, 'style' => "height:46px", 'value' => $company_id)); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('type', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $company_types, "label" => "Type", "multiple" => false,  'style' => "height:46px", 'value' => $type)); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('mode', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $modes, "label" => "Mode", "multiple" => false, 'style' => "height:46px", 'value' => $mode)); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('young_policies', array('type' => 'checkbox',  "label" => "Policies with effective dates less than a year old", 'checked' => $young_policies)); ?>
            </div>
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Filter</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>


<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Policies
            <?php if($user_connected['role_id'] != 2 || $auths[3]) : ?>
            <a target="_blank" href="<?= ROOT_DIREC ?>/policies/exportlisting/<?= $country_id ?>/<?= $company_id ?>/<?= $type ?>/<?= $mode ?>/<?= $young_policies ?>/<?= $agent_id ?>" style="float:right;" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span></a>

            <a href="<?= ROOT_DIREC ?>/policies/exportlistingexcel/<?= $country_id ?>/<?= $company_id ?>/<?= $type ?>/<?= $mode ?>/<?= $young_policies ?>/<?= $agent_id ?>" style="float:right;margin-right:10px;background:#26580F;border:1px solid #26580F" class="btn btn-success"><span class="fa fa-file-excel-o"></span></a>
        <?php endif; ?>
        <button type="button" data-toggle="modal" data-target="#filters" class="btn btn-info" style="float:right;margin-right:10px"><span class="fa fa-filter"></span></button>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Number</th>
                    <th class="text-center">Holder</th>
                    
                    <th class="text-center">Company</th>
                    <th class="text-center">Premium</th>

                    <th class="text-center">Mode</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-center">Country</th>
                    <th class="text-right">Agent</th>
                </thead>
            <tbody> 
                <?php foreach($policies as $policy) : ?>
                    <tr>
                        <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                        <td class="text-center"><?= $policy->customer->name ?></td>
                        
                        <?php if(!empty($policy->company)) : ?>
                            <?php if(!empty($policy->option)) : ?>
                            <td class="text-center"><?= $policy->company->name . " / ".  $policy->option->name ?></td>
                            <?php else : ?>
                                <td class="text-center"><?= $policy->company->name ?></td>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if(!empty($policy->option)) : ?>
                            <td class="text-center"><?= $policy->option->name ?></td>
                            <?php else : ?>
                                <td class="text-center"></td>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <td class="text-center"><?= number_format($policy->premium,2,".",",") ?></td>
                        <td class="text-center"><?= $modes[$policy->mode] ?></td>
                        <td class="text-right"><?= date('M d Y', strtotime($policy->effective_date)) ?></td>
                        <td class="text-center"><?= substr($policy->customer->country->name, 0, 5) ?></td>
                        <?php if(!empty($policy->customer->agent)) : ?>

                            <td class="text-center"><?= $policy->customer->agent->name ?></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            </div><!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

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
