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
            <form method="post" action="<?= base_url('transactions/').$this->uri->segment(2) ?>">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-plus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User</label>
                                    <select class="form-control form-control-sm" name="user">
                                        <option value="">-- Select --</option>
                                        <?php foreach($this->general_model->getDistinctUsersFromTransactions() as $key => $value){ ?>
                                            <option value="<?= $value->id ?>" <?= selected($this->input->post('user'),$value->id) ?>>
                                                <?= $value->name ?>        
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Perticulars</label>
                                    <select class="form-control form-control-sm" name="perticulars">
                                        <option value="">-- Select --</option>
                                        <?php foreach(traTypeArray() as $traType){ ?>
                                            <option value="<?= $traType ?>" <?= selected($this->input->post('perticulars'),$traType) ?>>
                                                <?= strtoupper(traType($traType)[0]) ?>        
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Amount Type</label>
                                    <select class="form-control form-control-sm" name="tradebcre">
                                        <option value="Both">Both</option>
                                        <option value="Credit" <?= selected($this->input->post('tradebcre'),'Credit') ?>>Credit</option>
                                        <option value="Debit" <?= selected($this->input->post('tradebcre'),'Debit') ?>>Debit</option>
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
                    
                    <table class="table table-striped table-bordered table-mini table-dt">
                        <thead>
                            <tr>
                                <th class="text-center">Particulars</th>
                                <th>Agent</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                                <th>Note</th>
                                <th class="text-center">At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <?php $agent = $this->agent_model->getSomeInfo($value->user) ?>
                                <tr>
                                    <th class="text-center">
                                        <?= strtoupper(traType($value->type)[0]) ?>
                                    </th>
                                    <td>
                                        <?= $agent->name ?>
                                    </td>
                                    <th class="text-right"><?= niara().ptPretyAmount($value->debit) ?></th>
                                    <th class="text-right"><?= niara().ptPretyAmount($value->credit) ?></th>
                                    <td><?= stringReadMoreInline($value->notes,15) ?></td>
                                    <td class="text-center"><small><?= getPretyDate($value->dt) ?></small></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>    
        </div>

    </div>
</div>