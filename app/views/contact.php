<?php
$this->view("header");
?>
<form action="/send" method="post">
<input type="email" name="to" id="" required>
<input type="text" name="subject" id="" required>
<input type="text" name="text" id="" required>
<button type="submit">send</button>
</form>
<?php
$this->view("footer");
?>