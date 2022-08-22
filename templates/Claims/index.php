<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Claim[]|\Cake\Collection\CollectionInterface $claims
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Claims</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Claims
            <?php if($user_connected['role_id'] != 2 || $auths[53]) : ?>
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/claims/add">New</a>
            <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Policy</th>
                    <th class="text-center">Policy Holder</th>
                    <th class="text-center">Dependant</th>
                    <th class="text-center">Diagnosis</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Status</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[53] || $auths[52] || $auths[55]) : ?>
                    <th class="text-right"></th>
                    <?php endif; ?>
                </thead>
            <tbody> 
        <?php foreach($claims as $claim) : ?>
            <?php 
                $total = 0;
                foreach($claim->claims_types as $ct){
                    $total = $total + $ct->amount;
                }
            ?>
            <tr>
                <td><?= h($claim->policy->policy_number) ?></td>
                <td class="text-center"><?= h($claim->policy->customer->name) ?></td>
                <?php if(!empty($claim->dependant_id)) : ?>
                    <td class="text-center"><?= h($claim->dependant->name) ?></td>
                <?php else : ?>
                    <td class="text-center"></td>
                <?php endif; ?>
                <td class="text-center"><?= h($claim->title) ?></td>
                <td class="text-center"><?= h($claim->description) ?></td>
                <td class="text-center"><?= h(number_format($total, 2, ".", ",")) ?></td>
                <td class="text-center"><?= h(date("M d Y", strtotime($claim->created))) ?></td>
                <?php if($claim->status == 1): ?>
                    <td class="text-center"><span class="label label-warning">Open</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-success">Closed</span></td>
                <?php endif; ?>

                
                <td class="text-right">
                    <?php if($user_connected['role_id'] != 2 || $auths[53] || $auths[52] || $auths[55]) : ?>
                    <a href="<?= ROOT_DIREC ?>/claims/view/<?= $claim->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-eye color-blue"></span></a>
                    <?php endif; ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[53]) : ?>
                        <?php if(empty($claim->claims_types)): ?>
                        <a href="<?= ROOT_DIREC ?>/claims/delete/<?= $claim->id ?>" onclick="return confirm('Are you sure you would like to delete this claim')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
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