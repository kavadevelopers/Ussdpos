<?= $this->load->view('mail/template/header',[],true);  ?>

<p>Hi there,</p>

<p>Your Address Verification has been rejected.</p>

<p><b>Reason</b> - <?= $reason ?></p>

<p>Please login and reupload a new proof of address, ensuring that</p>
<ol>
	<li>It must be clear showing all edges</li>
	<li>Address must be visible and must match address details provided during registration</li>
	<li>Must be issued within the last 3 monthly</li>
	<li>content must be readable </li>
</ol>

<?= $this->load->view('mail/template/footer',[],true);  ?>