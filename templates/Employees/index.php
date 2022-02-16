<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee[]|\Cake\Collection\CollectionInterface $employees
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Employees</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Employees
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-plus"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/employees/add">
                                    <em class="fa fa-plus"></em> New Employee
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
                    <th>Full Name</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Insurance</th>
                    <th class="text-center">Membership Number</th>
                    <th class="text-center">Deductible</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-left"></th>
                </thead>
            <tbody> 
            <?php foreach($employees as $employee) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/employees/view/<?= $employee->id ?>"><?= $employee->first_name." ".$employee->last_name ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/businesses/view/<?= $employee->grouping->business_id ?>"><?= $employee->business->name ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/groupings/view/<?= $employee->grouping_id ?>"><?= $employee->grouping->grouping_number ?></a></td>
                    <td class="text-center"><?= $employee->grouping->company->name ?></td>
                    <td class="text-center"><?= $employee->membership_number ?></td>
                    <td class="text-center"><?= number_format($employee->deductible, 2, ".", ",") ?></td>
                    <td class="text-center"><?= date('F d Y', strtotime($employee->effective_date)) ?></td>
                    <?php if($employee->status == 1) : ?>
                        <td class="text-center"><span class="label label-success">Active</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger">Inactive</span></td>
                    <?php endif; ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/employees/edit/<?= $employee->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/employees/delete/<?= $employee->id ?>" onclick="return confirm('Are you sure you would like to delete the employee <?= $employee->grouping_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
