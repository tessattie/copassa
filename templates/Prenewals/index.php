<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
     */
    $rates = array(1=>"HTG", 2=>"USD");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active"><a href="<?= ROOT_DIREC ?>/prenewals">Renewals</a></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Policies
        </div>
    <div class="panel-body articles-container">
            <table class="datatable">
                <thead>
                    <tr><th>Policy</th></tr>
                </thead>
                <tbody>
                    <?php foreach($policies as $pp) : ?>
                        <tr>
                            <th><a href="<?= ROOT_DIREC ?>/prenewals/index/<?= $pp->id ?>"><?= $pp->policy_number . " - " . $pp->customer->name . " - " . $company_types[$pp->company->type] . " - " . $modes[$pp->mode] ?></a></th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Renewals <?= (!empty($policy_id)) ? " :  ".$policy->policy_number." - ".$policy->customer->name : "" ?>
        </div>
    <div class="panel-body articles-container" style="height:550px;overflow-y:scroll">
        <?php if(!empty($policy_id)) : ?>
        <small><strong>Effective Date : <?= date('F d Y', strtotime($policy->effective_date)); ?></strong></small><br> 
        <small><strong>Mode : <?= $modes[$policy->mode]; ?></strong></small>
        <hr>
    <?php endif; ?>
    <table class="table datatable2 table-striped">
        <thead>
            <tr>
                <th>Renewal Date</th>
                <th>Policy</th>
                <th class="text-center">Premium</th>
                <th class="text-center">Fee</th>
                <th class="text-center">Status</th>
                <th class="text-center">Policy Status</th>
                <th class="text-center">Paid on</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($renewals)) : ?>
                <?php foreach($renewals as $renewal) : ?>
                    <tr>
                        <td><?= date('F d Y', strtotime($renewal->renewal_date)); ?></td>
                        <td><?= $renewal->policy->customer->name . ' - ' . $renewal->policy->policy_number ?></td>
                        <td class="text-center"><?= number_format($renewal->premium, 2, ".", ",") ?></td>
                        <td class="text-center"><?= number_format($renewal->fee, 2, ".", ",") ?></td>
                        <?php if($renewal->status == 1) : ?>
                            <td class="text-center"><span class="label label-info">Upcomming</span></td>
                        <?php elseif($renewal->status == 3) : ?>
                            <td class="text-center"><span class="label label-warning">Canceled</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-success">Paid</span></td>
                        <?php endif; ?>

                        <?php if($renewal->policy_status == 1) : ?>
                            <td class="text-center"><span class="label label-success">Active</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-danger">Canceled</span></td>
                        <?php endif; ?>
                        <?php if(!empty($renewal->payment_date)) : ?>
                        <td class="text-center"><?= date('F d Y', strtotime($renewal->payment_date)); ?></td>
                        <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                        <td class="text-right">
                            <a href="<?= ROOT_DIREC ?>/prenewals/edit/<?= $renewal->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
            <!--End .article-->
        </div>
    </div>
    </div>
</div>
    
</div><!--End .articles-->

<?php if(!empty($policy_id)) : ?>
<div class="modal fade" id="generaterenewals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Renewals</h5>
      </div>
      <?= $this->Form->create(null, array("url" => "/policies/generaterenewals")) ?>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->control('year', array('class' => 'form-control', "label" => "Year", "empty" => "-- Choose --", "options" => array(( date("Y") - 1) => (date("Y") - 1) ,date("Y") => date("Y"),( date("Y") + 1) => (date("Y") +1),( date("Y") + 2) => (date("Y") +2) ))); ?>
                <?= $this->Form->control('policy_id', array('type' => 'hidden', 'value' => $policy->id)); ?> 
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium", "value" => $policy->premium)); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php endif; ?>


<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
        "language": {
            "search": "",
            "searchPlaceholder": "Search"
        }
    });


    $('.datatable2').DataTable({
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
        "language": {
            "search": "",
            "searchPlaceholder": "Search"
        }
    });
} );</script>

<style type="text/css">
    #DataTables_Table_0_filter, #DataTables_Table_0_filter label, #DataTables_Table_0_filter input{
        width:100%;
        margin-right:9px;
    }
    #DataTables_Table_0_filter input{
        border: 1px solid #ddd;
    padding: 10px;
    }
    a:hover{
        font-weight:bold;
    }
    .boldcustomer{
        font-weight:bold;
        background:#f2f2f2!important;
    }
</style>
