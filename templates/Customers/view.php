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
                    <?= $customer->name ?>
                    <?php if($user_connected['role_id'] != 2  || $auths[24]) : ?>
            <a class="btn btn-default"  style="float:right;padding:1px 10px 5px" href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>"><span class="fa fa-pencil"></span></a>
        <?php endif; ?>
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
                        <?php if(!empty($customer->agent)) : ?>
                        <tr>
                            <th><?= __('Agent') ?></th>
                            <td class="text-right"><?= $customer->agent->name ?></td>
                        </tr>
                        <?php endif; ?>
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

            <div class="panel panel-default articles">
        <div class="panel-heading">
            Policies 
            <?php if($user_connected['role_id'] != 2  || $auths[24]) : ?>
            <a class="btn btn-default"  style="float:right;padding:1px 10px 5px" href="<?= ROOT_DIREC ?>/policies/add/<?= $customer->id ?>"><span class="fa fa-plus"></span></a>
        <?php endif; ?>
        </div>
        <div class="panel-body articles-container">       
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
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
                                <?php if($user_connected['role_id'] != 2  || $auths[24]) : ?>
                                <th></th>
                            <?php endif; ?>
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
                                    <?php if(!empty($policy->certificate)) : ?>
                                        <?= $this->Html->link('Download', '/img/certificates/'.$policy->certificate ,array('download'=> $policy->certificate)); ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <?php if($user_connected['role_id'] != 2  || $auths[24]) : ?>
                                <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                            <?php endif; ?>
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
        <div class="col-md-3">
            <?php if($user_connected['role_id'] != 2  || $auths[52]  || $auths[53]  || $auths[55]) : ?>
            <div class="panel panel-teal">
            <div class="panel-heading">

                CLaims 
                <?php if($user_connected['role_id'] != 2  || $auths[53]) : ?>
                <button class="btn btn-default"  style="float:right;padding:1px 10px 5px" data-toggle="modal" data-target="#newclaim"><span class="fa fa-plus"></span></button> <?php endif; ?>
                </div>
            <div class="panel-body" style="height:365px;overflow-y:scroll;background:white">
                    <?php foreach($customer->policies as $policy) : ?>
                        <?php foreach($policy->claims as $claim) : ?>
                    <?php  
                        $total = 0; 
                        foreach($claim->claims_types as $ct){
                            $total = $total + $ct->amount;
                        }
                    ?>

                    <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= $customer->name . " - " . $policy->policy_number ?></p>
                        <p style="color:black;margin-top:10px"><span class="fa fa-file" style="margin-right:10px"></span> <strong>Diagnosis : </strong> <?= $claim->title ?></p>
                        <p style="color:black;margin-top:10px"><span class="fa fa-bars" style="margin-right:10px"></span> <strong>Description : </strong> <?= $claim->description ?></p>
                        <p style="color:black;margin-top:10px"><span class="fa fa-dollar" style="margin-right:10px"></span> <strong>Total Due : </strong> <?= number_format($total, 2, ".", ",") ?></p>
                            </div>
                            <div class="col-xs-4" class="text-right">
                                <a class="btn btn-info" target="_blank" href="<?= ROOT_DIREC ?>/claims/view/<?= $claim->id ?>" style="float:right;margin-top:40px"><span class="fa fa-eye"></span></a>
                            </div>
                        </div>
                        <hr>
                        <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

            <div class="panel panel-warning articles">
                <div class="panel-heading">
                    Notes
                    <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-default" style="float:right;padding:1px 10px 5px"><span class="fa fa-plus"></span></button>
                </div>
                <div class="panel-body articles-container" style="height: 384px; overflow-y:scroll">       
                    <?php foreach($customer->notes as $n) : ?>
                        <p class="bg-info" style="padding:10px">
                            <label>Created By :</label> <?= $n->user->name ?><br>
                            <label>Date :</label> <?= date("M d Y H:i", strtotime($n->created)) ?><br><br>
                            <?= $n->comment ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                
            </div>

            
        </div>
    </div>
    

    


    <div class="modal fade" id="newclaim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Claim</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/claims/add')) ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('policy_id', array('class' => 'form-control', "label" => "Policy Number *", "empty" => "-- Choose Policy --", 'options' => $policies)); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('title', array('class' => 'form-control', "label" => "Diagnosis *", "placeholder" => "Diagnosis")); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description")); ?></div>
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