<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Reports</li>
        <li class="active">Policies</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
    <div class="panel-body articles-container">       
            <?= $this->Form->create() ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $this->Form->control('type', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $company_types, "label" => "Type", "multiple" => false,  'style' => "height:46px")); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('company_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $comps, "label" => "Company", "multiple" => false, 'style' => "height:46px")); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:24px;height:46px")) ?>
                    </div>
                </div>

            <?= $this->Form->end() ?>
        </div>
        
    </div>
    <?php foreach($companies as $company) : ?>
        <?php if($company->policies->count() > 0) : ?>
    <div class="panel panel-default articles">
        <div class="panel-heading">
            <?= $company->name ?>
        </div>
    <div class="panel-body articles-container">
        
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Insured Name</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Policy Number</th>
                    <th class="text-center">Plan</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Premium Due</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-right">Due Date</th>
                </thead>
            <tbody> 
                <?php foreach($company->policies as $policy) : ?>
                    <?php 
                        $age = "N/A";
                        if(!empty($policy->customer->dob)){
                            $dob = $policy->customer->dob->year."-".$policy->customer->dob->month."-".$policy->customer->dob->day;
                            $today = date("Y-m-d");
                            $diff = date_diff(date_create($dob), date_create($today));
                            $age = $diff->format('%y');
                        }
                    ?>
                    <tr>
                        <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $policy->customer_id ?>"><?= $policy->customer->name ?></a></td>

                        <?php if(!empty($age)) : ?>
                            <td class="text-center"><?= $age ?></td>
                        <?php else : ?>
                            <td class="text-center"></td>
                        <?php endif; ?>
                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                        <td class="text-center"><?= $policy->option->name." / ".$policy->option->option_name ?></td>
                        <td class="text-center"><?= $modes[$policy->mode] ?></td>
                        <td class="text-center"><?= number_format(($policy->premium+$policy->fee), 2, ".", ",") ?> USD</td>
                        <td class="text-center"><?= date('M d Y', strtotime($policy->effective_date)) ?></td>
                        <td class="text-right"><?= date('M d Y', strtotime($policy->paid_until)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
            <!--End .article-->
        </div>
        
    </div>
<?php endif; ?>
    <?php endforeach; ?>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
    });
    });
</script>

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