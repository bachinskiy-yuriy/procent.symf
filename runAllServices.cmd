start d:\wamp\wampmanager.exe
start php bin/console server:run
timeout /t 20 /nobreak
start "" http://localhost:8000
start "" http://localhost/phpmyadmin/sql.php?db=procent#PMAURL-0:sql.php?db=procent&table=creditonline&server=1
