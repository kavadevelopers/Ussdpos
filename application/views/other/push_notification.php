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
        </div>
    </div>
</div>

<div class="page-body">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <form method="post" action="<?= base_url('other/send_pushnotification') ?>">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title <span class="-req">*</span></label>
                                    <input name="title" type="text" class="form-control" value="<?= set_value('title'); ?>" placeholder="Title" required>
                                    <?= form_error('title') ?>
                                </div>
                            </div>  
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message <span class="-req">*</span></label>
                                    <textarea name="message" type="text" class="form-control" value="<?= set_value('message'); ?>" placeholder="Message" rows="7" required></textarea>
                                    <?= form_error('message') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-send"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-block table-responsive">
                    <table class="table table-striped table-bordered table-mini table-dt">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Message</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?= $value->title ?>
                                    </td>
                                    <td>
                                        <?= stringReadMoreInline($value->body,30) ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('other/send_pushnotification/').$value->id ?>" class="btn btn-primary btn-mini" title="Send Again">
                                            <i class="fa fa-send"></i>
                                        </a>
                                        <a href="<?= base_url('other/delete_push/').$value->id ?>" class="btn btn-danger btn-mini btn-delete" title="delete">
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