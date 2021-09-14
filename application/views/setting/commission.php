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
<?php $commissionSet = $this->db->get_where('set_commission',['id' => '1'])->row_object(); ?>
<div class="page-body">
    <div class="card">
        <form method="post" action="<?= base_url('commission/save') ?>" enctype="multipart/form-data">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">USSD Comission</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Commission Type <span class="-req">*</span></label>
                            <div class="radio-togless-field text-center">
                                <label>
                                    <input type="radio" name="ussd_type" value="0" <?= $commissionSet->ussd_type == 0?'checked':'' ?> />
                                    <span>Percentage</span>
                                </label>
                                <label>
                                    <input type="radio" name="ussd_type" value="1" <?= $commissionSet->ussd_type == 1?'checked':'' ?>/>
                                    <span>Fixed</span>
                                </label> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>In Percentage (%)<span class="-req">*</span></label>
                            <input name="ussd_per" type="text" class="form-control decimal-num" value="<?= set_value('ussd_per',$commissionSet->ussd_per); ?>" required>
                            <?= form_error('ussd_per') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fixed (amount)<span class="-req">*</span></label>
                            <input name="ussd_fix" type="text" class="form-control decimal-num" value="<?= set_value('ussd_fix',$commissionSet->ussd_fix); ?>" required>
                            <?= form_error('ussd_fix') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Flutterwave Commission Type <span class="-req">*</span></label>
                            <div class="radio-togless-field text-center">
                                <label>
                                    <input type="radio" name="fussd_type" value="0" <?= $commissionSet->fussd_type == 0?'checked':'' ?> />
                                    <span>Percentage</span>
                                </label>
                                <label>
                                    <input type="radio" name="fussd_type" value="1" <?= $commissionSet->fussd_type == 1?'checked':'' ?>/>
                                    <span>Fixed</span>
                                </label> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Flutterwave In Percentage (%)<span class="-req">*</span></label>
                            <input name="fussd_per" type="text" class="form-control decimal-num" value="<?= set_value('fussd_per',$commissionSet->fussd_per); ?>" required>
                            <?= form_error('fussd_per') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Flutterwave Fixed (amount)<span class="-req">*</span></label>
                            <input name="fussd_fix" type="text" class="form-control decimal-num" value="<?= set_value('fussd_fix',$commissionSet->fussd_fix); ?>" required>
                            <?= form_error('fussd_fix') ?>
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