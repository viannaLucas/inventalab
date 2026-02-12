<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('PainelParticipante');
$routes->setDefaultMethod('site');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Atenção: Auto Routing melhorado está habilitado. Métodos públicos dos controladores
// ficam acessíveis conforme o padrão Controller/método/parâmetros, portanto não é
// necessário (nem desejado) registrar rotas explícitas para ações como Painel::doRecuperarSenha
// ou Painel::alterarSenha. Consulte a documentação interna antes de adicionar novas rotas.

$routes->get("/arquivooficina_arquivos/(.*)", "Painel::resource");
$routes->get("/produto_arquivos/(.*)", "Painel::resource");
$routes->get("/materialoficina_arquivos/(.*)", "Painel::resource");
$routes->get("/recursotrabalho_arquivos/(.*)", "Painel::publicResource");
$routes->get("/participante_arquivos/(.*)", "Painel::resource");
$routes->get("/evento_arquivos/(.*)", "Painel::publicResource");

$routes->get("/usuario_arquivos/(.*)", "Painel::resource");

$routes->get("/detalheEvento/(.*)", "PainelParticipante::detalheEvento");
