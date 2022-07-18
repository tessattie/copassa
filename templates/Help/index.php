<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>Help Desk</li>
    </ol>
</div>

<div class="row">
    <div class="col-md-3">
        <ul class="list-group">
            <?php foreach($categories as $category) : ?>
              <li class=" <?= ($active == $category->id) ? 'active' : '' ?> list-group-item"><a href="<?= ROOT_DIREC ?>/help/index/<?= $category->id ?>" style="color:black"><?= $category->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="col-md-9">
        <div class="panel panel-default articles">
    <div class="panel-body articles-container" style="height:75vh;overflow-y:scroll">
        <?php   foreach($elements as $element) : ?>
        <h3 style="font-weight:500"><?= $element->title ?></h3>
        <h4 style="font-weight:400;color:grey;margin-top:-5px"><?= $element->subtitle ?></h4>
        <hr>

        <?php if(!empty($element->photo)) : ?>
            <div style="text-align:center;padding-bottom:20px" class="div_before_p">
            <?php echo $this->Html->image('help/'.$element->photo, ['style' => "width:70%"]); ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($element->video)) : ?>
            <div style="text-align:center;padding-bottom:20px" class="div_before_p">
                <video style="width:70%;border:1px solid #ddd" controls>
                    <source src = "<?= ROOT_DIREC ?>/webroot/img/help/<?= $element->video ?>" type="video/mp4">
                </video>
            </div>
        <?php endif; ?>
        <div style="padding-bottom:20px" class="div_before_p">
        <?= $element->text ?>
    <?php   endforeach; ?>
    </div>
    </div>
        
    </div>
    </div>
</div>


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

    .div_before_p p, .div_before_p{
        line-height: 2em!important;
        font-size: 16px;
        text-align: justify;
    }
    .active{
        background: #f2f2f2!important;
        border-color: #ddd!important;
    }
</style>