<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Imports</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Imports
        </div>
        <div class="panel-body articles-container">       
            <table class="table table-striped">
                <thead>
                    <th>Template</th>
                    <th class="text-center">Download Template</th>
                    <th class="text-right">Upload Data</th>
                </thead>
                <tbody>
                    <td style="vertical-align:middle">Individual Policy Holders & Policies Data</td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/customers/generate" class="btn btn-info"><span class="fa fa-download"></span></a></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/importdata" class="btn btn-warning"><span class="fa fa-arrow-up"></span></a></td>
                </tbody>
            </table> 
        </div>
    </div>
</div><!--End .articles-->


