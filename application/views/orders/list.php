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
                    <table class="table table-bordered table-mini table-striped table-dt">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Agent</th>
                                <th>Product</th>
                                <th>Purchase Option</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <?php $agent = $this->db->get_where('register_agent',['id' => $value->user])->row_object(); ?>
                                <?php $product = $this->db->get_where('products',['id' => $value->product])->row_object(); ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $value->ordid ?>
                                    </td>
                                    <td>
                                        <?= $agent->name ?>    
                                    </td>
                                    <td><?= $product->name ?></td>
                                    <td><?= posPurchaseOption($value->poption) ?></td>
                                    <td class="text-center"><?= $value->paymenttype ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('orders/view/').$value->id ?>" class="btn btn-success btn-mini" title="View">
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