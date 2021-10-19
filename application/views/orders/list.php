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
                                <th class="text-center">Status</th>
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
                                        <?= getStatusString($value->status) ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('orders/view/').$value->id ?>" class="btn btn-success btn-mini" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php if ($value->status != 8): ?>    
                                            <a href="#" class="btn btn-warning btn-mini s_change" title="Change Status" data-status="<?= $value->status ?>" data-id="<?= $value->id ?>">
                                                <i class="fa fa-check-square-o"></i>
                                            </a>
                                        <?php endif ?>
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


<script type="text/javascript">
    $(function(){
        $('.s_change').click(function(e) {
            e.preventDefault();
            $('#changeStatus select[name=status]').val($(this).data('status'));
            $('#changeStatus input[name=id]').val($(this).data('id'));
            $('#changeStatus').modal('show');
        });
    })
</script>


<div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <form method="post" action="<?= base_url('orders/change_status') ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Change Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status<span class="-req">*</span></label>
                                <select class="form-control" name="status" required>
                                    <?php foreach (statusArray() as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>


