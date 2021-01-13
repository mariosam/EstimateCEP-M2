********************************************************************************
*** ESTIMATE CEP MODULE - READ ME (english)
********************************************************************************

*** Objectives

The purpose of this module is to estimate the value of shipping a product by post
showing the values on the product page.
As it does not take into account the number of items, nor the other items in the
shopping cart, the displayed value is only an estimate (not the final value).

*** Version 1.0.0

What we have in this version:
- freight calculation box on the products page;
- consultation via webservice on the post office website;
- possibility of including free shipping in the calculation results;
- storing the zip code in a cookie for self-filling when changing products;
- hiding the calculation box if the product does not have physical delivery;
- possibility to customize box and results using CSS;
- possibility to inform contract with post office;
- possibility to configure shipping box dimensions;
- possibility to choose which shipping methods you want to consult at the post office;

*** Tested

Version: 2.4.1 Open

PHP: 7.3.9

Theme: LUMA

*** Install

Move the <EstimateCep> folder to the directory:
app/code/MarioSAM/ (create the directory if it doesn't exist)

At the command prompt, Magento installation directory, type:
$ bin/magento module:enable MarioSAM_EstimateCep
$ bin/magento setup:upgrade
$ bin/magento cache:clean

Access the Magento panel and navigate to:
Stores > [Settings] Configuration > Mario SAM > C.E.P. Estimate

********************************************************************************
*** MODULO ESTIMATE CEP - LEIA ME (portugues)
********************************************************************************

*** Objetivos

Objetivo deste modulo é estimar o valor de envio de um produto pelos correios
mostrando os valores na pagina do produto.
Por nao levar em consideracao a quantidade de itens, nem os demais itens no
carrinho de compras, o valor apresentado é apenas uma estimativa (e nao o valor final).

*** Versao 1.0.0

O que temos nesta versao:
- caixa de calculo de frete na pagina dos produtos;
- consulta via webservice no site dos correios;
- possibilidade de incluir frete gratis nos resultados de calculo;
- armazenamento do cep em cookie para auto-preenchimento ao trocar de produto;
- ocultamento do box de calculo se o produto nao possuir entrega fisica;
- possibilidade de customizar caixa de consulta e resultados usando CSS;
- possibilidade de informar contrato com correios;
- possibilidade de configurar dimensoes de caixa de envio;
- possibilidade de escolher quais metodos de envio deseja consultar nos correios;

*** Testado

Versao: 2.4.1 Open

PHP: 7.3.9

Tema: LUMA

*** Instalacao

Mova a pasta <EstimateCep> para o diretorio:
app/code/MarioSAM/ (crie o diretorio se nao existir)

No prompt de comando, diretorio de instalacao do Magento, digite:
$ bin/magento module:enable MarioSAM_EstimateCep
$ bin/magento setup:upgrade
$ bin/magento cache:clean

Acesse o painel do Magento e navegue em:
Lojas > [Configuracao] Configuracoes > Mario SAM > C.E.P. Frete