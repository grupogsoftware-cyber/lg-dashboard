# LG Electronics - Dashboard de Eficiência de Produção

Aplicação desenvolvida em **Laravel 7** para apresentação da eficiência de produção da **Planta A** da LG Electronics, considerando as linhas de produto:

- Geladeira
- Máquina de Lavar
- TV
- Ar-Condicionado

O dashboard apresenta uma visão consolidada dos dados simulados para o mês de **janeiro de 2026**, permitindo análise geral e filtrada por linha de produção.

---

## Objetivo

Disponibilizar um dashboard simples, claro e objetivo para acompanhamento dos seguintes indicadores por linha de produção:

- Linha do produto
- Quantidade produzida
- Quantidade de defeitos
- Eficiência (%)

---

## Stack utilizada

- **Backend:** Laravel 7
- **Linguagem:** PHP 7.4
- **Banco de Dados:** MySQL 8
- **Frontend:** Blade + Bootstrap + JavaScript
- **Gráfico:** Chart.js
- **Ambiente local:** Docker

---

## Funcionalidades

- Dashboard com visão consolidada de todas as linhas
- Filtro por linha de produção
- Cards com indicadores gerais
- Tabela com resumo por linha
- Gráfico de eficiência por linha
- Dados simulados via seeder

---

## Fórmula de eficiência adotada

Para representar a eficiência de produção de forma coerente, foi adotada a seguinte fórmula:

```text
((quantidade_produzida - quantidade_defeitos) / quantidade_produzida) * 100
```

Essa abordagem representa a proporção de itens produzidos sem defeito dentro do período analisado.

---

## Estrutura da tabela

Tabela utilizada: `production_records`

### Campos

- `id`
- `product_line` → nome da linha de produção
- `production_date` → data da produção
- `quantity_produced` → quantidade produzida no dia
- `quantity_defects` → quantidade de defeitos no dia
- `created_at`
- `updated_at`

---

## Exemplo de dados simulados

Os dados foram gerados por seeder para os 31 dias do mês de janeiro de 2026, contemplando as quatro linhas da Planta A.

```sql
INSERT INTO production_records (product_line, production_date, quantity_produced, quantity_defects, created_at, updated_at)
VALUES
('Geladeira', '2026-01-01', 1200, 25, NOW(), NOW()),
('Máquina de Lavar', '2026-01-01', 980, 18, NOW(), NOW()),
('TV', '2026-01-01', 1450, 42, NOW(), NOW()),
('Ar-Condicionado', '2026-01-01', 870, 15, NOW(), NOW());
```

---

## Dump do banco de dados

Além das migrations e seeders, o projeto também disponibiliza um arquivo `.sql` com a estrutura e os dados simulados do banco para facilitar validação e importação manual, se necessário.

Arquivo:

```text
lg_dashboard.sql

O arquivo .sql foi incluído como recurso complementar para apoiar a avaliação técnica.
```

---

## Como executar o projeto localmente

### 1. Clonar o repositório

```bash
git clone <https://github.com/grupogsoftware-cyber/lg-dashboard.git>
cd lg-dashboard
```

### 2. Subir os containers

```bash
docker compose up -d --build
```

### 3. Instalar dependências do Laravel

Caso necessário:

```bash
docker compose exec app composer install
```

### 4. Configurar o arquivo `.env`

O arquivo `src/.env` deve conter as credenciais abaixo:

```env
APP_NAME="LG Dashboard"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=lg_dashboard
DB_USERNAME=lg_user
DB_PASSWORD=root
```

### 5. Gerar chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

### 6. Rodar migrations e seeders

```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 7. Subir o servidor Laravel

```bash
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

### 8. Acessar a aplicação

```text
http://localhost:8000
```

---

## Estrutura resumida do projeto

```text
lg-dashboard/
├── docker-compose.yml
├── Dockerfile
├── README.md
├── .gitignore
└── src/
    ├── app/
    │   ├── Http/Controllers/DashboardController.php
    │   └── ProductionRecord.php
    ├── database/
    │   ├── migrations/
    │   └── seeds/
    ├── resources/views/dashboard.blade.php
    ├── routes/web.php
    └── ...
```

---

## Observações

- Os dados são simulados e representam o mês de janeiro de 2026.
- O projeto foi construído com foco em clareza, simplicidade e organização do código.
- A interface foi pensada para apresentar os dados de forma objetiva, com visual corporativo e leitura rápida.

---

## Autor: Genilson de Oliveira Silva - Engenheiro de Software - 12.98303-0650 - ge_engenharia@hotmail.com.

Desenvolvido como desafio técnico para processo seletivo.
