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
            Edit <?= $customer->name ?>
            
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($customer) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail *", "placeholder" => "E-mail")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('dob', array('class' => 'form-control', "type" => "date", "label" => "Date of Birth *")); ?>
                    </div>                  
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>Home Phone</label>
                        <div class="row">
                            <div class="col-md-4" >
                                <?= $this->Form->control('home_area_code', array('class' => 'form-control', "label" => false, "value" => "1", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('home_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <label>Cell Phone</label>
                        <div class="row">
                            <div class="col-md-4" >
                                <?= $this->Form->control('cell_area_code', array('class' => 'form-control', "label" => false, "value" => "1", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('cell_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Other Phone</label>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $this->Form->control('other_area_code', array('class' => 'form-control', "label" => false, "value" => "1", 'options' => $area_codes)); ?>
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
                <hr>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('country_id', array('class' => 'form-control', 'empty' => '-- Choose country --', 'options' => $countries, "label" => "Country", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
                    </div> 
                    <div class="col-md-3"><?= $this->Form->control('agent_id', array('class' => 'form-control', 'options' => $agents, "label" => "Agent", "empty" => '-- Choose country to see agents --', 'required' => false, 'style' => "height:46px",)); ?>
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
            Policies <a href="<?= ROOT_DIREC ?>/policies/add/<?= $customer->id ?>"><button style="float:right" class="btn btn-warning" type="button">New Policy</button></a>
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
                                <th class="text-center">Created By</th>
                                <th class="text-center">Certificate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($customer->policies as $policy) : ?>

                                <?php 
                                //Today's date.
                                $pu = new \DateTime($policy->paid_until);

                                //Subtract a day using DateInterval
                                $yesterday = $pu->sub(new \DateInterval('P1D'));

                                //Get the date in a YYYY-MM-DD format.
                                $paiduntil = $yesterday->format('Y-m-d');

                                ?>
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
           
                                <td class="text-center"><?= $policy->user->name ?></td>
                                <?php if(!empty($policy->certificate)) : ?>
                                    <td class="text-center">
                                        <?= $this->Html->link('Download', '/img/certificates/'.$policy->certificate ,array('download'=> $policy->certificate)); ?>
                                    </td>
                                <?php else : ?>
                                    <td class="text-center">
                                </td>
                                <?php endif; ?>
                                
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
</div><!--End .articles-->


<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }

      
    }
</style>