# 🍽️ GestorCheff

Um sistema de **gestão culinária** desenvolvido em **PHP** — ideal para organizar receitas, ingredientes, pedidos e mais!  
Este projeto foi criado com foco em praticidade, usabilidade e fácil instalação, utilizando o ambiente **XAMPP**.

---

## 🧾 Sobre o Projeto

O **GestorCheff** é um sistema que permite gerenciar processos de cozinha e restaurante de forma simples.  
Você pode cadastrar receitas, acompanhar estoque, gerenciar usuários e muito mais — tudo em um painel intuitivo.

---

## ⚙️ Tecnologias Utilizadas

- 🐘 **PHP** 8+
- 🐬 **MySQL** (via **phpMyAdmin**)
- 🌐 **HTML5 / CSS3 / JavaScript**
- 💻 **XAMPP** (Apache + MySQL)
- 📦 **Bootstrap** (para o layout responsivo)

---

## 🚀 Como Instalar

### 🧰 Pré-requisitos

Antes de tudo, instale o **[XAMPP](https://www.apachefriends.org/pt_br/index.html)** (ou outro servidor PHP/MySQL de sua preferência).

### 🔧 Passos para rodar o projeto

1. **Baixe o projeto:**
   ```bash
   git clone https://github.com/seu-usuario/gestorcheff.git
   ```
   ou extraia o arquivo `.zip` dentro da pasta `htdocs` do XAMPP.

2. **Inicie o XAMPP:**
   - Abra o painel do XAMPP;
   - Ative os módulos **Apache** e **MySQL**.

3. **Importe o banco de dados:**
   - Acesse [http://localhost/phpmyadmin](http://localhost/phpmyadmin);
   - Crie um banco de dados com o nome `gestorcheff`;
   - Vá até a aba **Importar** e selecione o arquivo SQL que está em:
     ```
     /db/gestorcheff.sql
     ```
   - Clique em **Executar**.

4. **Acesse o sistema:**
   Abra o navegador e digite:
   ```
   http://localhost/gestorcheff
   ```

---

## 📂 Estrutura do Projeto

```
gestorcheff/
│
├── db/                 # Contém o arquivo SQL do banco de dados
├── assets/             # Imagens, ícones e estilos
├── includes/           # Conexões e funções PHP auxiliares
├── pages/              # Páginas principais do sistema
├── index.php           # Página inicial
└── README.md           # Este arquivo
```

---

## 💾 Banco de Dados

O arquivo SQL está localizado em:
```
/db/gestorcheff.sql
```
Basta importá-lo no **phpMyAdmin** para criar automaticamente todas as tabelas necessárias.  
⚠️ **Importante:** verifique se o nome do banco de dados no seu arquivo de conexão PHP corresponde ao nome criado no MySQL.

---

## 🧠 Funcionalidades (Exemplo)

- ✅ Cadastro e edição de receitas  
- 🧾 Controle de estoque  
- 👨‍🍳 Gerenciamento de usuários  
- 📊 Relatórios e estatísticas  
- 🔐 Login seguro com controle de acesso  

---

## 👨‍💻 Autor

**José Otávio dos Santos Miguel**  
📧 Email: *joseotavio_m@hotmail.com*  
💼 [LinkedIn]([https://linkedin.com/in/seu-perfil](https://www.linkedin.com/in/josé-otávio-dos-santos-miguel-31a952322)) | 🐙 [GitHub](https://github.com/JoseOtavio-Miguel)

---

## ⭐ Dê um apoio!

Se este projeto te ajudou, deixe uma ⭐ no repositório e contribua com melhorias!

---

> Feito com ❤️ e muito café ☕ por **José Otávio dos Santos Miguel**
