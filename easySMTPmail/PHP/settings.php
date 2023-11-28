<style>
    .easySMTPmail :is(input, select) {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        background: #fff;
        border: solid 1px #ddd;
        margin: 10px 0;
    }

    .easySMTPmail button {
        background: #000;
        bordfer-radius: 0;
        border: none;
        padding: 10px;
        color: #fff;
    }
</style>



<form action="" class="easySMTPmail" method="post">



    <h3>easySMTPmail - settings</h3>

    <p style="width:100%;padding:10px;border:solid 1px #ddd;"> just put <b> easySMTPform() </b> function to yours template where you want use, or <b> [% easySMTPmail %] </b> on your content in TinyMCE/markdown.</p>


    <label for="">choose sending method: (save after each change to see new fields)</label>
    <select name="mailorsmtp" id="">
        <option value="smtp" <?php if ($this->getValue('mailorsmtp') == 'smtp') {
                                    echo 'selected';
                                }; ?>>SMTP</option>
        <option value="mail" <?php if ($this->getValue('mailorsmtp') == 'mail') {
                                    echo 'selected';
                                }; ?>>Mailto</option>
    </select>


    <?php if ($this->getValue('mailorsmtp') == 'smtp') :?>

    <label for="">SMTP server</label>
    <input type="text" name="host" value="<?php echo $this->getValue('host'); ?>">

    <label for="">SMTPAuth</label>
    <select name="SMTPAuth" class="SMTPAUTH" id="">
        <option value="true" <?php if ($this->getValue('SMTPAuth') == 'true') {
                                    echo 'selected';
                                }; ?>>True</option>
        <option value="false" <?php if ($this->getValue('SMTPAuth') == 'false') {
                                    echo 'selected';
                                }; ?>>False</option>
    </select>


    <label for="">Username</label>
    <input type="text" name="Username" value="<?php echo $this->getValue('Username'); ?>" required>

    <label for="">Password</label>
    <input type="password" name="Password" class="form-control" value="<?php echo $this->getValue('Password'); ?>" required>

    <label for="">SMTPSecure</label>
    <input type="text" name="SMTPSecure" placeholder="tls" value="<?php echo $this->getValue('SMTPSecure'); ?>" required>


    <label for="">Port</label>
    <input type="text" name="Port" placeholder="465" value="<?php echo $this->getValue('Port'); ?>" required>


    <?php endif;?>


    <label for="">subject</label>
    <input type="text" name="subject" value="<?php echo $this->getValue('subject'); ?>" required>

    <label for="">set from</label>
    <input type="text" name="setFrom" value="<?php echo $this->getValue('setFrom'); ?>" required>

    <label for="">set recipient</label>
    <input type="text" name="addAddress" value="<?php echo $this->getValue('addAddress'); ?>" required>

    <label for="">Secret Key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank">Google Recaptcha (robot v2)</a></label>
    <input type="text" name="secretKey" value="<?php echo $this->getValue('secretKey'); ?>" required>

    <label for="">Site Key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank">Google Recaptcha (robot v2)</a></label>
    <input type="text" name="siteKey" value="<?php echo $this->getValue('siteKey'); ?>" required>



    <label for="">Success email info</label>
    <input type="text" name="success" value="<?php echo $this->getValue('success'); ?>" required>

    <label for="">Error email info</label>
    <input type="text" name="error" value="<?php echo $this->getValue('error'); ?>" required>
    <hr>
    <br>

    <h3>Translate option</h3>

    <input type="text" name="lang-name" value="<?php echo $this->getValue('lang-name'); ?>" class="my-2" placeholder="Name" required>
    <input type="text" name="lang-email" value="<?php echo $this->getValue('lang-email'); ?>" class="my-2" placeholder="Email" required>
    <input type="text" name="lang-phone" value="<?php echo $this->getValue('lang-phone'); ?>" class="my-2" placeholder="Phone" required>
    <input type="text" name="lang-message" value="<?php echo $this->getValue('lang-message'); ?>" class="my-2" placeholder="Message" required>
    <input type="text" name="lang-privacy" value="<?php echo $this->getValue('lang-privacy'); ?>" class="my-2" placeholder="privacy policy text checkbox" required>
    <input type="text" name="lang-submit" value="<?php echo $this->getValue('lang-submit'); ?>" class="my-2" placeholder="send button text" required>

    <hr>
    <button type="submit" name="saveESMTPM" class="btn btn-primary">Save settings</button>

</form>