<?= $this->load->view('mail/template/header',[],true);  ?>

<p>Hi there,</p>

<p>Your <?= $type ?> has been rejected.</p>

<p><b>Reason</b> - <?= $reason ?></p>

<?= $this->load->view('mail/template/footer',[],true);  ?>