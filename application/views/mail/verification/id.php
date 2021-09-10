<?= $this->load->view('mail/template/header',[],true);  ?>

<p>Hi there,</p>

<p>Your Proof of Identity Verification has been rejected.</p>

<p><b>Reason</b> - <?= $reason ?></p>

<p>Please login and reupload a new Proof of Identification, ensuring that</p>
<ol>
	<li>ID Card must be Government Issued Regulatory ID (Voters card, Intl Passport, Drivers License, NIN Slip/Card)</li>
	<li>It Should be clear and content readable with all edges showing</li>
	<li>Must match the information entered during registration</li>
</ol>

<?= $this->load->view('mail/template/footer',[],true);  ?>