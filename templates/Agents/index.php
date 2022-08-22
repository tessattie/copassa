<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agent[]|\Cake\Collection\CollectionInterface $agents
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Agents</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Agents
            <?php if($user_connected['role_id'] != 2 || $auths[60]) : ?>
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/agents/add">New</a>
            <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[16]  || $auths[17] || $auths[62]) : ?>
                    <th class="text-<?= ($user_connected['role_id'] != 2 || $auths[60]) ? 'center' : 'right' ?>">Countries</th>
                    <?php endif; ?>     
                    <?php if($user_connected['role_id'] != 2 || $auths[60]) : ?><th class="text-center"></th>
                    <?php endif; ?>
                </thead>
            <tbody> 
            <?php foreach($agents as $agent) : ?>
                <?php if($agent->country_id == $filter_country || empty($filter_country)) : ?>
                <tr>
                    <td><?= h($agent->name) ?></td>
                    <?php if($user_connected['role_id'] != 2 || $auths[16]  || $auths[17] || $auths[62]) : ?>
                    <td class="text-<?= ($user_connected['role_id'] != 2 || $auths[60]) ? 'center' : 'right' ?>">
                        <?php 
                            foreach($agent->countries_agents as $cs) :
                        ?>
                        <span class="label label-default"> <?= h($cs->country->name) ?></span>
                    <?php   endforeach  ; ?>
                    </td>
                    <?php endif; ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[60]) : ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/agents/edit/<?= $agent->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(count($agent->customers) == 0) : ?>
                        <a href="<?= ROOT_DIREC ?>/agents/delete/<?= $agent->id ?>" onclick="return confirm('Are you sure you would like to delete the agent <?= h($agent->name) ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
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
