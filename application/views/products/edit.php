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
    
    <form method="post" action="<?= base_url('products/update') ?>"  enctype="multipart/form-data">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Name <span class="-req">*</span></label>
                            <input name="name" type="text" class="form-control" value="<?= set_value('name',$item->name); ?>" placeholder="Name">
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
                                    <option value="<?= $cat->id ?>" <?= $item->category==$cat->id?'selected':'' ?>><?= $cat->name ?></option>
                                <?php } ?>
                            </select>
                            <?= form_error('name') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Thumbnail <small>size (512w x 512h)</small></label>
                            <input name="image" type="file" class="form-control" onchange="readFileImage(this)" value="<?= set_value('image'); ?>">
                            <?= form_error('image') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Charges Details</label>
                            <input name="imagech" type="file" class="form-control" onchange="readFileImage(this)" value="<?= set_value('imagech'); ?>">
                            <?= form_error('imagech') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Selling/Outright Price <span class="-req">*</span></label>
                            <input name="price" type="text" class="form-control decimal-num" value="<?= set_value('price',$item->price); ?>" placeholder="Selling/Outright Price" required>
                            <?= form_error('price') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lease Purchase Price <span class="-req">*</span></label>
                            <input name="lprice" type="text" class="form-control decimal-num" value="<?= set_value('lprice',$item->lprice); ?>" placeholder="Lease Purchase Price" required>
                            <?= form_error('lprice') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lease Purchase Month <span class="-req">*</span></label>
                            <input name="leasemonth" type="text" class="form-control numbers" value="<?= set_value('leasemonth',$item->leasemonth); ?>" placeholder="Lease Purchase Month" required>
                            <?= form_error('leasemonth') ?>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lease Onboarding fee (for lease rent)<span class="-req">*</span></label>
                            <input name="leasefee" type="text" class="form-control decimal-num" value="<?= set_value('leasefee',$item->leasefee); ?>" placeholder="Lease Onboarding fee" required>
                            <?= form_error('leasefee') ?>
                        </div>
                    </div>     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Network Provider <span class="-req">*</span></label>
                            <input name="provider" type="text" class="form-control" value="<?= set_value('provider',$item->provider); ?>" placeholder="Network Provider">
                            <?= form_error('provider') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Withdrawal Rate <span class="-req">*</span></label>
                            <input name="with_rate" type="text" class="form-control decimal-num" value="<?= set_value('with_rate',$item->with_rate); ?>" placeholder="Withdrawal Rate">
                            <?= form_error('with_rate') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Transfer / Deposit Rate <span class="-req">*</span></label>
                            <input name="depo_rate" type="text" class="form-control decimal-num" value="<?= set_value('depo_rate',$item->depo_rate); ?>" placeholder="Transfer / Deposit Rate">
                            <?= form_error('depo_rate') ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Target Type <span class="-req">*</span></label>
                            <input name="target_type" type="text" class="form-control" value="<?= set_value('target_type',$item->target_type); ?>" placeholder="Target Type">
                            <?= form_error('target_type') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Target Duration <span class="-req">*</span></label>
                            <input name="target_duration" type="text" class="form-control" value="<?= set_value('target_duration',$item->target_duration); ?>" placeholder="Target Duration">
                            <?= form_error('target_duration') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Target Amount  <span class="-req">*</span></label>
                            <input name="target_amount" type="text" class="form-control decimal-num" value="<?= set_value('target_amount',$item->target_amount); ?>" placeholder="Target Amount ">
                            <?= form_error('target_amount') ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Other Information  <span class="-req">*</span></label>
                            <textarea name="content" type="text" id="editor" class="form-control" value=""><?= $item->descr ?></textarea>
                        </div>
                    </div>   
                </div>
            </div>
            <div class="card-footer text-right">
                <input type="hidden" name="id" value="<?= $item->id ?>">
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
        { name: 'others', groups: [ 'others' ] },
        { name: 'insert' },
    ];
    CKEDITOR.replace( 'editor2',{
        toolbar : 'Basic',
        toolbarGroups,
    });
</script>