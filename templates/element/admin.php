<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="#" style="color:white"><span style="color:white"><?= $tenant->company ?></span> <small style="font-size: 8px;
    font-style: italic;color:orange;font-weight:bold">( Member of ARS )</small></a>
                
                <ul class="nav navbar-top-links navbar-right">

                    <li class="dropdown" style="float:right"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
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
                       
                    <li class="dropdown" style="float:right;margin-right:-5px"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <span class="fa fa-filter" style="font-size: 28px;margin-top: -5px;margin-left: 1px;"></span>
                    </a>
                    
                        <ul class="dropdown-menu dropdown-messages">
                             <?= $this->Form->create(null, array("url" => "/app/update_session_variables")) ?>
                            <li style="padding-right:10px;padding-left:10px;padding-top:10px"><strong>Filter by Date</strong></li>
                            <li class="divider"></li>
                            <li style="padding-right:10px;padding-left:10px">
                                <input value="<?= $filterfrom  ?>" type="date" name="from" style="border: 1px solid #ddd;height: 39px;width: 100%;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;">
                            </li>
                            <li class="divider"></li>
                            <li style="padding-right:10px;padding-left:10px">
                                <input value="<?= $filterto  ?>" type="date" name="to" style="border: 1px solid #ddd;height: 39px;width: 100%;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;">
                            </li>
                            <li class="divider"></li>
                            <li style="padding-right:10px;padding-left:10px">
                                <button class="btn btn-success" style="padding: 9px 12px!important;"><span class="glyphicon glyphicon-ok" ></span></button>
                            </li>
                            <?= $this->Form->end() ?>
                        </ul>
                    </li>
                    
                </ul>


                

   
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar" style="text-align:center">
            <div class="profile-usertitle" style="margin:auto;width:100%">
                <div class="profile-usertitle-name text-center" style="margin-top:12px;margin-bottom:10px"><?= $user_connected['name'] ?></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>

        <ul class="nav menu" style="margin-top:0px">
            <li class="<?= ($this->request->getParam('controller') == 'Policies' && ($this->request->getParam('action') == 'dashboard')) ? 'active' : '' ?>"><a href="<?= ROOT_DIREC ?>/policies/dashboard"><em class="fa fa-dashboard">&nbsp;</em> Reminders</a></li>

            <li class="parent <?= ( ($this->request->getParam('controller') == 'Prenewals' || $this->request->getParam('controller') == 'Newborns' || $this->request->getParam('controller') == 'Customers' || $this->request->getParam('controller') == 'Pendings' || $this->request->getParam('controller') == 'Policies') && $this->request->getParam('action') != 'dashboard' && $this->request->getParam('action') != 'report' ) ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-111">
                <em class="fa fa-users">&nbsp;</em> Policies <span data-toggle="collapse" href="#sub-item-111" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-111">
                    <li><a class="" href="<?= ROOT_DIREC ?>/customers">
                        <span class="fa fa-arrow-right">&nbsp;</span> Policy Holders
                    </a></li>

                    <li><a class="" href="<?= ROOT_DIREC ?>/policies">
                        <span class="fa fa-arrow-right">&nbsp;</span> Policies
                    </a></li>

                    <li><a class="" href="<?= ROOT_DIREC ?>/pendings">
                        <span class="fa fa-arrow-right">&nbsp;</span> New Business
                    </a></li>

                    <li><a class="" href="<?= ROOT_DIREC ?>/newborns">
                        <span class="fa fa-arrow-right">&nbsp;</span> Maternity
                    </a></li>

                    <li><a class=""  href="<?= ROOT_DIREC ?>/prenewals">
                        <span class="fa fa-arrow-right">&nbsp;</span> Renewals
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ( ($this->request->getParam('controller') == 'Renewals' || $this->request->getParam('controller') == 'Businesses' || $this->request->getParam('controller') == 'Groupings' || $this->request->getParam('controller') == 'Employees' || $this->request->getParam('controller') == 'Families') && $this->request->getParam('action') != 'report') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-1111">
                <em class="fa fa-building">&nbsp;</em> Corporate <span data-toggle="collapse" href="#sub-item-1111" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-1111">
                    <li class="<?= ($this->request->getParam('controller') == 'Businesses' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/businesses">
                        <span class="fa fa-arrow-right">&nbsp;</span> Corporate
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
                    <li class="<?= ($this->request->getParam('controller') == 'Renewals') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/renewals">
                        <span class="fa fa-arrow-right">&nbsp;</span> Renewals
                    </a></li>
                </ul>
            </li>

            <li class="<?= ($this->request->getParam('controller') == 'Companies') ? 'active' : '' ?>"><a href="<?= ROOT_DIREC ?>/companies"><em class="fa fa-bank">&nbsp;</em> Insurance CO</a></li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Countries' || $this->request->getParam('controller') == 'Agents' ) ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-24">
                <em class="fa fa-globe">&nbsp;</em> Network <span data-toggle="collapse" href="#sub-item-24" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-24">
                    <li class="<?= ($this->request->getParam('controller') == 'Countries' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/countries">
                        <span class="fa fa-arrow-right">&nbsp;</span> Countries
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Agents') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/agents">
                        <span class="fa fa-arrow-right">&nbsp;</span> Agents
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Claims' || $this->request->getParam('controller') == 'Types' || $this->request->getParam('controller') == 'ClaimsTypes') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-24">
                <em class="fa fa-calendar">&nbsp;</em> Claims <span data-toggle="collapse" href="#sub-item-24" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-24">
                    <li class="<?= ($this->request->getParam('controller') == 'Claims' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/claims">
                        <span class="fa fa-arrow-right">&nbsp;</span> Claims
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Types') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/types">
                        <span class="fa fa-arrow-right">&nbsp;</span> Settings
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('action') == 'report' || $this->request->getParam('action') == 'alerts') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-4">
                <em class="fa fa-bars">&nbsp;</em> Reports <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-4">
                    <li><a class="" href="<?= ROOT_DIREC ?>/policies/listing">
                        <span class="fa fa-arrow-right">&nbsp;</span> Policies
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/policies/report">
                        <span class="fa fa-arrow-right">&nbsp;</span> Renewals
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/payments/report">
                        <span class="fa fa-arrow-right">&nbsp;</span> Payments
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/employees/report">
                        <span class="fa fa-arrow-right">&nbsp;</span> Coorporate Groups
                    </a></li>
                </ul>
            </li>
            

            <li class="<?= ($this->request->getParam('controller') == 'Folders') ? 'active' : '' ?>"><a href="<?= ROOT_DIREC ?>/folders/show"><em class="fa fa-folder">&nbsp;</em> Resources</a></li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Riders' ||$this->request->getParam('controller') == 'Authorizations' || $this->request->getParam('controller') == 'Users' || $this->request->getParam('controller') == 'Roles' || $this->request->getParam('controller') == 'Cards') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-2">
                <em class="fa fa-lock">&nbsp;</em> Settings <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-2">
                    <li class="<?= ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'index') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/users">
                        <span class="fa fa-arrow-right">&nbsp;</span> Users
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Authorizations') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/authorizations">
                        <span class="fa fa-arrow-right">&nbsp;</span> Authorizations
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Riders') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/riders">
                        <span class="fa fa-arrow-right">&nbsp;</span> Riders
                    </a></li>
                    
               <!--      <li class="<?= ($this->request->getParam('controller') == 'Logs') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/logs">
                        <span class="fa fa-arrow-right">&nbsp;</span> Activity
                    </a></li> -->
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



<style type="text/css">
    @media only screen and (max-width: 600px) {
      .panel-heading{
        font-weight: bold;
        font-size: 18px;
      }

      .table-responsive{
        border-color: white;
      }

      .panel-heading{
        font-size:15px;
      }

      .btn{
        height: auto!important;
      }
    }
</style>