Objetivo do Projeto
========================

Fornecer uma aplicação inicial para os projetos desenvolvidos pela Cekurte Sistemas que utilizam o esqueleto de uma aplicação Symfony 2 com os bundles devidamente configurados.

O Projeto pode ser criado da seguinte forma:

```bash
# composer create-project cekurte/symfony2 path/ 2.4.2.0
# cd path/
# bower install --allow-root
# php app/console doctrine:database:create
# php app/console doctrine:schema:update --force
# php app/console doctrine:fixtures:load --no-interaction
# php app/console assets:install --symlink web
```

### Como solucionar o problema de permissão dos diretórios app/cache e app/logs:



## Notas:

O banco de "Estados" e "Cidades" está atualizado de acordo com o último levantamento realizado pelo IBGE#2013.

As contas de acesso criadas automaticamente pelo carregamento de Data Fixtures são:

Usuário do Grupo Admin (ROLE_ADMIN):

- **Usuário:** *admin*
- **Senha:** *123*

Usuário do Grupo Default (ROLE_USER):

- **Usuário:** *default*
- **Senha:** *123*
