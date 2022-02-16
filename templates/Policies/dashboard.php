<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>
            Dashboard
        </li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid">   
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default articles" style="height:400px;overflow-y:scroll">
            <div class="panel-heading">
                Maternity Reminders
            </div>
            <div class="panel-body articles-container">       
                <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Policy Number</th>
                    <th class="text-center">Policy Holder</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Due Date</th>
                </thead>
            <tbody> 
        <?php foreach($newborns as $newborn) : ?>
            <tr>
                <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $newborn->policy->id ?>"><?= $newborn->policy->policy_number ?></a></td>
                <td class="text-center"><?= $newborn->policy->customer->name ?></td>
                <td class="text-center"><?= $newborn->policy->company->name . " / ".  $newborn->policy->option->name ?></td>
                <td class="text-center"><?= date("M d Y", strtotime($newborn->due_date)) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
    <div class="col-md-6">
        <div class="panel panel-default articles" style="height:400px;overflow-y:scroll">
            <div class="panel-heading">
                Pending Business
            </div>
            <div class="panel-body articles-container">       
<table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Number</th>
                    <th class="text-center">Holder</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Premium</th>
                </thead>
            <tbody> 
        <?php foreach($policies as $policy) : ?>
            <tr>
                <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                <td class="text-center"><?= $policy->customer->name ?></td>
                <td class="text-center"><?= $policy->customer->country->name ?></td>
                <td class="text-center"><?= $policy->company->name . " / ".  $policy->option->name ?></td>
                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default articles" style="height:400px;overflow-y:scroll">
            <div class="panel-heading">
                Birthdays
            </div>
            <div class="panel-body articles-container">       
                <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Policy Holder</th>
                    <th class="text-center">DOB</th>
                    <th class="text-right">Phone</th>
                </thead>
            <tbody> 
        <?php foreach($birthdays as $birthday) : ?>
            <tr>
                <td class="text-left"><?= $birthday->name ?></td>
                <td class="text-center"><?= $birthday->dob ?></td>
                <td class="text-right"><?= $birthday->home_phone ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
 
</div> 
</div><!--End .articles-->


<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({

    } );
} );</script>