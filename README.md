# BakeryApp - Configuração do Ambiente

Este guia descreve os passos necessários para configurar o ambiente de desenvolvimento utilizando **XAMPP** e criar a base de dados para o projeto **Bakery**.

---

## ⚙️ Instalação do XAMPP

1. Instalar o [XAMPP](https://www.apachefriends.org/).
2. Após a instalação, executar o **XAMPP Control Panel**.

### Serviços Principais
- **Apache**: responsável por disponibilizar o website.  
  - Pode ser iniciado no botão **Start**.  
  - Aceder ao website através de:  
    ```
    http://localhost/
    ```
  - Também pode ser acedido através do botão **Admin**.

- **MySQL**: redireciona para a ferramenta **phpMyAdmin**, usada para gerir a base de dados.  
  - Pode ser iniciado no botão **Start**.  
  - Aceder a:  
    ```
    http://localhost/phpmyadmin/
    ```
  - Também pode ser acedido através do botão **Admin**.

---

## 🗄️ Criação da Base de Dados

No **phpMyAdmin**:

1. Ir ao separador **Databases**.
2. Em **Create Database**, definir o nome: db_bakery
3. Clicar em **Create**.

De seguida será possível criar as tabelas necessárias para o projeto.

---

## 📑 Estrutura das Tabelas

### 🔹 produto
- `cod_produto` (INT, PK, A_I) → Identificador único  
- `nome` (VARCHAR(255)) → Nome do produto  
- `composicao` (VARCHAR(255)) → Composição  
- `preco` (FLOAT) → Preço  
- `taxaIVA` (INT) → Taxa de IVA praticada  

---

### 🔹 rota
- `cod_rota` (INT, PK, A_I) → Identificador único  
- `nome` (VARCHAR(255)) → Nome da rota  
- `distribuidor` (VARCHAR(255)) → Nome do distribuidor  
*(Agrupa pontos de entrega)*  

---

### 🔹 ponto_entrega
- `cod_pe` (INT, PK, A_I) → Identificador único  
- `cod_rota` (INT, FK) → Código da rota  
- `nome` (VARCHAR(255)) → Nome do ponto de entrega  
- `morada` (VARCHAR(255)) → Morada do ponto de entrega  
- `data_criacao` (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP) → Data da criação  
*(Informações sobre os locais de entrega das encomendas)*  

---

### 🔹 encomenda
- `cod_ne` (INT, PK, A_I) → Identificador único  
- `cod_pe` (INT, FK) → Código do ponto de entrega  
- `nome_cliente` (VARCHAR(255)) → Nome do cliente  
- `NIF` (INT) → NIF do cliente  
- `Data_` (TEXT) → Data da encomenda  
*(Informações relevantes sobre uma encomenda)*  

---

### 🔹 linha_ne
- `cod_linha` (INT, PK, A_I) → Identificador único  
- `cod_ne` (INT, FK) → Código da encomenda  
- `cod_produto` (INT, FK) → Código do produto  
- `quantidade` (INT) → Quantidade do produto  
*(Associa encomendas a produtos e respetivas quantidades)*  

---

## 👤 Criação de Utilizador no MySQL

No separador **User accounts**:

1. Clicar em **Add user account**.
2. Definir os seguintes parâmetros:
- **UserName**: `tomorais`  
- **Hostname**: `localhost`  
- **Password**: `morais123`  
3. Assinalar **Check All** em *Global Privileges*.  

👉 Caso seja utilizado outro utilizador ou password, atualizar as credenciais no ficheiro:












1. Ir ao separador **Databases**.
2. Em **Create Database**, definir o nome
