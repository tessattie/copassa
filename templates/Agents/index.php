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
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/agents/add">New</a>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Countries</th>                  
                    <th class="text-center"></th>
                </thead>
            <tbody> 
            <?php foreach($agents as $agent) : ?>
                <?php if($agent->country_id == $filter_country || empty($filter_country)) : ?>
                <tr>
                    <td><?= $agent->name ?></td>
                    <td class="text-center">
                        <?php 
                            foreach($agent->countries_agents as $cs) :
                        ?>
                        <span class="label label-default"> <?= $cs->country->name ?></span>
                    <?php   endforeach  ; ?>
                    </td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/agents/edit/<?= $agent->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/agents/delete/<?= $agent->id ?>" onclick="return confirm('Are you sure you would like to delete the agent <?= $agent->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
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
