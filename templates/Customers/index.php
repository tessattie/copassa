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
            <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/customers/add">New</a>
            <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Cell Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Status</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                    <th class="text-center"></th>
                    <?php endif; ?>
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

                    <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>"><?= h($customer->name) ?></a></td>

                    <?php if(!empty($customer->country_id)) : ?>
                        <td class="text-center"><?= h(substr($customer->country->name,0,5)) ?></td>
                    <?php else : ?>
                        <td class="text-center">N/A</td>
                    <?php endif; ?>

                    

                    <?php if(!empty($customer->cell_phone)) : ?>
                        <td class="text-center">+(<?= h($customer->cell_area_code) ?>)-<?= h($customer->cell_phone) ?></td>
                    <?php else : ?>
                        <td class="text-center">-</td>
                    <?php endif; ?>

                    <td class="text-center"><?= h($customer->email) ?></td>
                    <?php if(!empty($customer->dob)) : ?>
                        <td class="text-center"><?= h(date("M d Y", strtotime($dob))) ?></td>
                    <?php else : ?>
                        <td class="text-center"></td>
                    <?php endif; ?>

                    <?php if(!empty($age)) : ?>
                        <td class="text-center"><?= h($age) ?></td>
                    <?php else : ?>
                        <td class="text-center"></td>
                    <?php endif; ?>
                    <?php if($customer->status == 1) : ?>
                        <td class="text-center"><span class="label label-success"><?= h($status[$customer->status]) ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger"><?= h($status[$customer->status]) ?></span></td>
                    <?php endif; ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[24]) : ?>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(count($customer->policies) == 0) : ?>
                    <a href="<?= ROOT_DIREC ?>/customers/delete/<?= $customer->id ?>" onclick="return confirm('Are you sure you would like to delete the customer <?= h($customer->name) ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                <?php endif; ?>
                    </td>
                <?php endif; ?>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table></div>
            <!--End .article-->
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