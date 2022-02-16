<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Employees</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Company Census
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Membership</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Premium</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Residence</th>
                    <th class="text-right">Relationship</th>
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
                    <td><?= $employee->membership_number ?></td>
                    <td class="text-center"><?= $family->last_name ?></td>
                    <td class="text-center"><?= $family->first_name ?></td>
                    <td class="text-center"><?= date('m/d/Y', strtotime($dob)) ?></td>
                    <td class="text-center"><?= $age ?></td>
                    <td class="text-center"><?= number_format($family->premium, 2, ".", ",") ?></td>
                    <td class="text-center"><?= $genders[$family->gender] ?></td>
                    <td class="text-center"><?= $family->country ?></td>
                    <td class="text-right"><?= $relationships[$family->relationship ] ?></td>
                </tr>
                
            <?php endforeach; ?>
            
            <?php endforeach; ?>
            </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

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
