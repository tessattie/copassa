<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Policy $policy
 */
$policy_riders = array(); 
foreach($policy->policies_riders as $pr){
    array_push($policy_riders, $pr->rider_id);
}

$pu = new \DateTime($policy->paid_until);

//Subtract a day using DateInterval
$yesterday = $pu->sub(new \DateInterval('P1D'));

//Get the date in a YYYY-MM-DD format.
$paiduntil = $yesterday->format('Y-m-d');
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/policies">Policies</a></li>
        <li><?= $policy->policy_number ?> - <?= $policy->customer->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Policy : <?= $policy->policy_number ?> <?= (!empty($policy->plan)) ? " - ".$plans[$policy->plan] : "" ?> 
                    <?php if($policy->pending_business == 1) : ?>
                        <span class="label label-warning">Pending Business</span>
                    <?php endif; ?>
                    <a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="float:right"><button class="btn btn-warning">Edit</button></a>
                </div>
            <div class="panel-body articles-container">
                   <table class="table table-striped">
                    <tr>
                        <th><?= __('Company') ?></th>
                            <td class="text-right"><?= $policy->company->name ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Option') ?></th>
                            <td class="text-right"><?= $policy->option->name. " - " . $policy->option->option_name ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <td class="text-right"><?= $company_types[$policy->company->type] ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Policy Number') ?></th>
                            <td class="text-right"><?= $policy->policy_number ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Policy Holder') ?></th>
                            <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $policy->customer_id ?>"><?= $policy->customer->name ?></a></td>
                        </tr>
                        <tr>
                            <th><?= __('Passport Number') ?></th>
                            <td class="text-right"><?= $policy->passport_number ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Effective Date') ?></th>
                            <td class="text-right"><?= date('M d Y', strtotime($policy->effective_date)) ?></td>
                        </tr>
                        
                        <tr>
                            <th><?= __('Outside USA Deductible') ?></th>
                            <td class="text-right"><?= number_format($policy->deductible) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Inside USA Deductible') ?></th>
                            <td class="text-right"><?= number_format($policy->usa_deductible) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Max Coverage') ?></th>
                            <td class="text-right"><?= number_format($policy->max_coverage) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Payment Mode') ?></th>
                            <td class="text-right"><?= $modes[$policy->mode] ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Premium') ?></th>
                            <td class="text-right"><?= $this->Number->format($policy->premium) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Paid Until') ?></th>
                            <td class="text-right"><?= date('M d Y', strtotime($policy->paid_until)) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Fee') ?></th>
                            <td class="text-right"><?= $this->Number->format($policy->fee) ?> USD</td>
                        </tr>
                        
                        
                        <tr>
                            <th><?= __('Certificate') ?></th>
                            <?php if(!empty($policy->certificate)) : ?>
                                <td class="text-right"><?= $this->Html->link('Download', '/img/certificates/'.$policy->certificate ,array('download'=> $policy->certificate)); ?></td>
                            <?php else : ?>
                                <td class="text-right"><a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>">Upload</a></td>
                            <?php endif; ?>
                            
                        </tr>
                    </table>
                </div>
                
            </div>

            <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    <?php if($policy->company->type == 1) : ?>
                        Benificiaries
                    <?php else : ?>
                        Dependants
                    <?php endif; ?>
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" style="padding:2px 10px 5px;float:right"><span class="fa fa-plus"></span></button>
                </div>

                <div class="panel-body articles-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Relation</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Age</th>
                                <th class="text-center">Sexe</th>
                                <th class="text-center">Exclusions</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($policy->dependants as $dep) : ?>
                            <?php 
                            if(!empty($dep->dob)){
                               $dob = $dep->dob;
                                $today = date("Y-m-d");
                                $diff = date_diff(date_create($dob), date_create($today));
                                $age = $diff->format('%y'); 
                            }
                                
                            ?>
                                <tr>
                                    <td class="text-center"><?= $dep->name ?></td>
                                    <td class="text-center"><?= $relations[$dep->relation] ?></td>
                                    <?php if(!empty($dep->dob)) : ?>
                                        <td class="text-center"><?= $dep->dob->month."/".$dep->dob->day."/".$dep->dob->year ?></td>
                                    <td class="text-center"><?= $age ?></td>
                                    <?php else : ?>
                                        <td></td>
                                        <td></td>
                                    <?php endif; ?>
                                    
                                    <td class="text-center"><?= $sexe[$dep->sexe]; ?></td>
                                    <td class="text-center"><?= $dep->limitations ?></td>
                                    <td class="text-center">
                                        <a href="<?= ROOT_DIREC ?>/dependants/edit/<?= $dep->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                                        <a href="<?= ROOT_DIREC ?>/dependants/delete/<?= $dep->id ?>" onclick="return confirm('Are you sure you would like to delete the dependant <?= $dep->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Riders
                </div>
                <div class="panel-body articles-container">
                    <?= $this->Form->create() ?>
                    <input type="hidden" name="policy_id" value="<?= $policy->id ?>">
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach($riders as $rider) : ?>
                                <tr>
                                    <td><?= $rider->name ?></td>
                                    <td><input type="checkbox" value = "<?= $rider->id ?>" name="has_rider[]" <?= (in_array($rider->id, $policy_riders)) ? "checked" : "" ?>></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success" style="float:right">UPDATE RIDERS</button>
                    <?= $this->Form->end() ?>
                </div>
            </div>

            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Exclusions
                </div>
                <div class="panel-body articles-container">
                    <p><?= $policy->exclusions ?></p>
                </div>
            </div>
        </div>
    </div>

    
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create($dependant, array("url" => "/dependants/add")) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            <?php if($policy->company->type == 1) : ?>
                New Benificiary
            <?php else : ?>
                New Dependant
            <?php endif; ?>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('policy_id', array('type' => 'hidden', "value" => $policy->id)); ?>
                <?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                <hr>
                <?= $this->Form->control('sexe', array('class' => 'form-control', "label" => "Sexe *", "empty" => "-- Choose --", 'options' => $sexe)); ?>
                <hr>
                <?= $this->Form->control('relation', array('class' => 'form-control', "label" => "Relation *", "empty" => "-- Choose --", 'options' => $relations)); ?>
                <hr>
                <?= $this->Form->control('dob', array('class' => 'form-control', "type" => "date", "label" => "DOB *")); ?>
                <hr>
                <?= $this->Form->control('limitations', array('class' => 'form-control', "label" => "Exclusions *", "placeholder" => "Exclusions / Limitations")); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
        <button type="submit" class="btn btn-success">ADD</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>