<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouping[]|\Cake\Collection\CollectionInterface $groupings
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Groups</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Groups
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/groupings/add">New</a>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Insurance</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Premium</th>
                    <th class="text-left"></th>
                </thead>
            <tbody> 
            <?php $real_total = 0; foreach($groupings as $group) : ?>
                <?php  
                $total = 0;
                foreach($group->employees as $employee){
                    if($employee->status == 1){
                        foreach($employee->families as $family){
                            if($family->status = 1){
                                $total = $total + $family->premium;
                            }
                        }
                    }
                }
                $real_total = $real_total + $total;
                ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/groupings/view/<?= $group->id ?>"><?= $group->grouping_number ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/businesses/view/<?= $group->business_id ?>"><?= $group->business->name ?></a></td>
                    <td class="text-center"><?= $group->company->name ?></td>
                    <td class="text-center"><?= date('F d Y', strtotime($group->effective_date)) ?></td>
                    <td class="text-center"><?= number_format($total, 2, ".", ",") ?></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/groupings/edit/<?= $group->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(empty($group->employees)) : ?>
                        <a href="<?= ROOT_DIREC ?>/groupings/delete/<?= $group->id ?>" onclick="return confirm('Are you sure you would like to delete the group <?= $group->grouping_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="4">Total</th><th class="text-center"><?= number_format($real_total, 2, ".", ",") ?></th><th></th></tr>
            </tfoot>
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
