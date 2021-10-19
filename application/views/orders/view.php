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
                <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger btn-mini">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
<?php $product = $this->db->get_where('products',['id' => $item->product])->row_object(); ?>
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
                                                            <th scope="row">Order ID</th>
                                                            <td>0000<?= $item->id ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Purchase Option</th>
                                                            <td><?= posPurchaseOption($item->poption) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">POS Device</th>
                                                            <td><?= $product->name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Delivery Type</th>
                                                            <td><?= deliveryType($item->deliverytype) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">State</th>
                                                            <td><?= $item->state ?></td>
                                                        </tr>
                                                        <?php if($item->deliverytype == 1){ ?>
                                                            <tr>
                                                                <th scope="row">Terminal Location</th>
                                                                <td><?= $item->terminal ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <?php if($item->deliverytype == 2){ ?>
                                                            <tr>
                                                                <th scope="row">Delivery Address</th>
                                                                <td><?= $item->address ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Closest Bus Park</th>
                                                                <td><?= $item->buspark ?></td>
                                                            </tr>
                                                        <?php } ?>
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
                                                            <th scope="row">Type</th>
                                                            <td><?= $item->paymenttype ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Price</th>
                                                            <td><?= niara().ptPretyAmount($item->price)  ?> x <?= $item->qty ?> nos</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Subtotal</th>
                                                            <td><?= niara().ptPretyAmount($item->subtotal) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Delivery</th>
                                                            <td><?= niara().ptPretyAmount($item->delivery) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Total Paid</th>
                                                            <td><?= niara().ptPretyAmount($item->total) ?></td>
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
