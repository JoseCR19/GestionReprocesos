<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
  $router->post('/regi_usua','UsuarioController@regi_usua');



  $router->post('/validar_usuario','UsuarioController@validar_usuario');
  $router ->post('/actu_usua','UsuarioController@actu_usua');
  $router->post('/elim_usua','UsuarioController@elim_usua');
  $router->get('/list_usua','UsuarioController@list_usua');


 */

$router->post('/list_repr', 'ReprocesoController@list_reproceso');
$router->post('/list_elem', 'ReprocesoController@lista_elementos');
$router->post('/comb_codi', 'ReprocesoController@combo_codigos');
$router->post('/guar_repro', 'ReprocesoController@guardar_reproceso');
$router->get('/comb_moti', 'ReprocesoController@combo_motivo');
$router->post('/obtn_id_repr', 'ReprocesoController@obtn_id_repr');
$router->post('/actu_nombre_arch', 'ReprocesoController@actu_nombre_arch');
$router->post('/repr_deta', 'ReprocesoController@repr_deta');
$router->post('/anular_reproceso', 'ReprocesoController@anular_reproceso');
$router->post('/cabecera_reproceso', 'ReprocesoController@cabecera_reproceso');
$router->post('/inser_prueba', 'ReprocesoController@inser_prueba');

