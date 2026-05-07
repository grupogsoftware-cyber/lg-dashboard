
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LG Electronics - Dashboard de Produção</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .navbar-custom {
            background: #ffffff;
            border-bottom: 4px solid #a50034;
        }

        .navbar-brand {
            color: #a50034 !important;
            font-weight: bold;
            font-size: 1.4rem;
        }

        .page-title {
            font-weight: 700;
            color: #333;
        }

        .card-summary {
            border: none;
            border-left: 5px solid #a50034;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 10px;
        }

        .card-summary h6 {
            color: #666;
            margin-bottom: 10px;
        }

        .card-summary h3 {
            color: #222;
            font-weight: bold;
            margin: 0;
        }

        .btn-lg-red {
            background-color: #a50034;
            color: #fff;
            border: none;
        }

        .btn-lg-red:hover {
            background-color: #87002a;
            color: #fff;
        }

        .card-default {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 10px;
        }

        .table thead th {
            background-color: #a50034;
            color: #fff;
            border-color: #a50034;
        }

        .filter-label {
            font-weight: 600;
        }

        .footer-note {
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom mb-4">
        <div class="container">
            <span class="navbar-brand">LG Electronics | Planta A</span>
        </div>
    </nav>

    <div class="container">
        <div class="mb-4">
            <h2 class="page-title">Dashboard de Eficiência de Produção — Planta A</h2>
            <p class="text-muted mb-0">Monitoramento consolidado da eficiência das linhas Geladeira, Máquina de Lavar, TV e Ar-Condicionado no período de janeiro de 2026.</p>
        </div>

        <div class="card card-default p-3 mb-4">
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="product_line" class="filter-label">Filtrar por linha de produção</label>
                        <select name="product_line" id="product_line" class="form-control">
                            <option value="">Todas as linhas</option>
                            @foreach($allLines as $line)
                                <option value="{{ $line }}" {{ $selectedLine == $line ? 'selected' : '' }}>
                                    {{ $line }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-lg-red btn-block">Filtrar</button>
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-block">Limpar</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card card-summary">
                    <div class="card-body">
                        <h6>Total Produzido</h6>
                        <h3>{{ number_format($summaryProduced, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-summary">
                    <div class="card-body">
                        <h6>Total de Defeitos</h6>
                        <h3>{{ number_format($summaryDefects, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-summary">
                    <div class="card-body">
                        <h6>Eficiência Geral</h6>
                        <h3>{{ number_format($summaryEfficiency, 2, ',', '.') }}%</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default mb-4">
            <div class="card-body">
                <h5 class="mb-3">Eficiência por Linha</h5>
                <canvas id="efficiencyChart" height="100"></canvas>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-body">
                <h5 class="mb-3">Indicadores Consolidados por Linha de Produto</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Linha do Produto</th>
                                <th>Quantidade Produzida</th>
                                <th>Quantidade de Defeitos</th>
                                <th>Eficiência (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                <tr>
                                    <td>{{ $record->product_line }}</td>
                                    <td>{{ number_format($record->total_produced, 0, ',', '.') }}</td>
                                    <td>{{ number_format($record->total_defects, 0, ',', '.') }}</td>
                                    <td>{{ number_format($record->efficiency, 2, ',', '.') }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum dado encontrado para o filtro selecionado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="alert alert-light border mb-4" role="alert">
            <strong>Período analisado:</strong> 01/01/2026 a 31/01/2026
        </div>

        <div class="mt-3 mb-5 footer-note">
            Eficiência calculada considerando a proporção de itens produzidos sem defeito no período analisado.
        </div>
    </div>

    <script>
        const labels = [
            @foreach($records as $record)
                "{{ $record->product_line }}",
            @endforeach
        ];

        const efficiencies = [
            @foreach($records as $record)
                {{ $record->efficiency }},
            @endforeach
        ];

        const chartElement = document.getElementById('efficiencyChart');

        if (chartElement && labels.length > 0) {
            const ctx = chartElement.getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Eficiência (%)',
                        data: efficiencies,
                        backgroundColor: '#a50034'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: 100
                            }
                        }]
                    }
                }
            });
        }
    </script>
</body>
</html>
