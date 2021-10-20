<?= $this->load->view('mail/template/header',[],true);  ?>
<?php $item = $this->db->get_where('orders',['id' => $id])->row_object();
$product = $this->db->get_where('products',['id' => $item->product])->row_object(); ?>
<h2>Hello Admin,</h2>
<br>
<p>New Order Received.</p>

<p><b>Order Id </b> : #<?= $item->ordid ?></p>
<p><b>POS Device </b> : <?= $product->name ?></p>

<?= $this->load->view('mail/template/footer',[],true);  ?>