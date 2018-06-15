LOJA WEB REIS

DESCRIÇÃO


No seu ambiente público permite somente a visualização dos produtos disponíveis.
Para se ter acesso à Área Administartiva é necessário realizar o login, com
e-mail: christian@gmail.com e senha: 123. Após o login é permitido: Listar,
Visualizar, Cadastrar, Alterar e Excluir produtos, além é claro de sair pelo link
"Sair" que o retorna para a área publica de acesso.

Acesso sem login na Área Administrativa não é tolerado pelo sistema, caso alguma página administrativa tente ser
acessada sem permissão, o usuário é redirecionado para o Login.

TECNOLOGIAS

Para frontend foi utilizado HTML e o Framework Bootstrap para agilizar 
tarefas com estilização em CSS

Para backend foi utilizado o micro Framework Slim na versão 3, framework em PHP, sendo 
 gerenciado pelo Composer.
 
Banco de dados mySQL

CONFIGURAÇÕES

O slim necessita de cuidado quanto a versão do PHP. Esse projeto foi desenvolvido
e testado na versão 5.6.35. Para versões diferentes, talvez seja necessário configurações 
extras no arquivo ".htaccess" do projeto

O banco de dados mySQL está disponível na pasta "db", é necessário importar para o seu 
SGBD o arquivo completo "loja_web_db.sql"

Atentar para as configurções do arquivo "config/config.php" pois elas precisam
estar de acordo com os dados local (no meu caso, usuário e senha o PhpMyAdmin).

Servidor local WAMPSERVER 3.1.3 64 bits, phpMyAdmin 4.7.9, , Apache 2.4.33, 
PHP 5.6.35, MySQL 5.7.21

PRMEIRO ACESSO

Para acessar o sistema é necessário adiciona-lo na pasta de projetos do seu servidor local,
no Wamp é na pasta "www", no XAMMP é "htdocs", não se esqueça de importar o banco para seu PhpMyAdmin
e configurar corretamente o arquivo "config/config.php"

Para começar a utilizar o sistema, basta abrir o navegador do seu computador, com
seu servidor local(XAMPP, WAMP) funcionando, e acessar a url

"http://localhost/loja-web-reis/"

isso vai direcionar para a HOME do projeto onde é possível iniciar a navegção pelo sistema

Necessário conexão com a internet, pois a estilização vem do Bootstrap online,
caso contrário a estilização não ficará adequada.













