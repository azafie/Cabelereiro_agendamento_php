# Sistema de Agendamento para Salão de Cabeleireiro 💇‍♀️

Este é um sistema simples e eficiente para gerenciar agendamentos de um salão de cabeleireiro. Ele permite que clientes agendem horários e fornece uma área administrativa para gerenciar os agendamentos.

---

## 📋 Funcionalidades

### Cliente:
- **Agendamento de Horários**: Escolha a data e o horário disponíveis no sistema.

### Administrador:
- **Visualização de Agendamentos**: Veja todos os horários agendados.
- **Controle de Status**:
  - Cancelado.
  - Concluído.
- **Exclusão de Agendamentos**: Remova registros diretamente pelo painel.

---

## ⚙️ Tecnologias Utilizadas

- **Linguagem**: PHP
- **Banco de Dados**: MySQL
- **Frontend**: HTML, CSS, Bootstrap
- **Outras**: JavaScript, jQuery

---

## 📂 Estrutura do Projeto

```plaintext
/ (raiz do projeto)
├── index.php                   # Página inicial para agendamento
├── fila.php                    # Visualização da fila
├── conexao.php                 # conexao com o banco e deve ser configurada 
├── processar_agendamento.php   # onde inseri no banco o agendamento do cliente
└── README.md                   # projeto 
├── admin/                      # Área administrativa
│   ├── index.php               # ainda não foi criado o menu e os link
│   ├── atualiza_status.php     # Alteração do status dos agendamentos se concluido cancelado ou pendente
│   ├── gerenciar_servicos.php  # onde coloca os serviços do salão como corte, escova e penteado ETC...
│   ├── lista_agendamentos.php  # vai esta na pagina index de entrada onde ve os clientes agendados
└── └──deletar.php              # Exclusão de agendamentos
