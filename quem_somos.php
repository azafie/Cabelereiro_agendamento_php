<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Somos - Salão de Beleza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .hero {
            background: linear-gradient(to right,rgb(206, 173, 245), #7B68EE);
            color: #fff;
            text-align: center;
            padding: 3rem 1rem;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
        }
        .content {
            padding: 2rem 1rem;
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
        .content h2 {
            color: #7B68EE;
            margin-bottom: 1rem;
        }
        .content p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php
    // Dados do salão de beleza
    $nomeSalao = "Marlene";
    $tempoTrabalho = 10; // Tempo de trabalho em anos
    ?>

    <div class="container">
        <!-- Seção de destaque -->
        <div class="hero">
            <h1>Bem-vindo ao <?php echo $nomeSalao; ?>!</h1>
            <p>Transformando beleza e bem-estar há mais de <?php echo $tempoTrabalho; ?> anos.</p>
        </div>

        <!-- Conteúdo principal -->
        <div class="content">
            <h2>Quem Somos</h2>
            <p>
                No <strong><?php echo $nomeSalao; ?></strong>, acreditamos que a beleza vai além da estética. 
                Nossa missão é oferecer experiências únicas e transformadoras para nossos clientes, promovendo bem-estar e autoestima.
            </p>
            <p>
                Com mais de <?php echo $tempoTrabalho; ?> anos de experiência no mercado, somos especialistas em cortes de cabelo, coloração, tratamentos capilares e muito mais. 
                Nossa equipe altamente qualificada está sempre atualizada com as últimas tendências e técnicas para garantir um serviço de excelência.
            </p>
            <p>
                Venha nos visitar e descubra porque somos referência em beleza e cuidado. Estamos ansiosos para atendê-lo!
            </p>
        </div>
    </div>
</body>
</html>
