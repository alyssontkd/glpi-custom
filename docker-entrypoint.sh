#!/bin/bash
set -e

echo "[ ****************** ] Starting Endpoint of Application"
if ! [ -d "/var/www/html/dev.glpi.com.br/vendor" ]; then
    echo "Application not found in /var/www/html/dev.glpi.com.br - Downloading now..."
    if [ "$(ls -A)" ]; then
        echo "WARNING: /var/www/html/dev.glpi.com.br is not empty - press Ctrl+C now if this is an error!"
        ( set -x; ls -A; sleep 10 )
    fi
    echo "[ ****************** ] Execute download of the GLPI"
    cd /tmp
    wget https://github.com/glpi-project/glpi/releases/download/9.2.1/glpi-9.2.1.tgz
 #   wget https://github.com/glpi-project/glpi/releases/download/9.2.2/glpi-9.2.2.tgz
 #   wget https://github.com/glpi-project/glpi/releases/download/9.2.3/glpi-9.2.3.tgz

    echo "[ ****************** ] Extract GLPI Application"
    tar -xvzf glpi-9.2.1.tgz
#    tar -xvzf glpi-9.2.2.tgz
#    tar -xvzf glpi-9.2.3.tgz

    echo "[ ****************** ] Copying sample application configuration to real one"
    mv glpi dev.glpi.com.br
    cp -av /tmp/dev.glpi.com.br /var/www/html/

    ls -la /var/www/html/dev.glpi.com.br

    echo "[ ****************** ] Changing owner and group from the Project to 'www-data' "
    chown www-data:www-data -R /var/www/html/dev.glpi.com.br
    chmod 775 /var/www/html -Rf

    echo "[ ****************** ] Enter in the directory of the application and clone the code of the 'vendor' project"
    cd /var/www/html/dev.glpi.com.br

    #Copia os arquivos para dentro do diretório padrão
    cp -av /tmp/src/glpi/plugins/ /var/www/html/dev.glpi.com.br/
    cp -av /tmp/src/glpi/config/ /var/www/html/dev.glpi.com.br/
    tar -xvzf /tmp/src/actions/database/banco_dados_glpi.tar
    chmod 775 /var/www/html -Rf
    chown www-data:www-data -R /var/www/html/dev.glpi.com.br
    sleep 15

    echo "[ ****************** ] Importing data in database before ending buinid of Application"
    #Realiza a carga da base de dados
    mysql -u root -h database-mysql-glpi -p12345678 < /tmp/src/actions/database/script_producao_glpi_alterado.sql
fi

echo "[ ****************** ] Ending Endpoint of Application"
exec "$@"

