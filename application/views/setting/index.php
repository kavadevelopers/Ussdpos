<div class="page-header">
    <div class="row align-items-end">
        <div class="col-md-12">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4><?= $_title ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="card">
        <form method="post" action="<?= base_url('setting/save') ?>" enctype="multipart/form-data">
            <div class="card-block">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Company Name <span class="-req">*</span></label>
                            <input name="company" type="text" class="form-control" value="<?= set_value('company',get_setting()['name']); ?>" >
                            <?= form_error('company') ?>
                        </div>
                    </div>

                    

                    

                    
                    
                </div>
            </div>
            <!-- <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Comission Settings</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>USSD Commmission<span class="-req">*</span></label>
                            <input name="com_ussd" type="text" class="form-control decimal-num" value="<?= set_value('com_ussd',get_setting()['com_ussd']); ?>" >
                            <?= form_error('com_ussd') ?>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Firebase Settings</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Firebase Server Key <span class="-req">*</span></label>
                            <input name="fserverkey" type="text" class="form-control" value="<?= set_value('fserverkey',get_setting()['fserverkey']); ?>" >
                            <?= form_error('fserverkey') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Flutterwave Settings</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>FlutterWave Public Key<span class="-req">*</span></label>
                            <input name="flutter_public" type="text" class="form-control" value="<?= set_value('flutter_public',get_setting()['flutter_public']); ?>" >
                            <?= form_error('flutter_public') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>FlutterWave Secret Key<span class="-req">*</span></label>
                            <input name="flutterapi" type="text" class="form-control" value="<?= set_value('flutterapi',get_setting()['flutterapi']); ?>" >
                            <?= form_error('flutterapi') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>FlutterWave Encryption Key<span class="-req">*</span></label>
                            <input name="flutter_enc_key" type="text" class="form-control" value="<?= set_value('flutter_enc_key',get_setting()['flutter_enc_key']); ?>" >
                            <?= form_error('flutter_enc_key') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">SMS Settings</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>BulkSMS Nigeria Key <span class="-req">*</span></label>
                            <input name="bulksmskey" type="text" class="form-control" value="<?= set_value('bulksmskey',get_setting()['bulksmskey']); ?>" >
                            <?= form_error('bulksmskey') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>BulkSMS Nigeria Sender ID <span class="-req">*</span></label>
                            <input name="bulksmssenderid" type="text" class="form-control" value="<?= set_value('bulksmssenderid',get_setting()['bulksmssenderid']); ?>" >
                            <?= form_error('bulksmssenderid') ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nigeria Bulksms User <span class="-req">*</span></label>
                            <input name="nsmsuser" type="text" class="form-control" value="<?= set_value('nsmsuser',get_setting()['nsmsuser']); ?>" >
                            <?= form_error('nsmsuser') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nigeria Bulksms Pass <span class="-req">*</span></label>
                            <input name="nsmspass" type="text" class="form-control" value="<?= set_value('nsmspass',get_setting()['nsmspass']); ?>" >
                            <?= form_error('nsmspass') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nigeria Bulksms Sender ID <span class="-req">*</span></label>
                            <input name="nsmssendid" type="text" class="form-control" value="<?= set_value('nsmssendid',get_setting()['nsmssendid']); ?>" >
                            <?= form_error('nsmssendid') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Application Settings</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Android App Link<span class="-req">*</span></label>
                            <input name="android_app_link" type="text" class="form-control" placeholder="" value="<?= set_value('android_app_link',get_setting()['android_app_link']); ?>" >
                            <?= form_error('android_app_link') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>iOS App Link<span class="-req">*</span></label>
                            <input name="ios_app_link" type="text" class="form-control" placeholder="" value="<?= set_value('ios_app_link',get_setting()['ios_app_link']); ?>" >
                            <?= form_error('ios_app_link') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Android App Version <span class="-req">*</span></label>
                            <input name="android_ver" type="text" class="form-control" placeholder="" value="<?= set_value('android_ver',get_setting()['android_ver']); ?>" >
                            <?= form_error('android_ver') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>iOS App Version <span class="-req">*</span></label>
                            <input name="ios_ver" type="text" class="form-control" placeholder="" value="<?= set_value('ios_ver',get_setting()['ios_ver']); ?>" >
                            <?= form_error('ios_ver') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Email SMTP Settings</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SMTP Host <span class="-req">*</span></label>
                            <input name="mail_host" type="text" class="form-control" placeholder="" value="<?= set_value('mail_host',get_setting()['mail_host']); ?>" >
                            <?= form_error('mail_host') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SMTP Username <span class="-req">*</span></label>
                            <input name="mail_username" type="text" class="form-control" placeholder="" value="<?= set_value('mail_username',get_setting()['mail_username']); ?>" >
                            <?= form_error('mail_username') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SMTP Password <span class="-req">*</span></label>
                            <input name="mail_pass" type="text" class="form-control" placeholder="" value="<?= set_value('mail_pass',get_setting()['mail_pass']); ?>" >
                            <?= form_error('mail_pass') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SMTP Port <span class="-req">*</span></label>
                            <input name="mail_port" type="text" class="form-control" placeholder="" value="<?= set_value('mail_port',get_setting()['mail_port']); ?>" >
                            <?= form_error('mail_port') ?>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="card-footer text-right">
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

<style type="text/css">
    
</style>