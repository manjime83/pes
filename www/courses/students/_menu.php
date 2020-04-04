<p><a href="student.php">Home</a> | <a href="sessions.php">Sessions</a> | <a href="control.php?action=logout">Logout</a></p>
<?php if ($_SESSION['student']['is_active'] == 0) : ?>
<p style="font-size: 150%; color: red;">You are currently blocked and can not make any reservations.</p>
<?php endif; ?>