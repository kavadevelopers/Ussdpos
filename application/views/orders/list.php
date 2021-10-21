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
        <div class="col-sm-12">
            <form method="post" action="<?= base_url('orders/list') ?>">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-plus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User</label>
                                    <select class="form-control form-control-sm select2" name="user">
                                        <option value="">-- Select --</option>
                                        <?php foreach($this->general_model->getDistinctUsersFromOrders() as $key => $value){ ?>
                                            <option value="<?= $value->id ?>" <?= selected($this->input->post('user'),$value->id) ?>>
                                                <?= $value->name ?>        
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="all">All</option>
                                        <?php foreach(statusArray() as $key => $statusIt){ ?>
                                            <option value="<?= $key ?>" <?= $this->input->post('status')!=""&&$this->input->post('status')!="all"&&$this->input->post('status')==$key?'selected':'' ?>>
                                                <?= $statusIt ?>        
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control form-control-sm" name="type">
                                        <option value="">-- Select --</option>
                                        <option value="cod" <?= selected($this->input->post('type'),'cod') ?>>cod</option>
                                        <option value="wallet" <?= selected($this->input->post('type'),'wallet') ?>>wallet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Purchase Option</label>
                                    <select class="form-control form-control-sm" name="poption">
                                        <option value="">-- Select --</option>
                                        <option value="1" <?= selected($this->input->post('poption'),'1') ?>>Lease Purchase</option>
                                        <option value="2" <?= selected($this->input->post('poption'),'2') ?>>Lease Rent</option>
                                        <option value="3" <?= selected($this->input->post('poption'),'3') ?>>Outright Purchase</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Delivery Type</label>
                                    <select class="form-control form-control-sm" name="doption">
                                        <option value="">-- Select --</option>
                                        <option value="1" <?= selected($this->input->post('doption'),'1') ?>>GIG Logistics</option>
                                        <option value="2" <?= selected($this->input->post('doption'),'2') ?>>Local Bus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input name="from" type="text" placeholder="From Date" class="form-control datepicker" value="<?= $this->input->post('from') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input name="to" type="text" placeholder="To Date" class="form-control datepicker" value="<?= $this->input->post('to') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Limit</label>
                                    <select class="form-control form-control-sm" name="limit">
                                        <option value="100" <?= selected($this->input->post('limit'),'100') ?>>100</option>
                                        <option value="200" <?= selected($this->input->post('limit'),'200') ?>>200</option>
                                        <option value="500" <?= selected($this->input->post('limit'),'500') ?>>500</option>
                                        <option value="1000" <?= selected($this->input->post('limit'),'1000') ?>>1000</option>
                                        <option value="All" <?= selected($this->input->post('limit'),'All') ?>>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button class="btn btn-sm btn-warning" type="submit">
                                    <i class="fa fa-filter"></i> Filter
                                </button>        
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block table-responsive">
                    <table class="table table-bordered table-mini table-striped table-dt">
                        <thead>
                            <tr>
                                <th class="text-center">Order ID</th>
                                <th>Agent</th>
                                <th>Product</th>
                                <th>Purchase Option</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">At</th>
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
                                        <small><?= getPretyDateTime($value->cat) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-success btn-mini view-order" title="View" data-id="<?= $value->id ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php if ($value->status != 8 && $value->status != 9 && $value->status != 10): ?>    
                                            <a href="#" class="btn btn-warning btn-mini s_change" title="Change Status" data-status="<?= $value->status ?>" data-id="<?= $value->id ?>" data-note="<?= $value->note ?>">
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
            if ($(this).data('status') == 0) {
                $('#changeStatus select[name=status]').val("");
            }else{
                $('#changeStatus select[name=status]').val($(this).data('status'));
            }
            $('#changeStatus input[name=id]').val($(this).data('id'));
            $('#changeStatus textarea[name=note]').val($(this).data('note'));
            $('#changeStatus').modal('show');
        });
    });
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
                                        <option value="">-- Select --</option>
                                    <?php foreach (statusArray() as $key => $value) { ?>
                                        <?php if($key != 0){ ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" name="note" placeholder="Notes (if any)" rows="8"></textarea>
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


