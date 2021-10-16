<div class="page-body">


	<div class="row">
		<div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="fa fa-university bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Available Balance</span>
                    <h4><?= niara().ptPretyAmount($this->dashboard_model->getAdminBalance()); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
	        <div class="card widget-card-1">
	            <div class="card-block-small">
	                <i class="fa fa-hashtag bg-c-green card1-icon"></i>
	                <span class="text-c-green f-w-600">USSD Payments</span>
	                <h4><?= niara().ptPretyAmount($this->dashboard_model->getAdminUssdCollected(),2); ?></h4>
	            </div>
	        </div>
	    </div>
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="fa fa-percent bg-c-pink card1-icon"></i>
                    <span class="text-c-pink f-w-600">Fees Collected</span>
                    <h4><?= niara().ptPretyAmount($this->dashboard_model->getAdminFeesCollected()); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="fa fa-users bg-c-yellow card1-icon"></i>
                    <span class="text-c-yellow f-w-600">Active Agents</span>
                    <h4><?= number_shortenNum($this->dashboard_model->getActiveAgents(),2); ?></h4>
                </div>
            </div>
        </div>
	</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
            	<div class="card-header">
            		<h5>Recent Transactions</h5>
            	</div>
                <div class="card-block table-responsive">
                	<table class="table table-striped table-bordered table-mini table-dt2">
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


<script type="text/javascript">
	$(function(){
		$('.table-dt2').DataTable({
            "dom": "<'row'<'col-md-6'l><'col-md-6'f>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            order : [],
            "aLengthMenu": [[5,10,25, 50, -1], [5,10,25, 50, "All"]],
        });
	})
</script>