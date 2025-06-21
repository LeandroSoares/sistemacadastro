# Backlog de Funcionalidades - Sistema Iweoba

## Funcionalidades Sugeridas por Usuários

1. [x] Ajustar campo RG para aceitar três formatos: 99.999.999-X, 999.999.999-XX ou apenas dígitos.
   - **Concluído em 20/06/2025** 
2. [x] Corrigir a funcionalidade do form 'Orixás de Cabeça' pois depois de salvar ele registra no banco de dados mas não exibe na tela
   - **Concluído em 20/06/2025**
3. [x] os campos de telefone e celular devem aceitar as marcaras de telefone fixo ou celular, ou seja, (99) 9999-9999 ou (99) 99999-9999
   - **Concluído em 09/07/2024**
4. [x] Corrigir nome "Oxumaré" (garantir integridade dos nomes dos orixás)
   - **Concluído em 20/06/2025**
5. [ ] Permitir inclusão de novo orixá não listado (campo livre ou cadastro rápido)
   1. [ ] validar o crud de orixá
   2. [ ] criar testes unitarios para o crud de orixá
6. [ ] Permitir inclusão de novo curso não listado (campo livre ou cadastro rápido)
7. [ ] Permitir inclusão de novos mistérios (campo livre ou cadastro rápido)
8. [ ] Permitir editar e excluir mistérios já cadastrados
9. [ ] Permitir inclusão de múltiplos orixás iniciados
10. [ ] Permitir editar e excluir orixás iniciados
11. [ ] Permitir inclusão de múltiplas magias
12. [ ] Garantir que Orixás de Cabeça sejam salvos corretamente
13. [ ] Controle de permissões: usuários comuns veem apenas seus dados, admins veem todos
14. [ ] Permitir upload de fotos e arquivos (ex: apostilas nos cursos)
15. [ ] Exportar usuários cadastrados para Excel ou arquivo externo

Claro! Segue uma versão revisada, organizada e refatorada da especificação do módulo de cursos, incluindo sugestões para facilitar manutenção e evolução do sistema.

---

## Módulo de Cursos

### Regras de Negócio

#### 1. Listagem de Cursos
- A página principal de cursos exibe todos os cursos cadastrados no sistema.
- Ao lado do nome de cada curso, há um botão **"Inscrever-se"**.

#### 2. Inscrição em Cursos
- Ao clicar em **"Inscrever-se"**, o usuário é redirecionado para a página de inscrição do respectivo curso.
- Na página de inscrição, o usuário visualiza os detalhes do curso (nome, descrição, data de início, data de término, etc).
- O usuário pode confirmar a inscrição no curso.
- Após a inscrição, o usuário é adicionado à lista de inscritos do curso.

#### 3. Visualização de Cursos e Inscrições
- O usuário pode visualizar:
  - Detalhes completos do curso, incluindo lista de inscritos.
  - Todos os cursos em que está inscrito, em uma área específica do sistema (ex: "Meus Cursos").
- O usuário pode cancelar a inscrição em qualquer curso em que esteja inscrito.

#### 4. Lista de Inscritos
- A lista de inscritos de cada curso pode ser visualizada por usuários autorizados (definir regras de permissão, se necessário).

#### 5. Criação e Gestão de Cursos
- Deve ser possível criar um novo curso a partir do zero.
- Deve ser possível criar um novo curso como **cópia** de um curso já existente (incluindo a possibilidade de alterar dados, como datas e descrição, antes de salvar).
- Recomenda-se criar um novo curso a cada edição (exemplo: cursos anuais), para facilitar o gerenciamento, controle de inscrições e histórico.  
  - **Justificativa:** Evita aumento desnecessário de complexidade no desenvolvimento e manutenção, além de preservar o histórico de cada edição.

---

### Sugestões de Melhoria

- **Histórico de Edições:** Permitir visualizar edições passadas de um mesmo curso, mantendo o histórico de inscrições e detalhes.
- **Permissões:** Definir claramente quem pode criar, editar, copiar cursos e visualizar listas de inscritos.
- **Notificações:** Enviar notificações para usuários inscritos em caso de alterações importantes no curso (opcional).
- **Filtros e Busca:** Permitir busca e filtros na listagem de cursos (por nome, status, data, etc).

---

### Fluxos Principais

1. **Usuário acessa a página de cursos → visualiza lista → clica em "Inscrever-se" → visualiza detalhes → confirma inscrição → aparece em "Meus Cursos".**
2. **Usuário acessa "Meus Cursos" → visualiza detalhes → pode cancelar inscrição.**
3. **Administrador acessa gestão de cursos → pode criar novo curso (do zero ou como cópia) → define detalhes → curso fica disponível para inscrições.**
 
---

Este backlog foi gerado a partir de feedbacks reais de usuários e deve ser utilizado como base para priorização e planejamento das próximas sprints.
