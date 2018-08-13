# Executando a aplicação

1. Executar o comando: `sudo docker-compose up -d`.
2. Acessar a base de dados: `sudo docker exec -it php_db_1 bash`.
    1. Executar os scripts de configuração da base de dados:
        1. `/home/script# mysql -u root -p app < 01-permissao.sql` **senha: `root`**.
        2. `/home/script# mysql -u root -p app < 02-permissao.sql` **senha: `root`**.
3. Acessar no browser **CHROME** a URL `localhost`.
4. Cadastre um usuário e depois realize o login na aplicação.