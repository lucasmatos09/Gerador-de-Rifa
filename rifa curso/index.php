<?php
// Recebe os dados do formulário via POST
$campanha    = isset($_POST['campanha'])    ? htmlspecialchars(trim($_POST['campanha']))    : '';
$premios     = isset($_POST['premios'])     ? htmlspecialchars(trim($_POST['premios']))     : '';
$valor       = isset($_POST['valor'])       ? htmlspecialchars(trim($_POST['valor']))       : '';
$quantidade  = isset($_POST['quantidade'])  ? (int)$_POST['quantidade']                   : 0;
$gerar       = isset($_POST['gerar']);

// Validações básicas
$erros = [];
if ($gerar) {
    if (empty($campanha))   $erros[] = "Informe o nome da campanha/rifa.";
    if (empty($premios))    $erros[] = "Informe o(s) prêmio(s) da rifa.";
    if (empty($valor))      $erros[] = "Informe o valor do bilhete.";
    if ($quantidade < 1 || $quantidade > 999)
        $erros[] = "A quantidade deve ser entre 1 e 999 bilhetes.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎟️ Gerador de Rifas</title>
    <style>
        /* ========== RESET & BASE ========== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            padding: 30px 15px;
        }

        /* ========== CABEÇALHO ========== */
        .header {
            text-align: center;
            margin-bottom: 35px;
        }
        .header h1 {
            font-size: 2.8rem;
            color: #f5c518;
            text-shadow: 0 0 20px rgba(245,197,24,0.5);
            letter-spacing: 2px;
        }
        .header p {
            color: #a0aec0;
            margin-top: 8px;
            font-size: 1rem;
        }

        /* ========== CONTAINER FORMULÁRIO ========== */
        .form-container {
            max-width: 600px;
            margin: 0 auto 40px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(245,197,24,0.3);
            border-radius: 18px;
            padding: 35px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .form-container h2 {
            color: #f5c518;
            font-size: 1.4rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #e2e8f0;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 7px;
            letter-spacing: 0.5px;
        }
        .form-group label span.req {
            color: #fc8181;
            margin-left: 3px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(245,197,24,0.25);
            border-radius: 10px;
            color: #f7fafc;
            font-size: 0.95rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            outline: none;
        }
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #718096;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #f5c518;
            box-shadow: 0 0 0 3px rgba(245,197,24,0.15);
        }
        .form-group select option { background: #1a1a2e; }
        .form-group textarea { resize: vertical; min-height: 80px; }

        .input-icon-wrap {
            position: relative;
        }
        .input-icon-wrap .prefix {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #f5c518;
            font-weight: bold;
            font-size: 0.95rem;
        }
        .input-icon-wrap input {
            padding-left: 38px;
        }

        /* ========== ERROS ========== */
        .erros {
            background: rgba(252,129,129,0.12);
            border: 1px solid rgba(252,129,129,0.5);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 22px;
        }
        .erros p {
            color: #fc8181;
            font-size: 0.88rem;
            margin: 3px 0;
        }
        .erros p::before { content: "⚠ "; }

        /* ========== BOTÃO GERAR ========== */
        .btn-gerar {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f5c518, #e6a800);
            color: #1a1a2e;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 1px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(245,197,24,0.35);
        }
        .btn-gerar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(245,197,24,0.5);
        }
        .btn-gerar:active { transform: translateY(0); }

        /* ========== RESUMO DA RIFA ========== */
        .resumo {
            max-width: 860px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, rgba(245,197,24,0.12), rgba(245,197,24,0.04));
            border: 1px solid rgba(245,197,24,0.4);
            border-radius: 18px;
            padding: 28px 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .resumo h2 {
            color: #f5c518;
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .resumo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 15px;
        }
        .resumo-item {
            background: rgba(0,0,0,0.25);
            border-radius: 10px;
            padding: 14px 18px;
            text-align: center;
        }
        .resumo-item .label {
            color: #a0aec0;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .resumo-item .value {
            color: #f5c518;
            font-size: 1.05rem;
            font-weight: 700;
        }

        /* ========== BARRA DE AÇÕES ========== */
        .barra-acoes {
            max-width: 860px;
            margin: 0 auto 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .btn-imprimir {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 13px 30px;
            background: linear-gradient(135deg, #38b2ac, #2c7a7b);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 18px rgba(56,178,172,0.4);
            letter-spacing: 0.5px;
        }
        .btn-imprimir:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(56,178,172,0.55);
        }
        .btn-voltar {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 13px 30px;
            background: rgba(255,255,255,0.08);
            color: #e2e8f0;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-voltar:hover { background: rgba(255,255,255,0.15); }

        /* ========== GRID DE BILHETES ========== */
        .bilhetes-titulo {
            max-width: 860px;
            margin: 0 auto 18px;
            color: #e2e8f0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .bilhetes-titulo strong { color: #f5c518; }

        .bilhetes-grid {
            max-width: 860px;
            margin: 0 auto 40px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
        }

        /* ========== BILHETE INDIVIDUAL ========== */
        .bilhete {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.35);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .bilhete:hover {
            transform: translateY(-4px) rotate(0.5deg);
            box-shadow: 0 14px 35px rgba(0,0,0,0.5);
        }

        /* Topo colorido do bilhete */
        .bilhete-topo {
            background: linear-gradient(135deg, #e63946, #c1121f);
            padding: 10px 14px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .bilhete-topo .campanha-nome {
            color: #fff;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .bilhete-topo .estrelas {
            color: #f5c518;
            font-size: 0.75rem;
            letter-spacing: 2px;
        }

        /* Corpo principal */
        .bilhete-corpo {
            padding: 12px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .bilhete-numero {
            font-size: 2.6rem;
            font-weight: 900;
            color: #1a1a2e;
            letter-spacing: 4px;
            text-align: center;
            font-family: 'Courier New', monospace;
            line-height: 1;
            padding: 6px 0;
        }
        .bilhete-divider {
            border: none;
            border-top: 2px dashed #e2e8f0;
            margin: 4px 0;
        }
        .bilhete-premio-label {
            font-size: 0.62rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .bilhete-premio {
            font-size: 0.8rem;
            color: #2d3748;
            font-weight: 700;
            line-height: 1.3;
        }

        /* Rodapé do bilhete */
        .bilhete-rodape {
            background: #1a1a2e;
            padding: 8px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .bilhete-rodape .valor-label {
            color: #a0aec0;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .bilhete-rodape .valor {
            color: #f5c518;
            font-size: 1rem;
            font-weight: 800;
        }
        .bilhete-rodape .assinatura {
            color: #718096;
            font-size: 0.62rem;
            text-align: right;
            line-height: 1.4;
        }

        /* Faixa diagonal "SORTE!" */
        .bilhete-badge {
            position: absolute;
            top: 12px;
            right: -22px;
            background: #f5c518;
            color: #1a1a2e;
            font-size: 0.55rem;
            font-weight: 900;
            letter-spacing: 1px;
            padding: 3px 28px;
            transform: rotate(35deg);
            text-transform: uppercase;
        }

        /* ========== RODAPÉ DA PÁGINA ========== */
        .page-footer {
            text-align: center;
            color: #4a5568;
            font-size: 0.8rem;
            margin-top: 10px;
            padding-bottom: 20px;
        }

        /* ========== ÁREA DE IMPRESSÃO ========== */
        @media print {
            body {
                background: #fff !important;
                padding: 10px;
            }
            .form-container,
            .barra-acoes,
            .bilhetes-titulo,
            .header { display: none !important; }

            .resumo {
                background: #f8f8f8 !important;
                border: 2px solid #ccc !important;
                box-shadow: none !important;
                color: #000 !important;
                margin-bottom: 20px !important;
            }
            .resumo h2, .resumo-item .value { color: #000 !important; }
            .resumo-item .label { color: #555 !important; }
            .resumo-item { background: #fff !important; border: 1px solid #ddd !important; }

            .bilhetes-grid {
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 10px !important;
                max-width: 100% !important;
            }
            .bilhete {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .bilhete:hover { transform: none !important; }
            .bilhete-topo { background: #c1121f !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bilhete-rodape { background: #1a1a2e !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page-footer { display: none !important; }
        }
    </style>
</head>
<body>

<!-- ========== CABEÇALHO ========== -->
<div class="header">
    <h1>🎟️ Gerador de Rifas</h1>
    <p>Crie seus bilhetes de rifa numerados de forma rápida e profissional</p>
</div>

<?php if (!$gerar || !empty($erros)): ?>
<!-- ========== FORMULÁRIO ========== -->
<div class="form-container">
    <h2>🛠️ Configurar Rifa</h2>

    <?php if (!empty($erros)): ?>
    <div class="erros">
        <?php foreach ($erros as $e): ?>
            <p><?= $e ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="">

        <div class="form-group">
            <label>📣 Nome da Campanha / Título da Rifa <span class="req">*</span></label>
            <input
                type="text"
                name="campanha"
                placeholder="Ex: Rifa Solidária – Festa Junina 2025"
                maxlength="80"
                value="<?= $campanha ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>🏆 Prêmio(s) que será(ão) Rifado(s) <span class="req">*</span></label>
            <textarea
                name="premios"
                placeholder="Ex: 1º Prêmio: Smart TV 55'&#10;2º Prêmio: Notebook&#10;3º Prêmio: Air Fryer"
                maxlength="300"
                required
            ><?= $premios ?></textarea>
        </div>

        <div class="form-group">
            <label>💰 Valor do Bilhete <span class="req">*</span></label>
            <div class="input-icon-wrap">
                <span class="prefix">R$</span>
                <input
                    type="text"
                    name="valor"
                    placeholder="Ex: 10,00"
                    maxlength="10"
                    value="<?= $valor ?>"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label>🎫 Quantidade de Bilhetes <span class="req">*</span></label>
            <select name="quantidade" required>
                <option value="">— Selecione —</option>
                <?php
                $opcoes = [10, 25, 50, 75, 100, 150, 200, 300, 500, 999];
                foreach ($opcoes as $op):
                    $sel = ($quantidade == $op) ? 'selected' : '';
                ?>
                <option value="<?= $op ?>" <?= $sel ?>><?= $op ?> bilhetes</option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="gerar" class="btn-gerar">
            🎟️ GERAR BILHETES
        </button>

    </form>
</div>

<?php else: ?>
<!-- ========== RESULTADO: BILHETES GERADOS ========== -->

<!-- Resumo da rifa -->
<div class="resumo">
    <h2>🎟️ <?= $campanha ?></h2>
    <div class="resumo-grid">
        <div class="resumo-item">
            <div class="label">🏆 Prêmio(s)</div>
            <div class="value" style="font-size:0.85rem; white-space:pre-line; color:#fff;"><?= $premios ?></div>
        </div>
        <div class="resumo-item">
            <div class="label">💰 Valor do Bilhete</div>
            <div class="value">R$ <?= $valor ?></div>
        </div>
        <div class="resumo-item">
            <div class="label">🎫 Total de Bilhetes</div>
            <div class="value"><?= $quantidade ?></div>
        </div>
        <div class="resumo-item">
            <div class="label">💵 Arrecadação Prevista</div>
            <div class="value" style="color:#48bb78;">
                R$ <?= number_format(
                    $quantidade * floatval(str_replace(',', '.', $valor)),
                    2, ',', '.'
                ) ?>
            </div>
        </div>
    </div>
</div>

<!-- Botões de ação -->
<div class="barra-acoes">
    <button class="btn-imprimir" onclick="window.print()">
        🖨️ Imprimir Bilhetes
    </button>
    <a href="index.php" class="btn-voltar">
        ↩ Nova Rifa
    </a>
</div>

<!-- Título da listagem -->
<div class="bilhetes-titulo">
    <span>📋 Listagem de bilhetes gerados:</span>
    <strong><?= $quantidade ?> bilhetes numerados</strong>
</div>

<!-- Grid dos bilhetes -->
<div class="bilhetes-grid">
    <?php
    // ─── Normaliza os prêmios para exibição curta dentro do bilhete ───
    $premios_linhas = explode("\n", $premios);
    $premio_curto   = trim($premios_linhas[0]);
    if (mb_strlen($premio_curto) > 45) {
        $premio_curto = mb_substr($premio_curto, 0, 45) . '…';
    }

    // ─── Gera cada bilhete ───
    for ($i = 1; $i <= $quantidade; $i++):
        $numero = str_pad($i, 3, "0", STR_PAD_LEFT);
    ?>
    <div class="bilhete">
        <!-- Badge diagonal -->
        <div class="bilhete-badge">Sorte!</div>

        <!-- Topo vermelho -->
        <div class="bilhete-topo">
            <span class="campanha-nome"><?= $campanha ?></span>
            <span class="estrelas">★★★</span>
        </div>

        <!-- Corpo com número -->
        <div class="bilhete-corpo">
            <div class="bilhete-numero"><?= $numero ?></div>
            <hr class="bilhete-divider">
            <div class="bilhete-premio-label">🏆 Prêmio</div>
            <div class="bilhete-premio"><?= $premio_curto ?></div>
        </div>

        <!-- Rodapé escuro -->
        <div class="bilhete-rodape">
            <div>
                <div class="valor-label">Valor</div>
                <div class="valor">R$ <?= $valor ?></div>
            </div>
            <div class="assinatura">
                Bilhete<br>Nº <?= $numero ?>
            </div>
        </div>
    </div>
    <?php endfor; ?>
</div>

<?php endif; ?>

<div class="page-footer">
    🎟️ Gerador de Rifas PHP &copy; <?= date('Y') ?> — Todos os bilhetes foram gerados automaticamente.
</div>

</body>
</html>