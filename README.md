# Projeto: Inventário Minecraft

Este projeto é uma aplicação web simples que simula um sistema de inventário de itens, inspirado no jogo Minecraft. Ele permite que usuários se cadastrem, façam login e gerenciem seus próprios itens de inventário através de operações CRUD (Create, Read, Update, Delete).

## Visão Geral do Projeto

O objetivo principal deste projeto é demonstrar a construção de uma aplicação web interativa utilizando tecnologias front-end e back-end para persistência e manipulação de dados em um banco de dados relacional.

**Funcionalidades Implementadas:**

* **Autenticação de Usuários:**
    * **Login:** Página inicial com formulário de login para usuários existentes.
    * **Cadastro:** Opção para registro de novos usuários com nome, email e senha.
    * **Controle de Sessão:** Gerenciamento de sessões para manter o usuário logado e redirecionar para a página do inventário após o login bem-sucedido.
    * **Design Interativo:** Abas (Login/Cadastre-se) para alternar entre os formulários, com destaque visual para a aba ativa.
    * **Personalização Visual:** Imagem de fundo estilo Minecraft e ajuste de transparência e cores dos elementos do formulário.

* **Inventário de Itens (CRUD):**
    * **Visualização (Read):** Exibição de uma lista dos itens pertencentes ao usuário logado, incluindo nome, quantidade e descrição.
    * **Adicionar Item (Create):** Formulário para cadastrar novos itens. Implementa uma lógica inteligente: se o item já existe no inventário do usuário, a quantidade é somada em vez de criar um novo registro.
    * **Editar Item (Update):** Funcionalidade para modificar as informações de um item existente (nome, quantidade, descrição).
    * **Excluir Item (Delete):** Opção para remover itens do inventário, com uma confirmação para evitar exclusões acidentais.

## Tecnologias Utilizadas

* **Front-end:**
    * **HTML5:** Linguagem de marcação para a estrutura das páginas web.
    * **CSS3:** Linguagem de estilo para o design, layout e efeitos visuais da interface do usuário.
    * **Bootstrap 4:** Framework CSS que oferece componentes pré-estilizados (formulários, botões, navegação, abas) e um sistema de grid responsivo, agilizando o desenvolvimento do front-end e garantindo compatibilidade entre dispositivos.
    * **JavaScript / jQuery:** Para a funcionalidade das abas do Bootstrap e possíveis interações futuras.

* **Back-end:**
    * **PHP:** Linguagem de script do lado do servidor responsável pela lógica de negócio, processamento de formulários, interação com o banco de dados (inserção, leitura, atualização e exclusão de dados) e gerenciamento de sessões de usuário.

* **Banco de Dados:**
    * **MySQL:** Sistema de Gerenciamento de Banco de Dados Relacional (SGBDR) utilizado para armazenar permanentemente os dados dos usuários (credenciais de login) e os registros de itens do inventário de cada usuário.

* **Servidor Web:**
    * **Apache (via USBWebserver):** Servidor HTTP que hospeda a aplicação web, processa as requisições PHP e entrega as páginas HTML, CSS e JavaScript para o navegador do cliente. O USBWebserver é um ambiente de desenvolvimento portátil que já integra Apache, MySQL e PHP.

## Estrutura de Pastas e Explicação

A organização dos arquivos é crucial para a manutenibilidade e escalabilidade do projeto. Abaixo está a hierarquia de pastas e a função de cada diretório e arquivo principal:

minecraft_inventario/
- css/
    - style.css "Arquivo de estilos CSS personalizados, contém todas as regras de estilização específicas, incluindo: 
        - Estilo para a imagem de fundo da página de login.
        - Ajustes de transparência e cores para os cards.
        - Cores dos cards."

- img/ "Contém as imagens usadas no projeto."

- includes/
    - conexao.php "Arquivo responsável por estabelecer a conexão com o banco de dado MySQL."
    - funcoes.php "Arquivo que contém as funções auxiliares responsáveis por verificar se o usuário está logado ou se ele deve fazer login."
- paginas/
    - inventario.php "Página principal, realiza um query com todos os itens que estão atribuído aquele respectivo usuário."
    - editar_item.php "Arquivo responsável por editar o nome, quantidade e a descrição dos itens."
    - cadastrar_item.php "Arquivo responsável por cadastrar um novo item, dando, ao usuário, a possibilidade adicionar um item que possua: nome, quantidade e descrição."
- index.php "Página principal responsável pelo login e pelo cadastro de usuários."
---

## Configuração e Instalação Local

Para executar este projeto em seu ambiente de desenvolvimento:

1.  **Pré-requisitos:**
    * Um servidor web com suporte a PHP e MySQL, como **USBWebserver** (recomendado para este projeto), XAMPP, WAMP ou MAMP.
    * Um navegador web moderno (Google Chrome, Mozilla Firefox, Microsoft Edge, etc.).

2.  **Preparar o USBWebserver:**
    * Baixe e instale o [USBWebserver](https://www.usbwebserver.net/) (se ainda não o tiver).
    * Inicie o USBWebserver e certifique-se de que os serviços **Apache** e **MySQL** estejam em execução.

3.  **Configurar o Banco de Dados MySQL:**
    * Acesse a interface do **phpMyAdmin** em seu navegador, geralmente através de `http://localhost/phpmyadmin/`.
    * No phpMyAdmin, clique em "Nova" ou "Databases" e **crie um novo banco de dados** com o nome exato: `inventario_minecraft`.
    * Com o banco de dados `inventario_minecraft` selecionado, vá para a aba "SQL" e execute os seguintes comandos SQL para criar as tabelas necessárias:

    ```sql
    -- Criação da Tabela 'usuarios' para armazenar informações de login
    CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL
        -- Importante: Em um projeto real, a senha DEVE ser armazenada usando password_hash() para segurança.
    );

    -- Criação da Tabela 'inventario' para armazenar os itens de cada usuário
    CREATE TABLE inventario (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,           -- Chave estrangeira para vincular o item a um usuário
        nome_item VARCHAR(255) NOT NULL,
        quantidade INT NOT NULL DEFAULT 1,
        descricao TEXT,
        data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        -- ON DELETE CASCADE: Se um usuário for excluído, seus itens de inventário também serão.
    );
    ```

4.  **Posicionar os Arquivos do Projeto:**
    * Baixe o código-fonte deste projeto.
    * Extraia a pasta `minecraft_inventario` diretamente para o diretório `www` do seu USBWebserver.
        * Ex: `C:\USBWebserver_V8.6\root\www\minecraft_inventario\`

5.  **Verificar a Conexão com o Banco de Dados:**
    * Abra o arquivo `includes/conexao.php`.
    * Confirme se as credenciais (`$servidor`, `$usuario`, `$senha`, `$banco`) correspondem às suas configurações do MySQL no USBWebserver (geralmente `root` para usuário e senha vazia).

## Como Utilizar a Aplicação

1.  Com o USBWebserver (Apache e MySQL) em execução, abra seu navegador web.
2.  Digite a URL para acessar o projeto: `http://localhost/minecraft_inventario/`.
3.  Você será direcionado para a **Página de Login/Cadastro**.
    * **Para novos usuários:** Clique na aba "Cadastre-se", preencha os dados e clique em "Cadastrar". Uma mensagem de sucesso aparecerá.
    * **Para usuários existentes:** Clique na aba "Login", insira seu email e senha e clique em "Entrar".
4.  Após o login bem-sucedido, você será levado para a **Página do Inventário (`inventario.php`)**.
5.  Nesta página, você pode:
    * **Adicionar um novo item:** Clique no botão "Adicionar Item", preencha o nome, quantidade e descrição. Se o item já existir, sua quantidade será atualizada.
    * **Visualizar itens:** Todos os seus itens cadastrados serão listados em uma tabela.
    * **Editar um item:** Clique no botão "Editar" ao lado do item desejado para ir para a página de edição, faça as alterações e salve.
    * **Excluir um item:** Clique no botão "Excluir" ao lado do item. Uma caixa de diálogo de confirmação aparecerá.
    * **Sair da sessão:** Clique no botão "Sair" para fazer logout e retornar à página inicial.

## Melhorias e Próximos Passos (Sugestões)

Este projeto serve como uma base funcional. Para um ambiente de produção ou para aprimoramento contínuo, as seguintes melhorias são altamente recomendadas:

* **Segurança de Senhas:** Implementar a função `password_hash()` para criptografar senhas antes de armazená-las no banco de dados e `password_verify()` para autenticação.
* **Prevenção de SQL Injection:** Converter todas as consultas SQL que recebem dados do usuário para **Prepared Statements** (usando MySQLi ou PDO) para prevenir ataques de injeção de SQL, tornando o método `escapar()` obsoleto para esta finalidade.
* **Validação Robusta:** Adicionar validação de dados tanto no lado do cliente (JavaScript) quanto no lado do servidor (PHP) para garantir a integridade dos dados e melhorar a experiência do usuário.
* **Tratamento de Erros:** Implementar um sistema de log de erros mais sofisticado e exibir mensagens de erro amigáveis ao usuário, sem expor detalhes internos do sistema.
* **Design Responsivo:** Aprimorar o design para garantir uma ótima experiência em diferentes tamanhos de tela (dispositivos móveis, tablets, desktops).
* **CSS Limpo e Organizado:** Considerar o uso de metodologias CSS (BEM, SMACSS) para projetos maiores.
* **Funcionalidades Adicionais:**
    * Implementar uma barra de pesquisa para itens do inventário.
    * Adicionar filtros e opções de ordenação para a lista de itens.
    * Permitir que usuários carreguem imagens para seus itens.
    * Funcionalidade de "troca" de itens entre usuários.
* **Refatoração do Código:** Para um projeto maior, considerar a adoção de um padrão de arquitetura (como MVC) ou o uso de um framework PHP (Laravel, Symfony) para organizar melhor o código.

---