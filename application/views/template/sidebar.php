<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="pcoded-navigatio-lavel">Navigation</div>
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
                
                <ul class="pcoded-item pcoded-left-item">
                    <li>
                        <a href="<?= base_url('login/logout') ?>">
                            <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                            <span class="pcoded-mtext">Logout</span>
                        </a>
                    </li>
                </ul>

                
                <?php if($this->rights->check([2])){ ?>
                    <div class="pcoded-navigatio-lavel">CMS</div>
                    <ul class="pcoded-item pcoded-left-item">
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
                    </ul>
                <?php } ?>
                <?php if(get_user()['user_type'] == '0'){ ?>
                    <div class="pcoded-navigatio-lavel">Super Admin Access</div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="<?= menu(1,["users"])[0]; ?>">
                            <a href="<?= base_url('users') ?>">
                                <span class="pcoded-micon"><i class="fa fa-user-md"></i></span>
                                <span class="pcoded-mtext">Admin Users</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="<?= menu(1,["setting"])[0]; ?>">
                            <a href="<?= base_url('setting') ?>">
                                <span class="pcoded-micon"><i class="fa fa-gear fa-spin"></i></span>
                                <span class="pcoded-mtext">Setting</span>
                            </a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </nav>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">