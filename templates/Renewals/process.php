<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Renewals</li>
        <li class="active">Process</li>
        <li class="active"><?= "[ " . $renewal->business->name . " - " . $renewal->renewal_number . " ]" ?></li>
    </ol>
</div>
<?= $this->Form->create() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Process Renewal
        </div>
    <div class="panel-body articles-container">
        Please check employees and family members that should be added to this renewal... <br><br>
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Premium</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Residence</th>
                    <th class="text-center">Relationship</th>
                    <th></th>
                </thead>
            <tbody> 
            <?php $i=1; $real_total = 0; foreach($employees as $employee) : ?>
            <?php if($i % 2 == 0) : ?>
                <?php $style= 'style="background:#f2f2f2!important"'; ?>
            <?php else : ?>
                <?php $style="" ?>
            <?php endif; ?>
            <?php $i++; ?>
                <?php  foreach($employee->families as $family) : ?>
                    <?php 
                    $age = "N/A";
                        if(!empty($family->dob)){
                            $dob = $family->dob->year."-".$family->dob->month."-".$family->dob->day;
                            $today = date("Y-m-d");
                            $diff = date_diff(date_create($dob), date_create($today));
                            $age = $diff->format('%y');
                        }
                    ?>
                <tr <?= $style ?>>
                    <td><?= h($employee->membership_number) ?></td>
                    <td class="text-center"><?= h($family->last_name) ?></td>
                    <td class="text-center"><?= h($family->first_name) ?></td>
                    <td class="text-center"><?= h(date('m/d/Y', strtotime($dob))) ?></td>
                    <td class="text-center"><?= h($age) ?></td>
                    <td class="text-center"><?= h(number_format($family->premium, 2, ".", ",")) ?></td>
                    <td class="text-center"><?= h($genders[$family->gender]) ?></td>
                    <td class="text-center"><?= h($family->country) ?></td>
                    <td class="text-center"><?= h($relationships[$family->relationship ]) ?></td>
                    <td class="text-right"><input type="checkbox" name="family_id[]" value="<?= $family->id ?>" checked></td>
                </tr>
                
            <?php endforeach; ?>
            
            <?php endforeach; ?>
            </tbody>
        </table></div>
            <!--End .article-->
        </div>
        <button type = "submit" class="btn btn-success" style="float:right;margin-top:10px">Save</button>
    </div>
</div><!--End .articles-->
<?= $this->Form->end() ?>
<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        'paging': false,
        'ordering' : false
    });
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

<style type="text/css">
    @media only screen and (max-width: 600px) {
      
    }
</style>
