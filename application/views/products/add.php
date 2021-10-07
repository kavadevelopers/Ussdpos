<div class="page-header">
    <div class="align-items-end">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4><?= $_title ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right">
                 
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    
    <form method="post" action="<?= base_url('products/save') ?>"  enctype="multipart/form-data">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Name <span class="-req">*</span></label>
                            <input name="name" type="text" class="form-control" value="<?= set_value('name'); ?>" placeholder="Name" required>
                            <?= form_error('name') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Category <span class="-req">*</span></label>
                            <?php $categories = $this->db->get_where('products_cate',['df' => ''])->result_object(); ?>
                            <select class="form-control select2" name="category" required>
                                <option value="">-- Select --</option>
                                <?php foreach($categories as $cat){ ?>
                                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                <?php } ?>
                            </select>
                            <?= form_error('name') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Thumbnail <span class="-req">*</span> <small>size (512w x 512h)</small></label>
                            <input name="image" type="file" class="form-control" onchange="readFileImage(this)" value="<?= set_value('image'); ?>" required>
                            <?= form_error('image') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Charges Details <span class="-req">*</span></label>
                            <input name="imagech" type="file" class="form-control" onchange="readFileImage(this)" value="<?= set_value('imagech'); ?>" required>
                            <?= form_error('imagech') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Selling/Outright Price <span class="-req">*</span></label>
                            <input name="price" type="text" class="form-control decimal-num" value="<?= set_value('price'); ?>" placeholder="Selling/Outright Price" required>
                            <?= form_error('price') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lease Purchase Price <span class="-req">*</span></label>
                            <input name="lprice" type="text" class="form-control decimal-num" value="<?= set_value('lprice'); ?>" placeholder="Lease Purchase Price" required>
                            <?= form_error('lprice') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lease Purchase Month <span class="-req">*</span></label>
                            <input name="leasemonth" type="text" class="form-control numbers" value="<?= set_value('leasemonth'); ?>" placeholder="Lease Purchase Month" required>
                            <?= form_error('leasemonth') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lease Onboarding fee (for lease rent)<span class="-req">*</span></label>
                            <input name="leasefee" type="text" class="form-control decimal-num" value="<?= set_value('leasefee'); ?>" placeholder="Lease Onboarding fee" required>
                            <?= form_error('leasefee') ?>
                        </div>
                    </div>   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Network Provider <span class="-req">*</span></label>
                            <input name="provider" type="text" class="form-control" value="<?= set_value('provider'); ?>" placeholder="Network Provider" required>
                            <?= form_error('provider') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Withdrawal Rate <span class="-req">*</span></label>
                            <input name="with_rate" type="text" class="form-control decimal-num" value="<?= set_value('with_rate'); ?>" placeholder="Withdrawal Rate" required>
                            <?= form_error('with_rate') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Transfer / Deposit Rate <span class="-req">*</span></label>
                            <input name="depo_rate" type="text" class="form-control decimal-num" value="<?= set_value('depo_rate'); ?>" placeholder="Transfer / Deposit Rate" required>
                            <?= form_error('depo_rate') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Target Type <span class="-req">*</span></label>
                            <input name="target_type" type="text" class="form-control" value="<?= set_value('target_type'); ?>" placeholder="Target Type" required>
                            <?= form_error('target_type') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Target Duration <span class="-req">*</span></label>
                            <input name="target_duration" type="text" class="form-control" value="<?= set_value('target_duration'); ?>" placeholder="Target Duration" required>
                            <?= form_error('target_duration') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Target Amount  <span class="-req">*</span></label>
                            <input name="target_amount" type="text" class="form-control decimal-num" value="<?= set_value('target_amount'); ?>" placeholder="Target Amount " required>
                            <?= form_error('target_amount') ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Other Information  <span class="-req">*</span></label>
                            <textarea name="content" type="text" id="editor" class="form-control" value=""></textarea>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="<?= base_url('products/list') ?>" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </form>
</div>

<script src="<?= base_url('asset/assets/ckeditor/ckeditor.js') ?>"></script>
<script type="text/javascript">
    var toolbarGroups = [
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        '/',
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] }
    ];
    CKEDITOR.replace( 'editor',{
        toolbar : 'Basic',
        toolbarGroups,
    });
</script>