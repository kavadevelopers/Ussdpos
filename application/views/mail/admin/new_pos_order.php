<?= $this->load->view('mail/template/header',[],true);  ?>
<?php $item = $this->db->get_where('orders',['id' => $id])->row_object();
$product = $this->db->get_where('products',['id' => $item->product])->row_object(); ?>
<h2>Hello Admin,</h2>
<br>
<p>New Order Received.</p>

<p><b>Order Id </b> : #<?= $item->ordid ?></p>
<p><b>Agent Name </b> : <?= $this->agent_model->getSomeInfo($item->user)->name ?></p>
<p><b>POS Device </b> : <?= $product->name ?></p>
<p><b>Price </b> : <?= niara().ptPretyAmount($item->price)  ?> x <?= $item->qty ?> nos</p>

<p><b>Subtoal </b> : <?= niara().ptPretyAmount($item->subtotal) ?></p>
<p><b>Delivery Charge </b> : <?= niara().ptPretyAmount($item->delivery) ?></p>
<p><b>Total Paid </b> : <?= niara().ptPretyAmount($item->total) ?></p>
<p><b>Purchase Option </b> : <?= posPurchaseOption($item->poption)  ?></p>
<p><b>Delivery Type </b> : <?= deliveryType($item->deliverytype)  ?></p>
<p><b>Type </b> : <?= strtoupper($item->paymenttype) ?></p>


<p><b>Ordered At </b> : <?= getPretyDateTime($item->cat) ?></p>

<?= $this->load->view('mail/template/footer',[],true);  ?>