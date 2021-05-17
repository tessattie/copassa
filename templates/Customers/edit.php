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
        <li><a href="<?= ROOT_DIREC ?>/customers">
            Policy Holders
        </a></li>
        <li>Edit</li>
        <li><?= $customer->name ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Policy Holder <?= $customer->name ?>
            <a href="<?= ROOT_DIREC ?>/policies/add"><button style="float:right" class="btn btn-warning" type="button">New Policy</button></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($customer) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail *", "placeholder" => "E-mail")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>Home Phone</label>
                        <div class="row">
                            <div class="col-md-4" style="padding-right:0px">
                                <?= $this->Form->control('home_area_code', array('class' => 'form-control', "label" => false, 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('home_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <label>Cell Phone</label>
                        <div class="row">
                            <div class="col-md-4" style="padding-right:0px">
                                <?= $this->Form->control('cell_area_code', array('class' => 'form-control', "label" => false, 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('cell_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Other Phone</label>
                        <div class="row">
                            <div class="col-md-4" style="padding-right:0px">
                                <?= $this->Form->control('other_area_code', array('class' => 'form-control', "label" => false, 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('other_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->control('address', array('class' => 'form-control', "label" => "Address *", "placeholder" => "Address")); ?>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
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
                                <th class="text-center">Company</th>
                                <th class="text-center">Option</th>
                                <th class="text-center">Premium</th>
                                <th class="text-center">Fee</th>
                                <th class="text-center">Mode</th>
                                <th class="text-center">Effective date</th>
                                <th class="text-center">Paid until</th>
                                <th class="text-center">Active</th>
                                <th class="text-center">Lapse</th>
                                <th class="text-center">Pending</th>
                                <th class="text-center">Grace Period</th>
                                <th class="text-center">Canceled</th>
                                <th class="text-center">Created by</th>
                                <th class="text-center">Created at</th>
                                <th class="text-center">Last modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($customer->policies as $policy) : ?>
                                <tr>
                                <td class="text-center"><?= $policy->policy_number ?></td>
                                <td class="text-center"><?= $policy->company->name ?></td>
                                <td class="text-center"><?= $policy->option->name ?></td>
                                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?> USD</td>
                                <td class="text-center"><?= number_format($policy->fee,2,".",",") ?> USD</td>
                                <td class="text-center"><?= $modes[$policy->mode] ?></td>
                                <td class="text-center"><?= date("M d Y", strtotime($policy->effective_date)) ?></td>
                                <td class="text-center"><?= date("M d Y", strtotime($policy->paid_until)) ?></td>
                                <?php if($policy->active == 1) : ?>
                                    <td class="text-center"><span class="label label-success">Yes</span></td>
                                <?php else : ?>
                                    <td class="text-center"><span class="label label-danger">No</span></td>
                                <?php endif; ?>

                                <?php if($policy->lapse == 1) : ?>
                                    <td class="text-center"><span class="label label-success">Yes</span></td>
                                <?php else : ?>
                                    <td class="text-center"><span class="label label-danger">No</span></td>
                                <?php endif; ?>

                                <?php if($policy->pending == 1) : ?>
                                    <td class="text-center"><span class="label label-success">Yes</span></td>
                                <?php else : ?>
                                    <td class="text-center"><span class="label label-danger">No</span></td>
                                <?php endif; ?>

                                <?php if($policy->grace_period == 1) : ?>
                                    <td class="text-center"><span class="label label-success">Yes</span></td>
                                <?php else : ?>
                                    <td class="text-center"><span class="label label-danger">No</span></td>
                                <?php endif; ?>
                                <?php if($policy->canceled == 1) : ?>
                                    <td class="text-center"><span class="label label-success">Yes</span></td>
                                <?php else : ?>
                                    <td class="text-center"><span class="label label-danger">No</span></td>
                                <?php endif; ?>
                                <td class="text-center"><?= $policy->user->name ?></td>
                                <td class="text-center"><?= date("M d Y", strtotime($policy->created)) ?></td>
                                <td class="text-center"><?= date("M d Y H:i", strtotime($policy->modified)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--End .articles-->
