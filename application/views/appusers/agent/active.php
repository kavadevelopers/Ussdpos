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
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-block table-responsive">
                    
                    <table class="table table-striped table-bordered table-mini table-dt">
                        <thead>
                            <tr>
                                <th class="text-center">Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-center">Status</th>                     
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="<?= $this->agent_model->profile($value->id) ?>" class="tb-row-image">
                                    </td>
                                    <td>
                                        <?= ucfirst($value->name) ?>
                                    </td>
                                    <td>
                                        <?= $value->email ?>
                                    </td>
                                    <td>
                                        <?= $value->phone ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($value->block == ""){ ?>
                                            <a href="<?= base_url('agent/block/').$value->id.'/'.$this->uri->segment(2) ?>/yes" class="btn btn-success btn-mini" onclick="return confirm('Are you sure?');" title="Click to block user">
                                                Active
                                            </a>
                                        <?php }else{ ?>
                                            <a href="<?= base_url('agent/block/').$value->id.'/'.$this->uri->segment(2) ?>" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?');" title="Click to unblock user">
                                                Blocked
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('agent/view/').$value->id.'/'.$this->uri->segment(2) ?>" class="btn btn-success btn-mini" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('agent/delete/').$value->id.'/'.$this->uri->segment(2) ?>" class="btn btn-danger btn-mini btn-delete" title="delete">
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