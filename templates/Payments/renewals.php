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
                    <div class="col-md-5 text-right">
                        <a href="<?= ROOT_DIREC ?>/payments/exportrenewals/<?= $type_filter ?>/<?= $company_filter ?>"><button type="button" class="btn btn-warning" style="margin-top:24px;height:46px">Export</button></a>
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
                    <th>Name</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Policy</th>
                    <th class="text-center">Plan</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">LP</th>
                    <th class="text-center">Due</th>
                    <th class="text-center">%</th>
                    <th class="text-center">Effective</th>
                    <th class="text-center">Due</th>
                    <th class="text-right">Last Payment</th>
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

                        $percentage = ""; 
                        if(!empty($policy->last_premium)){
                            $percentage = ($policy->premium - $policy->last_premium)*100/$policy->last_premium;
                            $percentage = number_format($percentage, 2, ".",",");
                            $percentage .="%";
                        }
                        $next_renewal = $policy->next_renewal->year."-".$policy->next_renewal->month."-".$policy->next_renewal->day;
                        
                    ?>
                    <tr <?= (date("Y-m-d", strtotime($next_renewal)) >= date("Y-m-t", strtotime($from))) ? "style='background:#FFF8DC
'" : '' ?>>
                        <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $policy->customer_id ?>"><?= $policy->customer->name ?></a></td>

                        <?php if(!empty($age)) : ?>
                            <td class="text-center"><?= $age ?></td>
                        <?php else : ?>
                            <td class="text-center"></td>
                        <?php endif; ?>
                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                        <td class="text-center"><?= $policy->option->name." / ".$policy->option->option_name ?></td>
                        <td class="text-center"><?= $modes[$policy->mode] ?></td>
                        <td class="text-center"><?= number_format(($policy->last_premium+$policy->fee), 2, ".", ",") ?> USD</td>
                        <td class="text-center"><?= number_format(($policy->premium+$policy->fee), 2, ".", ",") ?> USD</td>
                        <td class="text-center"><?= $percentage ?></td>
                        <td class="text-center"><?= date('M d Y', strtotime($policy->effective_date)) ?></td>
                        <td class="text-center"><?= date('M d Y', strtotime($next_renewal)) ?></td>
                        <?php if(!empty($policy->last_payment)) : ?>
                        <td class="text-right"><?= date('M d Y', strtotime($policy->last_payment->created)) ?></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>
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
    td{
        vertical-align: middle!important;
    }
</style>