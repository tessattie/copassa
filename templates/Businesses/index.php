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
            <?php if($user_connected['role_id'] != 2 || $auths[38]) : ?>
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/businesses/add">New</a>
        <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Groups</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[37]) : ?>
                    <th class="text-center">Premium</th>
                <?php endif; ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[38]) : ?>
                    <th class="text-center"></th>
                <?php endif; ?>
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
                    <td><a href="<?= ROOT_DIREC ?>/businesses/view/<?= $business->id ?>"><?= h($business->business_number) ?></a></td>
                    <td class="text-center"><?= h($business->name) ?></td>
                    <td class="text-center"><?= h(count($business->groupings)) ?></td>
                    <?php if($user_connected['role_id'] != 2 || $auths[37]) : ?>
                    <td class="text-center"><?= h(number_format($total, 2, ".", ",")) ?></td>
                <?php endif; ?>
                <?php if($user_connected['role_id'] != 2 || $auths[38]) : ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/businesses/edit/<?= $business->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(empty($business->groupings) && empty($business->renewals)) : ?>
                        <a href="<?= ROOT_DIREC ?>/businesses/delete/<?= $business->id ?>" onclick="return confirm('Are you sure you would like to delete the company <?= h($business->name) ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
                </tr>
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