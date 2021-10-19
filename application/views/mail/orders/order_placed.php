<?= $this->load->view('mail/template/header',[],true);  ?>

<p>Hi there,</p>
<p>Email verification code is : <?= $code ?></p>

<?= $this->load->view('mail/template/footer',[],true);  ?>