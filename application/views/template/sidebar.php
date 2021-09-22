<style type="text/css">
.new-mainmenu{
    float: left;
    width: 240px;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.new-mainmenu::-webkit-scrollbar {
  display: none;
}
.pcoded-inner-navbar {
    height: calc(100% - 80px);
}
</style>


<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar new-mainmenu" style="overflow-y: scroll;">
                <!-- <div class="pcoded-navigatio-lavel">Navigation</div> -->
                <ul class="pcoded-item pcoded-left-item">
                    <li class="<?= menu(1,["dashboard"])[0]; ?>">
                        <a href="<?= base_url('dashboard') ?>">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                </ul>
                <?php if($this->rights->check([1])){ ?>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="<?= menu(2,["send_app_notification"])[0]; ?>">
                            <a href="<?= base_url('other/send_app_notification') ?>">
                                <span class="pcoded-micon"><i class="fa fa-send"></i></span>
                                <span class="pcoded-mtext">Send App Notifications</span>
                            </a>
                        </li>
                    </ul>
                <?php } ?>
                <?php if($this->rights->check([3])){ ?>
                    <!-- <div class="pcoded-navigatio-lavel">Ussdpos Users</div> -->
                    <?php if($this->rights->check([3])){ ?>
                        <ul class="pcoded-item pcoded-left-item">
                            <li class="pcoded-hasmenu <?= menu(1,["agent"])[2]; ?>">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="fa fa-user-secret"></i></span>
                                    <span class="pcoded-mtext">Agents</span>
                                </a>   
                                <ul class="pcoded-submenu">
                                    <li class="<?= menu(2,["pending"],'agent')[0]; ?>">
                                        <a href="<?= base_url('agent/pending') ?>">
                                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                            <span class="pcoded-mtext">Pending</span>
                                        </a>
                                    </li>
                                    <li class="<?= menu(2,["processing"],'agent')[0]; ?>">
                                        <a href="<?= base_url('agent/processing') ?>">
                                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                            <span class="pcoded-mtext">Processing</span>
                                        </a>
                                    </li>
                                    <li class="<?= menu(2,["reuploaded"],'agent')[0]; ?>">
                                        <a href="<?= base_url('agent/reuploaded') ?>">
                                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                            <span class="pcoded-mtext">Re-Uploaded</span>
                                        </a>
                                    </li>
                                    <li class="<?= menu(2,["active"],'agent')[0]; ?>">
                                        <a href="<?= base_url('agent/active') ?>">
                                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                            <span class="pcoded-mtext">Active</span>
                                        </a>
                                    </li>
                                    <li class="<?= menu(2,["blocked"],'agent')[0]; ?>">
                                        <a href="<?= base_url('agent/blocked') ?>">
                                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                            <span class="pcoded-mtext">Reported / Blocked</span>
                                        </a>
                                    </li>
                                    <?php if(get_user()['user_type'] == '0'){ ?>
                                        <li class="<?= menu(2,["deleted"],'agent')[0]; ?>">
                                            <a href="<?= base_url('agent/deleted') ?>">
                                                <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                                <span class="pcoded-mtext">Deleted</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                <?php } ?>
                
                <?php if($this->rights->check([4])){ ?>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu <?= menu(1,["ussdpay"])[2]; ?>">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="fa fa-hashtag"></i></span>
                                <span class="pcoded-mtext">Ussd Payments</span>
                            </a>   
                            <ul class="pcoded-submenu">
                                <li class="<?= menu(2,["pending"],'ussdpay')[0]; ?>">
                                    <a href="<?= base_url('ussdpay/pending') ?>">
                                        <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                        <span class="pcoded-mtext">Pending</span>
                                    </a>
                                </li>
                                <li class="<?= menu(2,["success"],'ussdpay')[0]; ?>">
                                    <a href="<?= base_url('ussdpay/success') ?>">
                                        <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                        <span class="pcoded-mtext">Success</span>
                                    </a>
                                </li>
                                <li class="<?= menu(2,["failed"],'ussdpay')[0]; ?>">
                                    <a href="<?= base_url('ussdpay/failed') ?>">
                                        <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                        <span class="pcoded-mtext">Failed</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>

                <?php if($this->rights->check([5])){ ?>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu <?= menu(1,["transactions"])[2]; ?>">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                <span class="pcoded-mtext">Transactions</span>
                            </a>   
                            <ul class="pcoded-submenu">
                                <li class="<?= menu(2,["agent"],'transactions')[0]; ?>">
                                    <a href="<?= base_url('transactions/agent') ?>">
                                        <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                        <span class="pcoded-mtext">Agent</span>
                                    </a>
                                </li>
                                <li class="<?= menu(2,["ussd"],'transactions')[0]; ?>">
                                    <a href="<?= base_url('transactions/ussd') ?>">
                                        <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                        <span class="pcoded-mtext">UssdPos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>

                
                <?php if($this->rights->check([2])){ ?>
                    <!-- <div class="pcoded-navigatio-lavel">CMS</div> -->
                    <!-- <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu <?= menu(1,["pages"])[2]; ?>">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                                <span class="pcoded-mtext">Pages</span>
                            </a>   
                            <ul class="pcoded-submenu">
                                <?php $pages = $this->db->get('cms_pages')->result_array(); ?>
                                <?php foreach ($pages as $page) { ?>
                                    <li class="<?= menu(3,[$page['id']])[0]; ?>">
                                        <a href="<?= base_url('pages/page/').$page['id'] ?>">
                                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                                            <span class="pcoded-mtext"><?= $page['name'] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul> -->
                <?php } ?>  
                

                <?php if(get_user()['user_type'] == '0' || $this->rights->check([2])){ ?>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu <?= menu(1,["setting","commission","users","states","regbanks","banks","pages","products"])[2]; ?>">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                                <span class="pcoded-mtext">Admin Setups</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="pcoded-hasmenu <?= menu(1,["pages"])[2]; ?>">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-mtext">Pages</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <?php $pages = $this->db->get('cms_pages')->result_array(); ?>
                                        <?php foreach ($pages as $page) { ?>
                                            <li class="<?= menu(3,[$page['id']])[0]; ?>">
                                                <a href="<?= base_url('pages/page/').$page['id'] ?>">
                                                    <span class="pcoded-mtext"><?= $page['name'] ?></span>
                                                </a>
                                            </li>
                                        <?php } ?> 
                                    </ul>
                                </li>
                                <?php if(get_user()['user_type'] == '0'){ ?>
                                    <li class="pcoded-hasmenu <?= menu(1,["products"])[2]; ?>">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-mtext">Product Settings</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?= menu(2,["categories","edit_category"],"products")[0]; ?>">
                                                <a href="<?= base_url('products/categories') ?>">
                                                    <span class="pcoded-mtext">Categories</span>
                                                </a>
                                            </li>
                                            <li class="<?= menu(2,["list","add","edit"],"products")[0]; ?>">
                                                <a href="<?= base_url('products/list') ?>">
                                                    <span class="pcoded-mtext">Products</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu <?= menu(1,["states","regbanks","banks"])[2]; ?>">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-mtext">Master</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?= menu(2,["ussd","edit_ussd"],'banks')[0]; ?>">
                                                <a href="<?= base_url('banks/ussd') ?>">
                                                    <span class="pcoded-mtext">USSD Bank</span>
                                                </a>
                                            </li>
                                            <li class="<?= menu(2,["transfer","edit_transfer"],'banks')[0]; ?>">
                                                <a href="<?= base_url('banks/transfer') ?>">
                                                    <span class="pcoded-mtext">Transfer Bank</span>
                                                </a>
                                            </li>
                                            <li class="<?= menu(1,["regbanks"])[0]; ?>">
                                                <a href="<?= base_url('regbanks/banks') ?>">
                                                    <span class="pcoded-mtext">Reg. Banks</span>
                                                </a>
                                            </li>
                                            <li class="<?= menu(1,["states"])[0]; ?>">
                                                <a href="<?= base_url('states/list') ?>">
                                                    <span class="pcoded-mtext">States</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="<?= menu(1,["users"])[1]; ?>">
                                        <a href="<?= base_url('users') ?>">
                                            <span class="pcoded-mtext">Admin Users</span>
                                        </a>
                                    </li>
                                    <li class="<?= menu(1,["commission"])[1]; ?>">
                                        <a href="<?= base_url('commission') ?>">
                                            <span class="pcoded-mtext">Commission</span>
                                        </a>
                                    </li>
                                    <li class="<?= menu(1,["setting"])[1]; ?>">
                                        <a href="<?= base_url('setting') ?>">
                                            <span class="pcoded-mtext">Settings</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>  

                    <ul class="pcoded-item pcoded-left-item">
                        <li>
                            <a href="<?= base_url('login/logout') ?>">
                                <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                                <span class="pcoded-mtext">Logout</span>
                            </a>
                        </li>
                    </ul>
            </div>
        </nav>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">