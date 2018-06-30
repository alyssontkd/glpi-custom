echo "[******] Run the following command to see Docker’s network range [This is optional].";
echo "ip a | grep docker | grep inet";

echo "[******] Execute the follow command in host for configure your database. Save the IPAddress returned.";
echo "[sudo] docker inspect database-mysql | grep IPAddress";

echo "[******] Get the IPAddress and execute the follow command in your host.";
echo "mysql -u root -p12345678 < /tmp/src/actions/database/script_inicial_glpi.sql";

# mysql -u root -p

# mysql> create database glpi;

# mysql> create user 'usr_aplicacao'@'%' identified by '12345678';

# mysql> grant all on *.* to usr_aplicacao identified by '12345678';

# mysql> flush privileges;

# mysql> quit;


#Os usuários e senhas padrões são:

#glpi/glpi para a conta do usuário administrador
#tech/tech para a conta do usuário técnico
#normal/normal para a conta do usuário normal
#post-only/postonly para a conta do usuário postonly
#Você pode excluir ou modificar estes usuários bem como os dados iniciais.