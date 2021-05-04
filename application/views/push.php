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
    
    <form method="post" action="<?= base_url('dashboard/send') ?>">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Token <span class="-req">*</span></label>
                            <input name="token" type="text" class="form-control" value="<?= set_value('token'); ?>" placeholder="Token">
                            <?= form_error('token') ?>
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Title <span class="-req">*</span></label>
                            <input name="title" type="text" class="form-control" value="<?= set_value('title'); ?>" placeholder="Title">
                            <?= form_error('title') ?>
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Body <span class="-req">*</span></label>
                            <input name="body" type="text" class="form-control" value="<?= set_value('body'); ?>" placeholder="Body">
                            <?= form_error('body') ?>
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Device <span class="-req">*</span></label>
                            <select class="form-control" name="device">
                                <option value="android">Android</option>
                                <option value="iOS">iOS</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-footer text-right">
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </form>
</div>