#  Gestão de Ativos - Desafio Técnico

Sistema completo para controle de inventário de hardware, permitindo o gerenciamento de modelos, rastreio de ativos e histórico detalhado de movimentações entre colaboradores.

---

##  Requisitos do Projeto
Para garantir a transparência na avaliação, este projeto contempla 100% dos requisitos solicitados:

### **Backend (Laravel 12)**
* **API REST**: Desenvolvida seguindo os padrões RESTful com retornos em JSON.
* **Banco de Dados**: MySQL com relacionamentos entre Ativos, Produtos e Colaboradores.
* **CRUDs**: Implementação completa para Produtos, Ativos e Colaboradores.
* **Movimentações**: Registro de entrega e devolução com data/hora, motivo e usuário responsável.
* **Autenticação**: Proteção de rotas via Laravel Sanctum (Token-based).

### **Frontend (Vue 3)**
* **Arquitetura**: Utilização de Vue 3 com Composition API e reatividade (`v-model`, `v-for`, `v-if`).
* **Consumo de API**: Integração completa via Axios com tratamento de erros.
* **Interface**: Telas de login, cadastros e painel de histórico de movimentações.

---

##  Tecnologias Utilizadas
* **Backend**: PHP 8.2+ / Laravel 12.
* **Frontend**: Vue.js 3 / Axios.
* **Banco de Dados**: MySQL.
* **Autenticação**: Laravel Sanctum.

---

##  Instruções de Execução
Siga os passos abaixo para rodar a aplicação em seu ambiente local.

### 1. Requisitos Prévios
* PHP 8.2 ou superior.
* Node.js e NPM.
* MySQL rodando.

### 2. Configuração do Backend
1. Acesse a pasta do backend: `cd backend`
2. Instale as dependências: `composer install`
3. Configure o arquivo `.env` (certifique-se de configurar as credenciais do seu banco MySQL).
4. Gere a chave da aplicação: `php artisan key:generate`
5. Execute as migrations para criar as tabelas: `php artisan migrate --seed`.
6. Inicie o servidor: `php artisan serve`

### 3. Configuração do Frontend
1. Acesse a pasta do frontend: `cd frontend`
2. Instale as dependências: `npm install`
3. Inicie o servidor de desenvolvimento: `npm run dev`

---

##  Credenciais de Acesso (Teste)
O sistema conta com autenticação obrigatória para acessar as funcionalidades de gestão.

* **E-mail**: `admin@teste.com`
* **Senha**: `123456`

---

##  Estrutura do Banco de Dados
A aplicação utiliza um modelo relacional para garantir a integridade dos dados:

* **Produtos (Modelos)**: Armazena a marca e o modelo do equipamento.
* **Ativos**: Registra a unidade física, número de série e o colaborador atual.
* **Movimentações**: Tabela de histórico que registra cada troca de posse, garantindo a rastreabilidade.



---

**Desenvolvido por**: Gabriel Vieira  
**Objetivo**: Desafio Técnico para Desenvolvedor Fullstack.