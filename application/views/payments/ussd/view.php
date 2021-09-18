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
                <a href="<?= base_url('ussdpay/'.$page) ?>" class="btn btn-danger btn-mini">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
<?php $bank = $this->general_model->getBankByCode($item->bank); ?>
<div class="page-body">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-block">
                    <div class="view-info">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="general-info">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="table-responsive">
                                                <table class="table m-0 tbl-white-normal">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Tran. Ref</th>
                                                            <td><?= $item->ref ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Flutterwave Tran. Ref</th>
                                                            <td><?= $item->flw_ref ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Bank</th>
                                                            <td><?= $bank->name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Charge By</th>
                                                            <td><?= ucfirst($item->cfrom) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Narration</th>
                                                            <td><?= $item->narration ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Mobile</th>
                                                            <td><?= $item->mobile ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">USSD Code</th>
                                                            <td><?= $item->ussd ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">At</th>
                                                            <td><?= getPretyDateTime($item->cat) ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="table-responsive">
                                                <table class="table m-0 tbl-shopdis">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Agent</th>
                                                            <td><?= $this->agent_model->getSomeInfo($item->user)->name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Amount</th>
                                                            <td><?= niara().ptPretyAmount($item->amount) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Fees</th>
                                                            <td><?= niara().ptPretyAmount($item->com) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Flutterwave Fees</th>
                                                            <td><?= niara().ptPretyAmount($item->fcom) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Paid Amount</th>
                                                            <?php if($item->cfrom == 'buyer'){ ?>
                                                                <td><?= niara().ptPretyAmount($item->amount + $item->fcom + $item->com) ?></td>
                                                            <?php }else{ ?>
                                                                <td><?= niara().ptPretyAmount($item->amount) ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Agent Received</th>
                                                            <?php if($item->cfrom == 'buyer'){ ?>
                                                                <td><?= niara().ptPretyAmount($item->amount) ?></td>
                                                            <?php }else{ ?>
                                                                <td><?= niara().ptPretyAmount($item->amount - ($item->fcom + $item->com)) ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Status</th>
                                                            <?php if($item->status == '0'){ ?>
                                                                <td><span class="btn btn-warning btn-mini">Pending</span></td>
                                                            <?php }else if($item->status == '1'){ ?>
                                                                <td><span class="btn btn-success btn-mini">Success</span></td>
                                                            <?php }else{ ?>
                                                                <td><span class="btn btn-danger btn-mini">Failed</span></td>
                                                            <?php } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

