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
```

## Notas:

O banco de "Estados" e "Cidades" está atualizado de acordo com o último levantamento realizado pelo IBGE#2013.

As contas de acesso criadas automaticamente pelo carregamento de Data Fixtures são:

**Usuário:** *admin*

**Senha:** *123*

**Usuário:** *default*

**Senha:** *123*
