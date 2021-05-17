<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Rôles</li>
    </ol>
</div>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Rôles
        </div>
    <div class="panel-body articles-container">

        <?php foreach($roles as $role) : ?>
            <?php if($role->id == 5)  : ?>
                <div class="article">
            <?php else : ?>
                <div class="article border-bottom">
            <?php endif; ?>
            
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <h4><a href="#"><?= $role->name ?></a></h4>
                            <p><?= $role->description ?></p>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
            <!--End .article-->
            
        
    </div>
</div><!--End .articles-->
</div>
