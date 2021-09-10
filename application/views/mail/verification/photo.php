<?= $this->load->view('mail/template/header',[],true);  ?>

<p>Hi there,</p>

<p>Your Passport Photograph Verification has been rejected.</p>

<p><b>Reason</b> - <?= $reason ?></p>

<p>Please login and reupload a new Passport Photo, ensuring that</p>
<ol>
	<li>Passport Photo should be against plain background</li>
	<li>Must be taken fully clothed and upright position</li>
</ol>

<?= $this->load->view('mail/template/footer',[],true);  ?>