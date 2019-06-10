# api-racer
API REST para corredores

# Instruções para instalação

### 1 - Clone o repositório para a sua máquina.
```
https://github.com/tadeu390/api-racer.git
```

Uma pasta com o nome <b>api-racer</b> será criada, sendo assim entre dentro dela e abra o terminal do linux.

Dentro dessa pasta temos uma pasta chamada <b>bin</b>. Dentro dela encontram-se arquivos que nos auxiliam a trabalhar
com o Docker.

### 2 - Configurando o ambiente da API.

Para o primeiro uso será necessário executar a seguinte linha de comando:
```
sudo ./bin/init.sh
```
Agora, vamos criar todos os containeres necessários para que a api funcione. Sendo assim, execute a linha de comando abaixo:
```
sudo ./bin/run.sh
```

Com nossos containeres estão iniciados, agora vamos entrar na workspace do projeto, dentro do container, para que possamos instalar as dependências via composer. Para acessar a worskpace, execute a linha de comando abaixo:
```
sudo ./bin/workspace.sh
```

Em seguida, execute o comando do composer para instalar as dependências:
```
composer install
```

Agora vamos gerar nossa chave de criptografia. Para isso basta executar o comando abaixo.
```
php artisan key:generate
```

Com isso feito, vamos fazer um teste para verificarmos se a api está correntamente configurada e pronta para uso. Para isso, vá ao seu navagador e acesse a seguinte URL:
```
http://localhost/api
```
A mensagem "API-RACER OK" aparecerá se tudo estiver ok.

## <b>Nota</b>
Ao acessar a URL, se caso for mostrado na tela algum erro por conta de falta de permissão, basta apenas dar as permissões aos diretórios necessários.

Por fim, basta executar o comando artisan responsável por executar as migrations.
```
php artisan migrate
```
