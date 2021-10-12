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
        <form method="post" action="<?= base_url('common/save_delivery') ?>" enctype="multipart/form-data">
            <div class="card-block">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>GIG Charge <span class="-req">*</span></label>
                            <input name="gig" type="text" class="form-control decimal-num" value="<?= set_value('gig',$charge['gig']); ?>" required>
                            <?= form_error('gig') ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>GIG Charge for CASH <span class="-req">*</span></label>
                            <input name="gigcash" type="text" class="form-control decimal-num" value="<?= set_value('gigcash',$charge['gigcash']); ?>" required>
                            <?= form_error('gigcash') ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Localbus Charge <span class="-req">*</span></label>
                            <input name="bus" type="text" class="form-control decimal-num" value="<?= set_value('bus',$charge['bus']); ?>" required>
                            <?= form_error('bus') ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Localbus Charge for CASH <span class="-req">*</span></label>
                            <input name="buscash" type="text" class="form-control decimal-num" value="<?= set_value('buscash',$charge['buscash']); ?>" required>
                            <?= form_error('buscash') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Per Product Charge <span class="-req">*</span></label>
                            <input name="per" type="text" class="form-control decimal-num" value="<?= set_value('per',$charge['per']); ?>" required>
                            <?= form_error('per') ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Per Product Charge for CASH <span class="-req">*</span></label>
                            <input name="percash" type="text" class="form-control decimal-num" value="<?= set_value('percash',$charge['percash']); ?>" required>
                            <?= form_error('percash') ?>
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