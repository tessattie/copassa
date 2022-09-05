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
        <li><?= h($policy->policy_number) ?> - <?= h($policy->customer->name) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Policy : <?= h($policy->policy_number) ?> <?= (!empty($policy->plan)) ? " - ".h($plans[$policy->plan]) : "" ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                    <a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="float:right"><button class="btn btn-warning">Edit</button></a>
                <?php endif; ?>
                </div>
            <div class="panel-body articles-container">
                   <table class="table table-striped">
                    <tr>
                        <th><?= __('Company') ?></th>
                            <td class="text-right"><?= h($policy->company->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Option') ?></th>
                            <td class="text-right"><?= h($policy->option->name. " - " . $policy->option->option_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <td class="text-right"><?= h($company_types[$policy->company->type]) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Policy Number') ?></th>
                            <td class="text-right"><?= h($policy->policy_number) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Policy Holder') ?></th>
                            <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $policy->customer_id ?>"><?= h($policy->customer->name) ?></a></td>
                        </tr>
                        <?php if(!empty($policy->customer->country)) : ?>
                        <tr>
                            <th><?= __('Country') ?></th>
                            <td class="text-right"><?= h($policy->customer->country->name) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($policy->customer->agent)) : ?>
                        <tr>
                            <th><?= __('Agent') ?></th>
                            <td class="text-right"><?= h($policy->customer->agent->name) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?= __('Passport Number') ?></th>
                            <td class="text-right"><?= h($policy->passport_number) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Effective Date') ?></th>
                            <td class="text-right"><?= h(date('M d Y', strtotime($policy->effective_date))) ?></td>
                        </tr>
                        
                        <tr>
                            <th><?= __('Outside USA Deductible') ?></th>
                            <td class="text-right"><?= h(number_format($policy->deductible)) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Inside USA Deductible') ?></th>
                            <td class="text-right"><?= h(number_format($policy->usa_deductible)) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Max Coverage') ?></th>
                            <td class="text-right"><?= h(number_format($policy->max_coverage)) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Payment Mode') ?></th>
                            <td class="text-right"><?= h($modes[$policy->mode]) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Premium') ?></th>
                            <td class="text-right"><?= h($this->Number->format($policy->premium)) ?> USD</td>
                        </tr>
                        <tr>
                            <th><?= __('Paid Until') ?></th>
                            <td class="text-right"><?= h(date('M d Y', strtotime($policy->paid_until))) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Fee') ?></th>
                            <td class="text-right"><?= h($this->Number->format($policy->fee)) ?> USD</td>
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
                    <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                    <button class="btn btn-default" data-toggle="modal" data-target="#exampleModal" style="padding:2px 10px 5px;float:right"><span class="fa fa-plus"></span></button>
                        <?php endif; ?>
                </div>

                <div class="panel-body articles-container">
                    <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-center">Relation</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Age</th>
                                <th class="text-center">Sexe</th>
                                <th class="text-center">Exclusions</th>
                                <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                                <th class="text-center"></th>
                            <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($policy->dependants as $dep) : ?>
                            <?php 
                            if(!empty($dep->dob)){
                               $dob = $dep->dob->month."/".$dep->dob->day."/".$dep->dob->year;
                                $today = date("Y-m-d");
                                $diff = date_diff(date_create($dob), date_create($today));
                                $age = $diff->format('%y');

                                $dob = date("M d Y", strtotime($dob));
                            }else{
                                $dob = ''; 
                                $age = '';
                            }
                                
                            ?>
                                <tr>
                                    <td class="text-left"><?= h($dep->name) ?></td>
                                    <td class="text-center"><?= h($relations[$dep->relation]) ?></td>
                                    <?php if(!empty($dep->dob)) : ?>
                                        <td class="text-center"><?= h($dob) ?></td>
                                    <td class="text-center"><?= h($age) ?></td>
                                    <?php else : ?>
                                        <td></td>
                                        <td></td>
                                    <?php endif; ?>
                                    
                                    <td class="text-center"><?= h($sexe[$dep->sexe]); ?></td>
                                    <td class="text-center"><?= h($dep->limitations) ?></td>
                                    <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                                    <td class="text-center">
                                        <a href="<?= ROOT_DIREC ?>/dependants/edit/<?= $dep->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                                        <a href="<?= ROOT_DIREC ?>/dependants/delete/<?= $dep->id ?>" onclick="return confirm('Are you sure you would like to delete the dependant <?= h($dep->name) ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                                    </td>
                                <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Renewals
                </div>

                <div class="panel-body articles-container"  style="max-height:350px;overflow-y:scroll">
                    <div class="table-responsive">
                    <table class="table datable table-striped">
        <thead>
            <tr>
                <th>Renewal Date</th>
                <th class="text-center">Premium</th>
                <th class="text-center">Fee</th>
                <th class="text-center">Status</th>
                <th class="text-center">Policy Status</th>
                <th class="text-center">Paid on</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($policy->prenewals)) : ?>
                <?php foreach($policy->prenewals as $renewal) : ?>
                    <tr>
                        <td><?= h(date('F d Y', strtotime($renewal->renewal_date))); ?></td>
                        <td class="text-center"><?= h(number_format($renewal->premium, 2, ".", ",")) ?></td>
                        <td class="text-center"><?= h(number_format($renewal->fee, 2, ".", ",")) ?></td>
                        <?php if($renewal->status == 1) : ?>
                            <td class="text-center"><span class="label label-info">Upcomming</span></td>
                        <?php elseif($renewal->status == 3) : ?>
                            <td class="text-center"><span class="label label-warning">Canceled</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-success">Renewed</span></td>
                        <?php endif; ?>

                        <?php if($renewal->policy_status == 1) : ?>
                            <td class="text-center"><span class="label label-success">Active</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-danger">Canceled</span></td>
                        <?php endif; ?>
                        <?php if(!empty($renewal->payment_date)) : ?>
                        <td class="text-center"><?= h(date('F d Y', strtotime($renewal->payment_date))); ?></td>
                        <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                        <td class="text-right">
                            <a href="<?= ROOT_DIREC ?>/prenewals/edit/<?= $renewal->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
                </div>
            </div>
        </div>
    </div>

        </div>
        <div class="col-md-3">

            
            <?php if($user_connected['role_id'] != 2  || $auths[49]  || $auths[50]) : ?>
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Riders
                </div>
                <div class="panel-body articles-container">
                    <?php if($user_connected['role_id'] != 2  || $auths[50]) : ?>
                    <?= $this->Form->create() ?>
                    <input type="hidden" name="policy_id" value="<?= $policy->id ?>">
                <?php endif; ?>
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach($riders as $rider) : ?>
                                <tr>
                                    <?php if(in_array($rider->id, $policy_riders)) : ?>
                                        <td><strong><?= h($rider->name) ?></strong></td>
                                        
                                    <?php else : ?>
                                        <td><?= h($rider->name) ?></td>
                                    <?php endif; ?>
                                    <?php if($user_connected['role_id'] != 2  || $auths[50]) : ?>
                                    <td><input type="checkbox" value = "<?= $rider->id ?>" name="has_rider[]" <?= (in_array($rider->id, $policy_riders)) ? "checked" : "" ?>></td>
                                <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if($user_connected['role_id'] != 2  || $auths[50]) : ?>
                    <button type="submit" class="btn btn-success" style="float:right">UPDATE RIDERS</button>
                    <?= $this->Form->end() ?>
                <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>



            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Exclusions
                </div>
                <div class="panel-body articles-container">
                    <p><?= h($policy->exclusions) ?></p>
                </div>
            </div>
            <?php if($plan_type > 1) : ?>
            <?php if($user_connected['role_id'] != 2  || $auths[52]  || $auths[53]  || $auths[55]) : ?>
            <div class="panel panel-default">
            <div class="panel-heading">
                CLaims <?php if($user_connected['role_id'] != 2  || $auths[53]) : ?><button class="btn btn-default"  style="float:right;padding:1px 10px 5px" data-toggle="modal" data-target="#newclaim"><span class="fa fa-plus"></span></button><?php endif; ?>
                </div>
            <div class="panel-body" style="max-height:365px;overflow-y:scroll;background:white">
                        <?php foreach($policy->claims as $claim) : ?>
                    <?php  
                        $total = 0; 
                        foreach($claim->claims_types as $ct){
                            $total = $total + $ct->amount;
                        }
                    ?>

                    <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= h($policy->customer->name . " - " . $policy->policy_number) ?></p>
                        <p style="color:black;margin-top:10px"><span class="fa fa-file" style="margin-right:10px"></span> <strong>Diagnosis : </strong> <?= h($claim->title) ?></p>
                        <p style="color:black;margin-top:10px"><span class="fa fa-bars" style="margin-right:10px"></span> <strong>Description : </strong> <?= h($claim->description) ?></p>
                        <p style="color:black;margin-top:10px"><span class="fa fa-dollar" style="margin-right:10px"></span> <strong>Total Due : </strong> <?= h(number_format($total, 2, ".", ",")) ?></p>
                            </div>
                            <div class="col-xs-4" class="text-right">
                                <a class="btn btn-info" target="_blank" href="<?= ROOT_DIREC ?>/claims/view/<?= $claim->id ?>" style="float:right;margin-top:40px"><span class="fa fa-eye"></span></a>
                            </div>
                        </div>
                        <hr>
                        <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="panel panel-default">
            <div class="panel-heading">
                Files 
                <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                <button class="btn btn-default"  style="float:right;padding:1px 10px 5px" data-toggle="modal" data-target="#new_file"><span class="fa fa-plus"></span></button>
                <?php endif; ?>
                </div>
            <div class="panel-body" style="max-height:365px;overflow-y:scroll;background:white">
                        <?php foreach($policy->files as $file) : ?>

                    <div class="row">
                            <div class="col-xs-12">
                                <p style="color:black">
                                    <a href="#" class="download_file"> <input type="hidden" class="location" value="<?= $file->location ?>"><?= h($file->name) ?></a><br>
                                    <?= h($file->description) ?><br>
                                    <strong>Added :</strong> <?= h(date('M d Y', strtotime($file->created))) ?><br>
                                    <strong>By :</strong> <?= h($file->user->name) ?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <?php endforeach; ?>
            </div>
        </div>
        </div>
    </div>

    
</div>



<div class="modal fade" id="new_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New File</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/policies/addfile', 'type' => 'file')) ?>
      <div class="modal-body">
            <div class="row"><?= $this->Form->control('folder_id', array('type' => 'hidden','value' => $folder_id)); ?> <?= $this->Form->control('policy_id', array('type' => 'hidden','value' => $policy->id)); ?> 
                <div class="col-md-12"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "File Name")); ?></div>

            </div>

            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description")); ?></div>
            </div>
            <hr>
            <div class="row" style="margin-top:10px">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputFile">File</label>
                        <input type="file" id="exampleInputFile" name="file">
                        <p class="help-block">Upload File here.</p>
                      </div>
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


<div class="modal fade" id="newclaim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Claim</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/claims/add')) ?>
      <div class="modal-body">
                <div class="col-md-12"><?= $this->Form->control('policy_id', array('type' => 'hidden', "value" => $policy->id)); ?></div>

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

<?php 
    echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>

<script type="text/javascript">$(document).ready( function () {

    $(".download_file").click(function(){
        var location = $(this).find(".location").val(); 
        var token =  $('input[name="_csrfToken"]').val();
            var company = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/files/download',
                 type : 'POST',
                 data : {location : location},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 success : function(data, statut){
                      var win = window.open(data, '_blank');
                      if (win) {
                            win.focus();
                        } else {
                            alert('Please allow popups for this website');
                        }
                 },
                 error : function(resultat, statut, erreur){
                  console.log(erreur)
                 }, 
                 complete : function(resultat, statut){
                    console.log(resultat)
                 }
            });
    })
} );</script>