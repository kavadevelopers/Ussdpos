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
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>                    
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $key + 1 ?>
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
                                        <a href="<?= base_url('agent/view/').$value->id.'/'.$this->uri->segment(2) ?>" class="btn btn-success btn-mini" title="View">
                                            <i class="fa fa-eye"></i>
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