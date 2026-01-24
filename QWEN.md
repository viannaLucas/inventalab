# Projeto — Base em CodeIgniter 4

> Este repositório descreve um projeto construído sobre **CodeIgniter 4**, com controle de usuários, checagem centralizada de permissões e convenções padronizadas para módulos/funcionalidades. Use este README como guia para entender a arquitetura e para evoluir o sistema com segurança.

---

## 📚 Documentação Oficial

- **CodeIgniter 4 User Guide:** https://codeigniter.com/user_guide/  

> Todas as decisões de estrutura, configuração e rotas seguem o padrão recomendado pela documentação oficial do CodeIgniter 4.

---

## 🧱 Estrutura Geral do Projeto

A estrutura de pastas **segue o padrão do CodeIgniter 4**. Um esboço típico (pode variar conforme o setup do time) é:

```
/app
  /Config
  /Controllers
  /Entities
  /Models
  /Views
/public
  /assets        # JS/CSS/Plugins e arquivos do template da aplicação
/system
/writable
.env
composer.json
```

- **`public/assets`**: contém **bibliotecas JS**, **códigos JS**, **CSS** e **plugins** já utilizados no projeto usados no **template**.

---

## 🧭 Controladores e BaseController

- O **controlador padrão** é `Painel`, que **estende** `BaseController`.
- **Todos os controladores** do projeto **herdam** `BaseController`.
- No **construtor do `BaseController`**, é chamado o método **`verificarPermissao`** (da própria classe), responsável por:
  - Validar se o usuário **está logado**.
  - Conferir se o usuário **tem permissão** para acessar a **funcionalidade** atual (controller/método).

> Essa checagem centralizada garante consistência de segurança em toda a aplicação.

### Exemplo (ilustrativo, simplificado)
```php
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->verificarPermissao(); // valida login e autorização
    }

    protected function verificarPermissao(): void
    {
        // Implementação real faz:
        // 1) checagem de sessão/login
        // 2) mapeamento controller::metodo atual
        // 3) consulta das permissões do usuário (UsuarioEntity::PERMISSOES)
        // 4) nega/permite acesso conforme regras
    }
}
```

---

## 👤 Domínio de Usuários

O projeto já possui **controle de usuário** completo, com:
- **Controller** (ex.: `Usuario`)
- **Model** (ex.: `UsuarioModel`)
- **Entity** (ex.: `UsuarioEntity`)
- **Views** relacionadas

### `UsuarioEntity` e a matriz de permissões

Na classe `UsuarioEntity.php` existe a constante/variável **`PERMISSOES`** (array multidimensional) que **lista os Módulos do sistema**.  
Para **cada Módulo**, são descritas as **Funcionalidades** e, dentro de cada funcionalidade, os **métodos de controller autorizados** para o usuário, além de metadados:

- `metodos`: lista de métodos **`Controlador::metodo`** autorizados.
- `label`: nome exibido na UI (pode conter espaços e acentos).
- `descricao`: breve descrição do que a funcionalidade permite.
- `tipoAcesso`: tipo de acesso exigido (detalhes abaixo).

#### Exemplo — Módulo **Task** (sistema de controle de tarefas)
```php
private const PERMISSOES = [
    'Task' => [
        'alterar' => [
            'metodos'    => ['Task::alterar', 'Task::doAlterar'],
            'label'      => 'Alterar',
            'descricao'  => 'Permite alterar Task',
            'tipoAcesso' => 'usuario',
        ],
        'pesquisar' => [
            'metodos'    => ['Task::pesquisar', 'Task::doPesquisar'],
            'label'      => 'Pesquisar',
            'descricao'  => 'Permite Pesquisar Task',
            'tipoAcesso' => 'usuario',
        ],
        'cadastrar' => [
            'metodos'    => ['Task::cadastrar', 'Task::doCadastrar'],
            'label'      => 'Cadastrar',
            'descricao'  => 'Permite Cadastrar Task',
            'tipoAcesso' => 'usuario',
        ],
        'listar' => [
            'metodos'    => ['Task::listar'],
            'label'      => 'Listar',
            'descricao'  => 'Permite Listar Task',
            'tipoAcesso' => 'usuario',
        ],
        'excluir' => [
            'metodos'    => ['Task::excluir'],
            'label'      => 'Excluir',
            'descricao'  => 'Permite Excluir Task',
            'tipoAcesso' => 'usuario',
        ],
        // ... outras funcionalidades para Task
    ],
    // ... outros módulos e permissões
];
```
> **Interpretação**: `Task` é o **módulo**; suas **funcionalidades** são `alterar`, `cadastrar`, `pesquisar`, `listar` e `excluir` — cada uma controla o **whitelist** de métodos do controller `Task` que o usuário pode acionar.

### Convenção de nomenclatura `Controlador::metodo`
- A convenção usada é **`NomeDoControlador::nomeDoMetodo`**.
- Em geral, existem pares de métodos para **exibir a tela** e para **processar a ação** (prefixo `do...`).  
  - Ex.: `Task::pesquisar` (exibe UI) e `Task::doPesquisar` (processa a requisição).

> **Observação sobre acentuação**: no **índice** da funcionalidade usa-se chave **sem acento e sem espaço** (ex.: `'relatorio'`). As **labels** exibidas na UI podem ter acento (ex.: `'Relatório'`). Os **nomes reais de métodos** devem seguir a sintaxe válida de identificadores em PHP — se o seu projeto padroniza sem acentos nos métodos, use `Task::relatorio` e `Task::doRelatorio` (adapte conforme seu código).

### Adicionando uma nova funcionalidade (ex.: **Relatório** em `Task`)

1) **Editar/Adicionar** métodos no controller `Task` (e, se necessário, `Entities`, `Models` e/ou `Views`).  
2) **Cadastrar a funcionalidade** em `UsuarioEntity::PERMISSOES` no módulo `Task`:

```php
'relatorio' => [ // chave sem acento e sem espaço
    'metodos'    => ['Task::relatório', 'Task::doRelatório'],
    'label'      => 'Relatório',
    'descricao'  => 'Permite Excluir Task', // ajuste a descrição conforme a ação real
    'tipoAcesso' => 'usuario',
],
```

> **Lembrete**: ajuste a descrição para refletir o propósito real da funcionalidade (ex.: "Permite gerar relatórios de Task").  
> **Fluxo**: ao acessar `Task::relatório`, o `BaseController` checa se o usuário tem a permissão `Task > relatorio` (via `PERMISSOES`).

### Tipos de acesso

Documentados em `UsuarioEntity`:
```php
/**
 * Tipo de acessos:
 *   'publico' => acesso sem restrição de login e senha (ex.: tela de login)
 *   'global'  => todos os usuários logados possuem acesso; não há controle
 *               de permissão (ex.: Painel::home)
 *   'usuario' => acesso para usuários logados que possuem permissão para
 *               a funcionalidade
 *   'admin'   => acesso para usuários logados com permissão de usuário
 *               administrador "useradmin" (ex.: Usuario::cadastrar)
 */
```
- **publico**: áreas abertas (login, recuperação de senha, etc.).  
- **global**: páginas/recursos acessíveis a qualquer usuário autenticado.  
- **usuario**: requer autenticação **e** permissão específica na matriz.  
- **admin**: reservado a usuários com perfil **administrador** (`useradmin`).

---

## ✅ Checklist para criar ou evoluir uma funcionalidade

1. **Controller/Views/Model/Entity**
   - Criar/editar métodos no **Controller** (padrão `Exibir` vs `doAcao`).
   - Criar/editar **Views** necessárias.
   - Atualizar/introduzir **Models** e **Entities** (se aplicável).

2. **Permissões**
   - Atualizar `UsuarioEntity::PERMISSOES` com a nova funcionalidade.
   - Listar os métodos autorizados em `metodos`.
   - Definir `label`, `descricao` e `tipoAcesso` adequados.

3. **Acesso & Segurança**
   - Verificar se o fluxo passa pelo `BaseController::verificarPermissao`.
   - Validar testes de acesso com usuários com/sem permissão.

4. **Front-end**
   - Se necessário, incluir JS/CSS/Plugins em **`public/assets`**.
   - Atualizar UI para exibir **labels** e **ações** corretas.

---

## 🛡️ Por que centralizar a permissão no `BaseController`?

- **Consistência**: toda rota passa pela mesma validação.
- **Segurança**: reduz risco de endpoints sem proteção.
- **Manutenibilidade**: regras de permissão vivem num único lugar (`UsuarioEntity::PERMISSOES`), facilitando auditoria e evolução.

---

## 🗺️ Rotas e Convenções

- O projeto segue o **padrão de rotas do CodeIgniter 4** (vide User Guide).  
- A relação **controller::método** é usada para cruzar com as permissões em `UsuarioEntity`.

> Dica: mantenha as rotas coerentes com a convenção de nomes (`NomeDoControlador::nomeDoMetodo`) para simplificar a checagem de permissões.

---

## 🧩 Assets Front‑End

- Todo o material front‑end (JS/CSS/Plugins/Template) está em **`public/assets`**.
- Padronize a inclusão dos assets em **layouts** e **views** para garantir consistência visual e de performance.

---

## 💡 Referências Rápidas

- **Framework:** CodeIgniter 4  
- **Guia Oficial:** https://codeigniter.com/user_guide/  
- **Controller padrão:** `Painel extends BaseController`  
- **Permissões:** `UsuarioEntity::PERMISSOES` (módulos → funcionalidades → métodos)  
- **Checagem de acesso:** `BaseController::verificarPermissao()` (no construtor)
- **Front-end:** `public/assets` (JS, CSS, plugins, template)

---

> **Nota**: Exemplos de código foram simplificados para fins de documentação. Consulte as implementações reais no repositório para detalhes de tipos, namespaces e regras adicionais.

Código de Exemplo de regras de implementações em ./documentacao/codigoExemplos