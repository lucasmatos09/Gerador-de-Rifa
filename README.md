# 🎟️ Gerador de Rifas em PHP

## 📌 Descrição do Projeto

O **Gerador de Rifas em PHP** é uma aplicação web simples e eficiente que permite criar bilhetes de rifa numerados automaticamente, com visual moderno e pronto para impressão.

O sistema foi desenvolvido com foco em praticidade, sendo ideal para:

* Rifas solidárias
* Eventos escolares
* Igrejas e comunidades
* Campanhas beneficentes
* Promoções e sorteios

Com poucos dados preenchidos, o sistema gera uma grade completa de bilhetes organizados, estilizados e numerados sequencialmente.

---

## 🚀 Funcionalidades

### ✅ Formulário de configuração

O usuário pode definir:

* 📣 Nome da campanha/rifa
* 🏆 Prêmio(s)
* 💰 Valor do bilhete
* 🎫 Quantidade de bilhetes (até 999)

---

### ✅ Validação de dados

O sistema valida automaticamente:

* Campos obrigatórios não preenchidos
* Quantidade mínima e máxima de bilhetes
* Entrada segura com `htmlspecialchars()`

---

### ✅ Geração automática de bilhetes

* Numeração sequencial (001 até N)
* Layout profissional com:

  * Cabeçalho colorido
  * Número destacado
  * Prêmio resumido
  * Valor do bilhete
* Badge visual “SORTE!”
* Design responsivo

---

### ✅ Resumo da rifa

Antes dos bilhetes, o sistema exibe:

* Nome da campanha
* Lista de prêmios
* Valor unitário
* Quantidade total
* 💵 Arrecadação prevista (calculada automaticamente)

---

### ✅ Impressão otimizada

* Botão “🖨️ Imprimir Bilhetes”
* Layout adaptado para impressão
* Organização em grade (3 colunas)
* Remoção automática de elementos desnecessários

---

## 🛠️ Tecnologias Utilizadas

* **PHP (puro)** — lógica e processamento
* **HTML5** — estrutura
* **CSS3** — estilização avançada (gradientes, grid, responsividade)
* **JavaScript (básico)** — função de impressão (`window.print()`)

---

## 📂 Estrutura do Projeto

```
/projeto
│
├── index.php      # Arquivo principal (tudo em um)
└── README.md      # Documentação do projeto
```

---

## ⚙️ Como Executar o Projeto

### 🔹 Requisitos

* PHP 7.0 ou superior
* Servidor local (XAMPP, WAMP, Laragon, etc.)

---

### 🔹 Passo a passo

1. Coloque o arquivo `index.php` em uma pasta do seu servidor local
2. Inicie o servidor (Apache)
3. Acesse no navegador:

```
http://localhost/seu-projeto/
```

4. Preencha o formulário e clique em **GERAR BILHETES**

---

## 🎨 Interface e Design

O sistema possui:

* Tema escuro moderno com gradientes
* Destaques em dourado (#f5c518)
* Efeitos de hover e sombras
* Layout adaptável para diferentes telas

---

## 🧮 Lógica de Cálculo

### Arrecadação prevista:

```php
$quantidade * floatval(str_replace(',', '.', $valor))
```

* Converte o valor para formato numérico
* Multiplica pela quantidade de bilhetes
* Formata em padrão brasileiro (R$ 0,00)

---

## 🔢 Numeração dos Bilhetes

Os números são formatados com 3 dígitos:

```php
str_pad($i, 3, "0", STR_PAD_LEFT);
```

Exemplo:

* 1 → 001
* 25 → 025
* 300 → 300

---

## 🧩 Personalizações Possíveis

Você pode facilmente adaptar o projeto para:

* ✅ Adicionar logo da empresa
* ✅ Incluir QR Code nos bilhetes
* ✅ Exportar para PDF
* ✅ Salvar rifas no banco de dados
* ✅ Permitir múltiplos prêmios dinâmicos
* ✅ Gerar números aleatórios ao invés de sequenciais

---

## 🔒 Segurança

Medidas aplicadas:

* `htmlspecialchars()` para evitar XSS
* `trim()` para limpar entradas
* Conversão explícita de tipos

Sugestões futuras:

* Validação mais robusta de valores monetários
* Token CSRF
* Sanitização adicional

---

## 📈 Melhorias Futuras

* Sistema de login
* Histórico de rifas
* Download em PDF
* Integração com WhatsApp
* Personalização de cores/temas
* Upload de imagem da campanha

---

## 🐞 Possíveis Problemas

| Problema                       | Solução                        |
| ------------------------------ | ------------------------------ |
| Valor não calcula corretamente | Verificar uso de vírgula/ponto |
| Impressão desconfigurada       | Usar navegador atualizado      |
| Layout quebrado                | Verificar zoom do navegador    |

---

## 👨‍💻 Autor

Projeto desenvolvido por você ✨
Caso queira evoluir, esse projeto é uma excelente base para sistemas maiores.

---

## 📄 Licença

Este projeto é livre para uso e modificação.
Sinta-se à vontade para adaptar conforme sua necessidade.

---

## 💡 Considerações Finais

Este projeto demonstra bem:

* Manipulação de formulários em PHP
* Geração dinâmica de conteúdo
* Uso de CSS moderno
* Criação de uma ferramenta prática e real

É simples, mas extremamente útil — principalmente para quem precisa gerar rifas rapidamente sem depender de ferramentas externas.

---

Se quiser, posso te ajudar a transformar isso em:

* Sistema com banco de dados
* Versão SaaS
* App mobile
* Ou até vender como produto digital

Só me falar 👍
