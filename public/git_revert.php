<?php
echo shell_exec('cd C:\laragon\www\sampah && git log -n 5 --oneline');
echo shell_exec('cd C:\laragon\www\sampah && git checkout resources/views/admin/super-dashboard.blade.php');
echo shell_exec('cd C:\laragon\www\sampah && git checkout resources/views/admin/users/index.blade.php');
echo shell_exec('cd C:\laragon\www\sampah && git status');
echo "Done.";
