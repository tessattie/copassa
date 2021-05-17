<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Log[]|\Cake\Collection\CollectionInterface $logs
 */
$types = array(1 => "ADD", 2 => "EDIT", 3 => "LIST", 4 => "LOGIN", 5 => "RECEIPTS");
$status = array(0 => "error", 1 => 'success');
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
            System Activity
        </div>
    <div class="panel-body articles-container">
        <div class="row">
            <?= $this->Form->create(); ?>
            <div class="col-md-3">
                <?= 
                $this->Form->control('status', array("class" => 'form-control', "empty" => '-- ALL --', 'options' => $status));
                ?>
            </div>
            <div class="col-md-3">
                <?= 
                $this->Form->control('user_id', array("class" => 'form-control', "empty" => '-- ALL --', 'options' => $users));
                ?>
            </div>
            <div class="col-md-3">
                <?= 
                    $this->Form->control('type', array("class" => 'form-control', "empty" => '-- ALL --', 'options' => $types));
                ?>
            </div>
            <div class="col-md-1">
                <?= $this->Form->button("Filter", array("class" => "btn btn-success", "style" => "height:45px;margin-top:25px")) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
        <hr>
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Code</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Message</th>
                    <th class="text-right">Created at</th>
                </thead>
            <tbody> 
        <?php foreach($logs as $log) : ?>
                <tr>
                    <td><?= $log->code ?></td>

                    <?php if($log->type == 1) : ?>
                        <td class="text-center"><span class="label label-warning"><?= $types[$log->type] ?></span></td>
                    <?php elseif($log->type == 2) : ?>
                        <td class="text-center"><span class="label label-info"><?= $types[$log->type] ?></span></td>
                    <?php elseif($log->type == 3) : ?>
                        <td class="text-center"><span class="label label-success"><?= $types[$log->type] ?></span></td>
                    <?php elseif($log->type == 4) : ?>
                        <td class="text-center"><span class="label label-primary"><?= $types[$log->type] ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger"><?= $types[$log->type] ?></span></td>
                    <?php endif; ?>

                    <?php if($log->status == 1) : ?>
                        <td class="text-center"><span class="label label-success"><?= $status[$log->status] ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger"><?= $status[$log->status] ?></span></td>
                    <?php endif; ?>

                    <?php if(!empty($log->user_id)) : ?>
                        <td class="text-center"><?= $log->user->name ?></td>
                    <?php else : ?>
                        <td class="text-center">-</td>
                    <?php endif; ?>
                    
                    

                    <td class="text-center"><?= $log->comment ?></td>

                    <td class="text-right"><?= date("M d Y", strtotime($log->created)); ?></td>

                    
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
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
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