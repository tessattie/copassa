<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer[]|\Cake\Collection\CollectionInterface $customers
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Policy Holders</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Policy Holders
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/customers/add">
                                                <em class="fa fa-plus"></em> New Policy Holder
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Home Phone</th>
                    <th class="text-center">Cell Phone</th>
                    <th class="text-center">Other Phone</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($customers as $customer) : ?>
            <?php  
                $condition = false; 
                    if($customer->country_id == $filter_country || empty($filter_country)){
                        $condition = true;
                    }
            ?>
            <?php 
                $age = "N/A";
                if(!empty($customer->dob)){
                    $dob = $customer->dob->year."-".$customer->dob->month."-".$customer->dob->day;
                    $today = date("Y-m-d");
                    $diff = date_diff(date_create($dob), date_create($today));
                    $age = $diff->format('%y');
                }
            ?>
            <?php if($condition) : ?>
                <tr>

                    <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>"><?= $customer->name ?></a></td>

                    <?php if(!empty($customer->country_id)) : ?>
                        <td class="text-center"><?= $customer->country->name ?></td>
                    <?php else : ?>
                        <td class="text-center">N/A</td>
                    <?php endif; ?>
                    
                    <?php if(!empty($customer->home_phone)) : ?>
                        <td class="text-center">+(<?= $customer->home_area_code ?>)-<?= $customer->home_phone ?></td>
                    <?php else : ?>
                        <td class="text-center">-</td>
                    <?php endif; ?>

                    

                    <?php if(!empty($customer->cell_phone)) : ?>
                        <td class="text-center">+(<?= $customer->cell_area_code ?>)-<?= $customer->cell_phone ?></td>
                    <?php else : ?>
                        <td class="text-center">-</td>
                    <?php endif; ?>

                    <?php if(!empty($customer->other_phone)) : ?>
                        <td class="text-center">+(<?= $customer->other_area_code ?>)-<?= $customer->other_phone ?></td>
                    <?php else : ?>
                        <td class="text-center">-</td>
                    <?php endif; ?>
                    <?php if(!empty($customer->dob)) : ?>
                        <td class="text-center"><?= $customer->dob->month."/".$customer->dob->day."/".$customer->dob->year ?></td>
                    <?php else : ?>
                        <td class="text-center"></td>
                    <?php endif; ?>

                    <?php if(!empty($age)) : ?>
                        <td class="text-center"><?= $age ?></td>
                    <?php else : ?>
                        <td class="text-center"></td>
                    <?php endif; ?>
                    <?php if($customer->status == 1) : ?>
                        <td class="text-center"><span class="label label-success"><?= $status[$customer->status] ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger"><?= $status[$customer->status] ?></span></td>
                    <?php endif; ?>
                    
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                    <a href="<?= ROOT_DIREC ?>/customers/delete/<?= $customer->id ?>" onclick="return confirm('Are you sure you would like to delete the customer <?= $customer->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

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
</style>