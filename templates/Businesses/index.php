<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Corporate Groups</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Corporate Groups
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/businesses/add">New</a>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Groups</th>
                    <th class="text-center">Premium</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
            <?php foreach($businesses as $business) : ?>
                <?php 
                    $total = 0;
                    foreach($business->groupings as $group){
                        foreach($group->employees as $employee){
                            if($employee->status == 1){
                                foreach($employee->families as $family){
                                    if($family->status = 1){
                                        $total = $total + $family->premium;
                                    }
                                }
                            }
                        }
                    }
                ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/businesses/view/<?= $business->id ?>"><?= $business->business_number ?></a></td>
                    <td class="text-center"><?= $business->name ?></td>
                    <td class="text-center"><?= count($business->groupings) ?></td>
                    <td class="text-center"><?= number_format($total, 2, ".", ",") ?></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/businesses/edit/<?= $business->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(empty($business->groupings) && empty($business->renewals)) : ?>
                        <a href="<?= ROOT_DIREC ?>/businesses/delete/<?= $business->id ?>" onclick="return confirm('Are you sure you would like to delete the company <?= $business->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
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