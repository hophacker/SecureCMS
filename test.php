<?php
include('Reform.php');
$reform = new Reform;
?>
<body>
Hello, your name is <?php echo $reform->HtmlEncode(
"<script>alert('meow')</script>"); ?>.
</body>

