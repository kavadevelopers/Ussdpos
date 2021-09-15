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
                                <th class="text-center">Tra. Ref.</th>
                                <th>Bank</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center">Pay At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <tr>
                                    <th class="text-center">
                                        <?= $value->ref ?>
                                    </th>
                                    <td><?= $this->general_model->getBankByCode($value->bank)->name ?></td>
                                    <th class="text-right"><?= niara().ptPretyAmount($value->amount) ?></th>
                                    <td class="text-center"><small><?= getPretyDateTime($value->cat) ?></small></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>    
        </div>

    </div>
</div>