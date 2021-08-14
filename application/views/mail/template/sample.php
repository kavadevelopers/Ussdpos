<?= $this->load->view('mail/template/header',[],true);  ?>

<p>Hi there,</p>
<p>Sometimes you just want to send a simple HTML email with a simple design and clear call to action. This is it.</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="left">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td> <a href="http://htmlemail.io" target="_blank">Call To Action</a> </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<?= $this->load->view('mail/template/footer',[],true);  ?>