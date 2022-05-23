<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */

$age = "N/A";
if(!empty($customer->dob)){
    $dob = $customer->dob->year."-".$customer->dob->month."-".$customer->dob->day;
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
        <li><a href="<?= ROOT_DIREC ?>/customers">Policy Holders</a></li>
        <li><?= $customer->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Policy Holder : <?= $customer->name ?>
                </div>
            <div class="panel-body articles-container">
                   <table class="table table-striped">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td class="text-right"><?= h($customer->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Country') ?></th>
                            <td class="text-right"><?= h($customer->country->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td class="text-right"><?= h($customer->email) ?></td>
                        </tr>
                        <?php if(!empty($customer->home_phone)) : ?>
                        <tr>
                            <th><?= __('Home Phone') ?></th>
                            <td class="text-right"><?= $customer->home_area_code." ". h($customer->home_phone) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($customer->cell_phone)) : ?>
                        <tr>
                            <th><?= __('Cell Phone') ?></th>
                            <td class="text-right"><?= $customer->cell_area_code." ". h($customer->cell_phone) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($customer->other_phone)) : ?>
                        <tr>
                            <th><?= __('Other Phone') ?></th>
                            <td class="text-right"><?= $customer->other_area_code." ". h($customer->other_phone) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?= __('Address') ?></th>
                            <td class="text-right"><?= h($customer->address) ?></td>
                        </tr>
                        <?php if(!empty($customer->dob)) : ?>
                            <tr>
                                <th>Date of Birth</th>
                                <td class="text-right"><?= date("M d Y", strtotime($customer->dob)) ?></td>
                            </tr>
                            <tr>
                                <th>Age</th>
                                <td class="text-right"><?= $age ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?= __('Created By') ?></th>
                            <td class="text-right"><?= $customer->user->name ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td class="text-right"><?= date("M d Y", strtotime($customer->created)) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Last Modified') ?></th>
                            <td class="text-right"><?= date("M d Y", strtotime($customer->modified)) ?></td>
                        </tr>

                    </table>
                </div>
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Notes
                    <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-success" style="float:right;padding:3px 10px 5px"><span class="fa fa-plus"></span></button>
                </div>
                <div class="panel-body articles-container" style="height: 384px; overflow-y:scroll">       
                    <?php foreach($customer->notes as $n) : ?>
                        <p class="bg-info" style="padding:10px">
                            <a href="<?= ROOT_DIREC ?>/notes/delete/<?= $n->id ?>" style="float:right;padding:2px 5px;background:red"><span class="fa fa-remove"></span></a>
                            <label>Created By :</label> <?= $n->user->name ?><br>
                            <label>Date :</label> <?= date("M d Y H:i", strtotime($n->created)) ?><br><br>
                            <?= $n->comment ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                
            </div>
        </div>
    </div>
    

    <div class="panel panel-default articles">
        <div class="panel-heading">
            Policies
        </div>
        <div class="panel-body articles-container">       
            <div class="row">
                <div class="col-md-12">
                    <div style="width:100%;overflow-y:scroll">
                    <table class="table table-bordered" style="width:2000px">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Option</th>
                                <th class="text-center">Premium</th>
                                <th class="text-center">Fee</th>
                                <th class="text-center">Deductible</th>
                                <th class="text-center">Mode</th>
                                <th class="text-center">Effective date</th>
                                <th class="text-center">Certificate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($customer->policies as $policy) : ?>

                                <tr>
                                <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                                <td class="text-center"><?= $company_types[$policy->company->type] ?></td>
                                <td class="text-center"><?= $policy->company->name ?></td>
                                <td class="text-center"><?= $policy->option->name ?></td>
                                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?> USD</td>
                                <td class="text-center"><?= number_format($policy->fee,2,".",",") ?> USD</td>
                                <td class="text-center"><?= number_format($policy->deductible,2,".",",") ?> USD</td>
                                <td class="text-center"><?= $modes[$policy->mode] ?></td>
                                <td class="text-center"><?= date("M d Y", strtotime($policy->effective_date)) ?></td>
                      
                                <td class="text-center">
                                    <?= $this->Html->link('Download', '/img/certificates/'.$policy->certificate ,array('download'=> $policy->certificate)); ?>
                                </td>
                                <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-default articles">
        <div class="panel-heading">
            Exclusions 
    </div>
    <div class="panel-body articles-container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Policy</th>
                <th class="text-center">Exclusions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customer->policies as $p) : ?>
                <tr>
                    <td class="text-center"><?= $p->policy_number ?></td>
                    <td class="text-center"><?= $p->exclusions ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            <!--End .article-->
        </div>
    </div>
</div>




<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create($note, array("url" => "/notes/add")) ?>
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">New Note</h3>
      </div>
      <div class="modal-body">
        <?= $this->Form->control('customer_id', array('type' => 'hidden', "value" => $customer->id)); ?>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('comment', array('class' => 'form-control', "label" => false, "placeholder" => "Write a note here...")); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        <button type="submit" class="btn btn-success">ADD</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>