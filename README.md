📊 Finance Dashboard
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center"><a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a></p>

🚀 Sobre o Projeto
O Finance Dashboard é uma aplicação desenvolvida em Laravel para gerenciamento financeiro.
Ele permite realizar depósitos, transferências, acompanhar o saldo e visualizar o histórico de transações.
A interface é limpa e intuitiva, com gráficos e tabelas que ajudam o usuário a acompanhar sua evolução financeira em tempo real.

🛠 Tecnologias Utilizadas
Backend
- PHP 8.2
- Laravel 12
- Eloquent ORM (modelos e relacionamentos)
- MySQL (banco de dados)
Frontend
- Blade Templates (engine de views do Laravel)
- Tailwind CSS (framework CSS utilitário)
- Alpine.js (interatividade leve, menus/dropdowns)
- Chart.js (gráficos de dados)
Infraestrutura
- Composer (gerenciador de dependências PHP)
- NPM (gerenciador de pacotes frontend)
- Vite (bundler para assets JS/CSS)
- Laravel Breeze (autenticação e scaffolding inicial)

📂 Estrutura do Projeto
- Repositories → consultas ao banco de dados (TransactionRepository)
- Services → lógica de negócio (DashboardService)
- Models → entidades principais (Transaction, Transfer, User)
- Blade Components → componentes reutilizáveis (x-nav-link, x-dropdown)
- Routes → organizadas sob finance.* (deposit, transfer, history)

📊 Funcionalidades
- 💰 Cálculo de saldo (depósitos – transferências enviadas)
- 📈 Gráficos de entradas e saídas mensais
- 🔄 Histórico de transações (com remetente, destinatário e status)
- 📊 Dashboard com últimas transações
- 🔐 Autenticação e gerenciamento de perfil de usuário
- 📂 Menus dropdown para Financeiro e Usuário, consistentes com Breeze

📌 Fluxo da Arquitetura
Controller → Service → Repository → Model → Database


- Controller: recebe requisições HTTP e chama os serviços.
- Service: agrega e prepara os dados para a view.
- Repository: executa consultas e formata os resultados.
- Model: representa entidades e relacionamentos.
- Database: armazena transações, transferências e usuários.

▶️ Como Executar
# Clonar o repositório
git clone https://github.com/seu-repo.git

# Instalar dependências PHP
composer install

# Instalar dependências frontend
npm install && npm run dev

# Rodar migrações
php artisan migrate

# Iniciar servidor local
php artisan serve



📜 Licença
Este projeto está licenciado sob a MIT License, permitindo uso, modificação e distribuição, desde que seja mantida a nota de licença original.