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
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Maternity Reminders
            </div>
            <div class="panel-body articles-container">       
                <table class="table table-striped table-bordered">
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
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Birthdays
            </div>
            <div class="panel-body articles-container">       
                <table class="table table-striped table-bordered">
                <thead> 
                    <th class="text-left">Policy Holder</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Phone</th>
                </thead>
            <tbody> 
        <?php foreach($birthdays as $birthday) : ?>
            <tr>
                <td class="text-left"><?= $birthday->name ?></td>
                <td class="text-center"><?= $birthday->dob ?></td>
                <td class="text-center"><?= $birthday->home_phone ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Pending New Business
            </div>
            <div class="panel-body articles-container">       
<table class="table table-striped table-bordered">
                <thead> 
                    <th class="text-left">Name</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Option</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Dependants</th>
                    <th class="text-center">Last Contact Date</th>
                </thead>
            <tbody> 
        <?php foreach($pendings as $pending) : ?>
          <?php if($pending->country_id == $filter_country || empty($filter_country)) : ?>
            <tr>
                <td class="text-left"><?= $pending->name ?></td>
                <td class="text-center"><?= $pending->company->name ?></td>
                <td class="text-center"><?= $pending->option->name ?></td>
                <td class="text-center"><?= $pending->country->name ?></td>
                <td class="text-center"><?= $pending->dependants ?></td>
                <?php if(!empty($pending->last_contact_date)) : ?>
                <td class="text-center"><?= date("M d Y", strtotime($pending->last_contact_date)) ?></td> 
                <?php else : ?>
                    <td></td>
                <?php endif; ?>
            </tr>
          <?php endif; ?>
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