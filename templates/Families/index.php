<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Family[]|\Cake\Collection\CollectionInterface $families
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Family Members</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Family Members
            <?php if($user_connected['role_id'] != 2 || $auths[38]) : ?>
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/families/add">New</a>
        <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Full Name</th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Corporate Group</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Insurance</th>
                    <th class="text-center">Relationship</th>
                    <th class="text-center">DOB</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[37]) : ?>
                    <th class="text-center">Premium</th>
                    <?php endif; ?>
                        <th class="text-center">Status</th>
                        <?php if($user_connected['role_id'] != 2 || $auths[38]) : ?>
                        <th class="text-left"></th>
                    <?php endif; ?>
                </thead>
            <tbody> 
            <?php foreach($families as $family) : ?>
                <?php if(!empty($family->dob)){
                    $dob = $family->dob->year."-".$family->dob->month."-".$family->dob->day;
                    $dob = date("M d Y", strtotime($dob));
                }else{
                    $dob = '';
                } ?>
                <tr>
                    <td><?= $family->first_name." ".$family->last_name ?></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/employees/view/<?= $family->employee_id ?>"><?= $family->employee->first_name . " " .$family->employee->last_name ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/businesses/view/<?= $family->employee->business_id ?>"><?= $family->employee->business->name ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/groupings/view/<?= $family->employee->grouping_id ?>"><?= $family->employee->grouping->grouping_number ?></a></td>
                    <td class="text-center"><?= $family->employee->grouping->company->name ?></td>
                    <td class="text-center"><?= $relationships[$family->relationship] ?></td>
                    <td class="text-center"><?= $dob ?></td>
                    <?php if($user_connected['role_id'] != 2 || $auths[37]) : ?>
                        <td class="text-center"><?= number_format($family->premium,2,".",",") ?></td>
                    <?php endif; ?>
                    <?php if($family->status == 1) : ?>
                        <td class="text-center"><span class="label label-success">Active</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger">Inactive</span></td>
                    <?php endif; ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[38]) : ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/families/edit/<?= $family->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(empty($family->transactions)) : ?>
                        <a href="<?= ROOT_DIREC ?>/families/delete/<?= $family->id ?>" onclick="return confirm('Are you sure you would like to delete the family member <?= $family->first_name." ".$family->last_name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
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