<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
$rates = array(1 => "HTG", 2 => "USD");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Edit Payment</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<?= $this->Form->create($payment, array('id' => "customerform", 'enctype' => 'multipart/form-data')) ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Payment
        </div>
        <div class="panel-body articles-container">
            <div class="row">   
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>    
                                <th class="text-center">Policy Number</th>
                                <th class="text-center">Policy Holder</th>
                                <th class="text-center">Mode</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Fees</th>
                                <th class="text-center">Effective Date</th>
                                <th class="text-center">Paid Until</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><?= $payment->policy->policy_number ?></td>
                                <td class="text-center"><?= $payment->customer->name ?></td>
                                <td class="text-center"><?= $modes[$payment->policy->mode] ?></td>
                                <td class="text-center"><?= number_format($payment->policy->premium,2,".",",") ?> USD</td>
                                <td class="text-center"><?= number_format($payment->policy->fee,2,".",",") ?> USD</td>
                                <td class="text-center"><?= date("M d Y", strtotime($payment->policy->effective_date)) ?></td>
                                <td class="text-center"><?= date("M d Y", strtotime($payment->policy->paid_until)) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  
            <div class="row" style="padding-top:20px;padding-bottom:30px;margin-bottom:20px;margin-top:10px">
                <div class="col-md-4">
                    <?= $this->Form->control('amount', array('class' => 'form-control total_amount', "placeholder" => "Amount", "label" => "Amount", "style" => "margin-left:4px")); ?>
                </div>
                <div class="col-md-4">
                    <?= $this->Form->control('rate_id', array('class' => 'form-control', "empty" => "-- Currency --", "options" => $rates, "label" => 'Currency', "style" => "margin-left:4px;height:46px", "required" => true, 'value' => 2)); ?>
                </div>
                <div class="col-md-4">
                    <?= $this->Form->control('daily_rate', array('type' => 'hidden')); ?>
                </div>
            </div>   
            <div class="row">
               <div class="col-md-6">
                    <?= $this->Form->control('memo', array('class' => 'form-control', "placeholder" => "Memo", "label" => 'Memo', "style" => "margin-left:4px")); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('status', array('class' => 'form-control', "label" => 'Status', 'options' => array(0=> "No", 1=> 'Yes'))); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('confirmed', array('class' => 'form-control', 'options' => array(0=> "No", 1=> 'Yes'), "label" => 'Confirmed')); ?>
                </div>
            </div>
                <hr>    
            <div class="row" style="margin-top:10px">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputFile">Photo</label>
                    <input type="file" id="exampleInputFile" name="certificate">
                    <p class="help-block">Upload payment photo here.</p>
                  </div>
                </div>
                <div class="col-md-6">
                      <?php echo $this->Html->image('payments/'.$payment->path_to_photo, array('width' => '500px','alt'=>'aswq', 'style' => "float:right")); ?>
                </div>
            </div> 
            
            <?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style" => "height: 46px;border-radius: 0px;margin-top:20px;margin-right:15px;float:right")) ?>
            
        </div>
    </div>
</div><!--End .articles-->
<?= $this->Form->end() ?>
<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering" : false,
        scrollY: "300px",
        scrollCollapse: true,
        paging: false,
        "searching": false
    });
});
</script>

<style>
    .table-bordered>tbody>tr>td{
        font-size:12px!important;
        padding:8px!important;
    }
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
    .dataTables_info{
        display:none;
    }
</style>
