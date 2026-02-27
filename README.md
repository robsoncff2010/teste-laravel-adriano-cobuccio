📊 Finance Dashboard
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center"><a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a></p>

🚀 Sobre o Projeto
O Finance Dashboard é uma aplicação desenvolvida em Laravel para gerenciamento financeiro.
Ele permite realizar depósitos, transferências, acompanhar o saldo e visualizar o histórico de transações.
A interface é limpa e intuitiva, com gráficos e tabelas que ajudam o usuário a acompanhar sua evolução financeira em tempo real.

Além disso, o projeto conta com:

- 🌗 Mudança de tema (claro/escuro), oferecendo melhor experiência visual.
- 🌍 Tradução (i18n), permitindo suporte a múltiplos idiomas.

🛠 Tecnologias Utilizadas
Backend
- PHP 8.5
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
- PHPUnit (testes automatizados)
- Docker (containerização do ambiente)  
  - App (Laravel/PHP-FPM) → porta 8000  
  - Nginx (proxy reverso)  
  - Vite (build frontend)  
  - MySQL (banco de dados)

📂 Estrutura do Projeto
- Repositories → consultas ao banco de dados (TransactionRepository)
- Services → lógica de negócio (DashboardService)
- Models → entidades principais (Transaction, Transfer, User)
- Blade Components → componentes reutilizáveis (x-nav-link, x-dropdown)
- Routes → organizadas sob finance.* (deposit, transfer, history)

📊 Funcionalidades
- Dashboard
    - Exibe saldo atual, entradas, saídas e total de transações.
    - Mostra gráficos de distribuição (depósitos x transferências) e evolução do saldo.
    - Lista as últimas transações com status (Concluída, Revertida, etc.).
- Depósitos
    - Tela para adicionar valores à carteira.
    - Atualiza automaticamente o saldo e os gráficos.
- Transferências
    - Permite enviar valores para outros usuários.
    - Mostra remetente, destinatário e status da operação.
- Histórico de Transações
    - Tabela completa com todas as transações realizadas.
    - Filtros por tipo, data e status.
    - Opção de reverter depósitos diretamente pela interface.
    - Solicitação de reversão em transferências, permitindo que o usuário peça a reversão e acompanhe o status.
- Perfil do Usuário
    - Gerenciamento de dados pessoais.
    - Opção de logout e edição de informações.
- Tema Claro/Escuro 
    - Alternância entre modo claro e escuro para melhor experiência visual.
- Tradução (i18n)
    - Suporte a múltiplos idiomas via __('messages.*').

📌 Fluxo da Arquitetura
Controller → Service → Repository → Model → Database

- Controller: recebe requisições HTTP e chama os serviços.
- Service: agrega e prepara os dados para a view.
- Repository: executa consultas e formata os resultados.
- Model: representa entidades e relacionamentos.
- Database: armazena transações, transferências e usuários.

🧪 Testes Automatizados
O projeto inclui testes básicos utilizando **PHPUnit**, cobrindo:
- **Login de usuário** → valida credenciais e autenticação.  
- **Depósitos** → garante que o saldo é atualizado corretamente após a operação. 

▶️ Como Executar
Clonar o repositório
- git clone https://github.com/seu-repo.git

▶️ Executando com Docker

Subir os containers
 - docker compose up -d --build

Gerar chave
 - docker compose exec app php artisan key:generate

Criar migrations
 - docker compose exec app php artisan migrate

Limpar caches
 - docker compose exec app php artisan config:clear
 - docker compose exec app php artisan cache:clear
 - docker compose exec app php artisan route:clear

Criar permissoes
 - docker compose exec app mkdir -p storage/logs
 - docker compose exec app chown -R www-data:www-data storage bootstrap/cache
 - docker compose exec app chmod -R 775 storage bootstrap/cache

Reiniciar Nginx
 - docker compose restart nginx

Acessar o app (porta configurada no docker-compose)
- http://localhost:8000

📜 Licença
Este projeto está licenciado sob a MIT License, permitindo uso, modificação e distribuição, desde que seja mantida a nota de licença original.
