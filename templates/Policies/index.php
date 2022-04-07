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
        <li>Policies</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Policies
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/policies/add">New</a>
        </div>
    <div class="panel-body articles-container">
        <div style="">
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-center">Number</th>
                    <th class="text-center">Holder</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Premium</th>

                    <th class="text-center">Mode</th>
                    <th class="text-center">Last Renewal</th>
                    <th class="text-center">Next Renewal</th>
                    <th class="text-center">Certificate</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php foreach($policies as $policy) : ?>
            <tr>
                <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                <td class="text-center"><?= $policy->customer->name ?></td>
                <td class="text-center"><?= $policy->customer->country->name ?></td>
                <td class="text-center"><?= $policy->company->name . " / ".  $policy->option->name ?></td>
                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?></td>
                <td class="text-center"><?= $modes[$policy->mode] ?></td>
                <td class="text-center"><?= date("F Y", strtotime($policy->last_renewal)) ?></td>
                <td class="text-center"><?= date("F Y", strtotime($policy->next_renewal)) ?></td>
                <?php if(!empty($policy->certificate)) : ?>
                    <td class="text-center">
                    <?= $this->Html->link('Download', '/img/certificates/'.$policy->certificate ,array('download'=> $policy->certificate)); ?>
                </td>
                <?php else : ?>
                    <td class="text-center">
                </td>
                <?php endif; ?>
                

                <td class="text-right">
                    <a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                
                    <a href="<?= ROOT_DIREC ?>/policies/delete/<?= $policy->id ?>" onclick="return confirm('Are you sure you would like to delete the policy <?= $policy->policy_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div><!--End .article-->
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
