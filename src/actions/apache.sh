echo "[******] Get user logged";
whoami

#echo "[******] Copying and enable virtualhost 'site.conf'";
#cp /tmp/src/actions/apache2/sites-available/site.conf /etc/apache2/sites-available/site.conf

echo "[******] Copying and enable virtualhost 'status.conf'";
cp /tmp/src/actions/apache2/sites-available/status.conf /etc/apache2/sites-available/status.conf

echo "[******] Copying configurations for security of apache.";
cp /tmp/src/actions/apache2/conf-available/security.conf /etc/apache2/conf-available/security.conf

echo "[******] Copying configurations for security of apache.";
cp /tmp/src/actions/apache2/ports.conf /etc/apache2/ports.conf

echo "[******] Copying configurations for apache2.";
cp /tmp/src/actions/apache2/apache2.conf /etc/apache2/apache2.conf

echo "[******] Enable the enviroments variables.";
source /etc/apache2/envvars
apache2 -V

echo "[******] Reload Apache 2 Service Configs. #1";
service apache2 reload


echo "[******] Enable modules necessary";
a2ensite site.conf
a2ensite status.conf

echo "[******] Disable default virtualhost '000-default.conf'";
a2dissite 000-default.conf

echo "[******] Enable Apache Mod Rewrite";
a2enmod rewrite

echo "[******] Enable Apache Mod Headers";
a2enmod headers

echo "[******] Reload Apache 2 Service Configs. #2";
service apache2 reload

echo "[******] Starts Apache using Foreground Mode";
#apache2ctl -D FOREGROUND
exec apache2 -DFOREGROUND