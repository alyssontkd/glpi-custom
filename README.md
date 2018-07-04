# Projeto glpi-docker-customizado
Este projeto visa disponibilizar a versão 9.2.1 do GLPI com vários pluguins instalados e com vários catálogos de serviço já configurados.

# Versões utilizadas na geração das imagens
Abaixo estão listadas, para fins de documentação, todas as versões utilizadas para a execução deste projeto, contudo acredito que você não tera problemas em executar esses passos com outras versões e distribuições linux.

## Docker
**Para descobrir a versão do docker, digite o comando abaixo:**
```
# docker --version
```
**O retorno do comando acima será algo como:**
```
Docker version 17.05.0-ce, build 89658be
```

## Docker Compose
**Para descobrir a versão do docker, digite o comando abaixo:**
```
# docker-compose --version
```
**O retorno do comando acima será algo como:**
```
docker-compose version 1.18.0, build 8dd22a9
```

## Sistema Operacional 
**Para descobrir a versão do sistema operacional digite o comando**
```
# lsb_release -irc
```
**O retorno será algo como o trecho abaixo:**
```
Distributor ID: Ubuntu
Release:        16.04
Codename:       xenial
```

## GLPI
**O GLPI que está sendo instalado neste projeto é a versão 9.2.1**

## MySQL
**A versão do MySQL utilizada foi a versão 5.7**


# Como instalar os pré-requisitos? 
## Instalando o docker via repositório do Ubuntu
**A instalação padrão via repositório do Ubuntu consite em um simples comando 'apt', mas vamos atualizar nosso banco de dados de pacote**
```
$ sudo apt-get update
```
**Adicione ao sistema a chave GPG oficial do repositório do Docker:**
```
$ sudo apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
```
**Adicione o repositório do Docker às fontes do APT:**
```
$ sudo apt-add-repository 'deb https://apt.dockerproject.org/repo ubuntu-xenial main'
$ sudo apt-get update
```
**Certifique-se de que você está instalando a partir do repositório do Docker em vez do repositório padrão do Ubuntu 16.04:**
```
$ apt-cache policy docker-engine
```
**Você deverá ver uma saída semelhante à seguinte:**
```
Output of apt-cache policy docker-engine
docker-engine:
  Installed: (none)
  Candidate: 1.11.1-0~xenial
  Version table:
     1.11.1-0~xenial 500
        500 https://apt.dockerproject.org/repo ubuntu-xenial/main amd64 Packages
     1.11.0-0~xenial 500
        500 https://apt.dockerproject.org/repo ubuntu-xenial/main amd64 Packages
```

**A instalação padrão via repositório do Ubuntu consite em um simples comando 'apt'. O Docker agora será instalado, o daemon iniciado, e o processo habilitado para iniciar no boot.**
```
$ sudo apt-get install -y docker-engine
```
**Verifique que ele está executando:**
```
$ sudo systemctl status docker
```
**A saída deve ser similar ao seguinte, mostrando que o serviço está ativo e em execução:**
```
● docker.service - Docker Application Container Engine
   Loaded: loaded (/lib/systemd/system/docker.service; enabled; vendor preset: enabled)
   Active: active (running) since Tue 2018-07-03 12:29:01 UTC; 22h ago
     Docs: https://docs.docker.com
 Main PID: 13013 (dockerd)
    Tasks: 71
   Memory: 50.0M
      CPU: 4min 29.980s
   CGroup: /system.slice/docker.service
           ├─13013 /usr/bin/dockerd -H fd://
           ├─13018 docker-containerd -l unix:///var/run/docker/libcontainerd/docker-containerd.sock --metrics-interval=0 --start-timeout 2m --state-dir /v
```
**A instalação do Docker lhe fornece não apenas o serviço Docker (daemon) mas também o utilitário de linha de comando docker, ou o cliente Docker. Vamos explorar como utilizar o comando docker mais tarde nesse tutorial.**

**Prontinho! Para testar se seu docker foi instalado com sucesso digite o comando do docker que retorna a versão instalada. veja abaixo o camando e a saída**
```
$ docker --version
Docker version 17.05.0-ce, build 89658be
```

# Instalando o docker-compose
**Baixe a última versão do docker-compose**
```
$ sudo curl -L https://github.com/docker/compose/releases/download/1.18.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
```
**Aplique as permissoes de execução ao arquivo**
```
$ sudo chmod +x /usr/local/bin/docker-compose
```
**Pronto! Seu docker-compose já deve estar instalado. Valide a instalação com o comando abaixo:**
```
# docker-compose --version
```
**O retorno do comando acima será algo como:**
```
docker-compose version 1.18.0, build 8dd22a9
```


# Inicializando o GLPI neste projeto
**Agora seu sistema operacional já está com o docker e docker-compose instalado, entao basta clonar este repositório ou baixar os arquivos e colocar na para '/var/www/docker'(Este é apenas o caminho sugerido. Voce pode colocar onde quiser!) e mandar recompilar a imagem.**
__Para clonar o repositório digite:__
```
$ git clone https://github.com/alyssontkd/glpi-custom.git
```
__Agora entre no diretório e rode o docker-compose:__

```
# cd '/var/www/docker/glpi-docker
# docker-compose up -d
```
**Depois deste comando a imagem será recompilada e ao fim o GLPI podera ser acessado via URL: http://127.0.0.1**


# Dicas importantes
```
Nome do host de banco de dados: database-mysql-glpi
Nome da base de dados: glpi
Nome do usuario: root
Senha de root: 12345678
```
 
**Para verificar se os pods estão rodando:** 
``` 
$ docker ps -a
```
**A Saída para o comando acima será algo como:** 
``` 
CONTAINER ID        IMAGE                      COMMAND                  CREATED             STATUS              PORTS                                                              NAMES
107a862ffdca        alyssontkd/ambiente-glpi   "docker-entrypoint..."   14 hours ago        Up 14 hours         0.0.0.0:80->80/tcp, 0.0.0.0:443->443/tcp, 0.0.0.0:8888->8888/tcp   dev-glpiv1.0
659ec002ae99        mysql:5.7                  "docker-entrypoint..."   14 hours ago        Up 14 hours         0.0.0.0:3306->3306/tcp                                             database-mysql-glpi

```
