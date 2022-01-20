<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="#" style="color:white"><span style="color:white">COPASSA</span></a>
                
                <ul class="nav navbar-top-links navbar-right">

                    <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <span class="fa fa-user" style="font-size: 28px;margin-top: -5px;margin-left: 1px;"></span>
                    </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="<?= ROOT_DIREC ?>/users/view/<?= $user_connected['id'] ?>"><span class="fa fa-user">&nbsp;</span> Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= ROOT_DIREC ?>/users/logout"><span class="fa fa-power-off">&nbsp;</span> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                    <?= $this->Form->create(null, array("url" => "/app/update_session_variables")) ?>
                    <select name="filter_country" style="margin-top: 16px;height: 31px!important;width: 187px;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;border:none!important">
                        <option value="">-- All --</option>
                        <?php foreach($filter_countries as $id => $name) : ?>
                            <option value="<?= $id ?>" <?= ($filter_country == $id) ? 'selected' : "" ?>><?= strtoupper($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input value="<?= $filterfrom  ?>" type="date" name="from" style="margin-top: 15px;height: 30px;width: 187px;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;">
                    <input value="<?= $filterto  ?>" type="date" name="to" style="height: 30px;width: 187px;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;">
                    <button class="btn btn-success" style="padding: 5px 12px!important;
    margin-top: -3px!important;"><span class="glyphicon glyphicon-ok" ></span></button>
                    <?= $this->Form->end() ?>
                </li>
                </ul>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-usertitle" style="margin:auto;width:100%">
                <div class="profile-usertitle-name text-center" style="margin-top:12px"><?= $user_connected['name'] ?></div>
                <div class="profile-usertitle-status text-center"><span class="indicator label-success"></span>Online</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>

        <ul class="nav menu" style="margin-top:0px">
            <li class="parent <?= ($this->request->getParam('action') == 'report' || $this->request->getParam('action') == 'alerts') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-4">
                <em class="fa fa-bars">&nbsp;</em> Reports <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-4">
                    <li><a class="" href="<?= ROOT_DIREC ?>/policies/report">
                        <span class="fa fa-arrow-right">&nbsp;</span> Policies
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/payments/report">
                        <span class="fa fa-arrow-right">&nbsp;</span> Payments
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/payments/renewals">
                        <span class="fa fa-arrow-right">&nbsp;</span> Renewals
                    </a></li>
                </ul>
            </li>

            <li class="<?= ($this->request->getParam('controller') == 'Companies') ? 'active' : '' ?>"><a href="<?= ROOT_DIREC ?>/companies"><em class="fa fa-bank">&nbsp;</em> Insurances</a></li>
            <li class="<?= ($this->request->getParam('controller') == 'Countries' && $this->request->getParam('action') == 'dashboard') ? 'active' : '' ?>"><a href="<?= ROOT_DIREC ?>/countries"><em class="fa fa-map">&nbsp;</em> Countries</a></li>

            <li class="parent <?= ( ($this->request->getParam('controller') == 'Customers' || $this->request->getParam('controller') == 'Policies') && $this->request->getParam('action') != 'dashboard' ) ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-111">
                <em class="fa fa-users">&nbsp;</em> Policy Holders <span data-toggle="collapse" href="#sub-item-111" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-111">
                    <li class="<?= ($this->request->getParam('controller') == 'Customers' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/customers">
                        <span class="fa fa-arrow-right">&nbsp;</span> Policy Holders
                    </a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Policies' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/policies">
                        <span class="fa fa-arrow-right">&nbsp;</span> Policies
                    </a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Policies' && $this->request->getParam('action') == 'update') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/policies/update">
                        <span class="fa fa-arrow-right">&nbsp;</span> Updates
                    </a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Payments') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/payments">
                        <span class="fa fa-arrow-right">&nbsp;</span> Payments
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ( ($this->request->getParam('controller') == 'Businesses' || $this->request->getParam('controller') == 'Groupings') ) ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-1111">
                <em class="fa fa-building">&nbsp;</em> Companies <span data-toggle="collapse" href="#sub-item-1111" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-1111">
                    <li class="<?= ($this->request->getParam('controller') == 'Businesses' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/businesses">
                        <span class="fa fa-arrow-right">&nbsp;</span> Companies
                    </a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Groupings' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/groupings">
                        <span class="fa fa-arrow-right">&nbsp;</span> Groups
                    </a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Employees' && $this->request->getParam('action') == 'update') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/employees">
                        <span class="fa fa-arrow-right">&nbsp;</span> Employees
                    </a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Families') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/families">
                        <span class="fa fa-arrow-right">&nbsp;</span> Families
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Users' || $this->request->getParam('controller') == 'Roles' || $this->request->getParam('controller') == 'Cards') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-2">
                <em class="fa fa-lock">&nbsp;</em> Settings <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-2">
                    <li class="<?= ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/users">
                        <span class="fa fa-arrow-right">&nbsp;</span> Users
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Roles') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/roles">
                        <span class="fa fa-arrow-right">&nbsp;</span> Roles
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Riders') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/riders">
                        <span class="fa fa-arrow-right">&nbsp;</span> Riders
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Logs') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/logs">
                        <span class="fa fa-arrow-right">&nbsp;</span> Activity
                    </a></li>
                </ul>
            </li>
            <li><a  href="<?= ROOT_DIREC ?>/users/logout" style="color:red"><em class="fa fa-power-off">&nbsp;</em> Log Out</a></li>
        </ul>

    </div><!--/.sidebar-->

<script type="text/javascript">
    $(document).ready(function(){
        $("li.parent").click(function(){
            var children = $(this).find(".children");
            if(children.hasClass("collapse")){
                children.removeClass("collapse");
            }else{
                children.addClass("collapse");
            }
        })
    })
</script>