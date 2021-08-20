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
    <div class="row">

        <?php if($_e == 0){ ?>
            <div class="col-md-4">
                <div class="card">
                    <form method="post" action="<?= base_url('banks/save_transfer') ?>" enctype="multipart/form-data">
                        <div class="card-block">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name <span class="-req">*</span></label>
                                    <input name="name" type="text" class="form-control" value="<?= set_value('name'); ?>" placeholder="Name" required>
                                    <?= form_error('name') ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bank Code <span class="-req">*</span></label>
                                    <input name="bcode" type="text" class="form-control numbers" value="<?= set_value('bcode'); ?>" placeholder="Bank Code" required>
                                    <?= form_error('bcode') ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Thumbnail <span class="-req">*</span></label>
                                    <input name="image" type="file" class="form-control" onchange="readFileImage(this)" value="<?= set_value('image'); ?>" required>
                                    <?= form_error('image') ?>
                                </div>
                            </div> 
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-success">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php }else{ ?>
            <div class="col-md-4">
                <div class="card">
                    <form method="post" action="<?= base_url('banks/update_transfer') ?>" enctype="multipart/form-data">
                        <div class="card-block">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name <span class="-req">*</span></label>
                                    <input name="name" type="text" class="form-control" value="<?= set_value('name',$item->name); ?>" placeholder="Name" required>
                                    <?= form_error('name') ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bank Code <span class="-req">*</span></label>
                                    <input name="bcode" type="text" class="form-control numbers" value="<?= set_value('bcode',$item->bcode); ?>" placeholder="Bank Code" required>
                                    <?= form_error('bcode') ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Thumbnail</label>
                                    <input name="image" type="file" class="form-control" onchange="readFileImage(this)" value="<?= set_value('image'); ?>">
                                    <?= form_error('image') ?>
                                </div>
                            </div> 
                            <div class="col-md-12 text-center">
                                <img src="<?= $this->general_model->getBankThumb($item->id) ?>" style="max-width: 150px;">
                            </div>   
                        </div>
                        <div class="card-footer text-right">
                            <a href="<?= base_url('banks/ussd') ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button class="btn btn-success">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                        <input type="hidden" name="id" value="<?= $item->id ?>">
                    </form>
                </div>
            </div>
        <?php } ?>
        

        <div class="col-md-8">
            <div class="card">
                <div class="card-block table-responsive">
                    <table class="table table-bordered table-mini table-dt">
                        <thead>
                            <tr>
                                <th class="text-center">Thumbnail</th>
                                <th>Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="<?= $this->general_model->getBankThumb($value['id'])?>" style="max-width: 80px;">
                                    </td>
                                    <td><?= $value['name'] ?></td>
                                    <td class="text-center"><?= $value['bcode'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('banks/edit_transfer/').$value['id'] ?>" class="btn btn-primary btn-mini">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('banks/delete/').$value['id'] ?>/transfer" class="btn btn-danger btn-mini btn-delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>    
        </div>
    </div>
</div>

