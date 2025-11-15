<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/attendance' => [[['_route' => 'app_attendance_index', '_controller' => 'App\\Controller\\AttendanceController::index'], null, ['GET' => 0], null, false, false, null]],
        '/attendance/new' => [[['_route' => 'app_attendance_new', '_controller' => 'App\\Controller\\AttendanceController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/api/clients' => [
            [['_route' => 'app_client_index', '_controller' => 'App\\Controller\\ClientController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_create', '_controller' => 'App\\Controller\\ClientController::create'], null, ['POST' => 0], null, false, false, null],
        ],
        '/client/programs' => [[['_route' => 'app_client_programs_index', '_controller' => 'App\\Controller\\ClientProgramsController::index'], null, ['GET' => 0], null, false, false, null]],
        '/client/programs/new' => [[['_route' => 'app_client_programs_new', '_controller' => 'App\\Controller\\ClientProgramsController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/client/session' => [[['_route' => 'app_client_session_index', '_controller' => 'App\\Controller\\ClientSessionController::index'], null, ['GET' => 0], null, false, false, null]],
        '/client/session/new' => [[['_route' => 'app_client_session_new', '_controller' => 'App\\Controller\\ClientSessionController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/eqipment' => [[['_route' => 'app_eqipment_index', '_controller' => 'App\\Controller\\EqipmentController::index'], null, ['GET' => 0], null, false, false, null]],
        '/eqipment/new' => [[['_route' => 'app_eqipment_new', '_controller' => 'App\\Controller\\EqipmentController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/payments' => [[['_route' => 'app_payments_index', '_controller' => 'App\\Controller\\PaymentsController::index'], null, ['GET' => 0], null, false, false, null]],
        '/payments/new' => [[['_route' => 'app_payments_new', '_controller' => 'App\\Controller\\PaymentsController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/programs' => [[['_route' => 'app_programs_index', '_controller' => 'App\\Controller\\ProgramsController::index'], null, ['GET' => 0], null, false, false, null]],
        '/programs/new' => [[['_route' => 'app_programs_new', '_controller' => 'App\\Controller\\ProgramsController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/session' => [[['_route' => 'app_session_index', '_controller' => 'App\\Controller\\SessionController::index'], null, ['GET' => 0], null, false, false, null]],
        '/session/new' => [[['_route' => 'app_session_new', '_controller' => 'App\\Controller\\SessionController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/trainers' => [[['_route' => 'app_trainers_index', '_controller' => 'App\\Controller\\TrainersController::index'], null, ['GET' => 0], null, false, false, null]],
        '/trainers/new' => [[['_route' => 'app_trainers_new', '_controller' => 'App\\Controller\\TrainersController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/a(?'
                    .'|ttendance/([^/]++)(?'
                        .'|(*:68)'
                        .'|/edit(*:80)'
                        .'|(*:87)'
                    .')'
                    .'|pi/clients/([^/]++)(?'
                        .'|(*:117)'
                    .')'
                .')'
                .'|/client/(?'
                    .'|programs/([^/]++)(?'
                        .'|(*:158)'
                        .'|/edit(*:171)'
                        .'|(*:179)'
                    .')'
                    .'|session/([^/]++)(?'
                        .'|(*:207)'
                        .'|/edit(*:220)'
                        .'|(*:228)'
                    .')'
                .')'
                .'|/eqipment/([^/]++)(?'
                    .'|(*:259)'
                    .'|/edit(*:272)'
                    .'|(*:280)'
                .')'
                .'|/p(?'
                    .'|ayments/([^/]++)(?'
                        .'|(*:313)'
                        .'|/edit(*:326)'
                        .'|(*:334)'
                    .')'
                    .'|rograms/([^/]++)(?'
                        .'|(*:362)'
                        .'|/edit(*:375)'
                        .'|(*:383)'
                    .')'
                .')'
                .'|/session/([^/]++)(?'
                    .'|(*:413)'
                    .'|/edit(*:426)'
                    .'|(*:434)'
                .')'
                .'|/trainers/([^/]++)(?'
                    .'|(*:464)'
                    .'|/edit(*:477)'
                    .'|(*:485)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        68 => [[['_route' => 'app_attendance_show', '_controller' => 'App\\Controller\\AttendanceController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        80 => [[['_route' => 'app_attendance_edit', '_controller' => 'App\\Controller\\AttendanceController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        87 => [[['_route' => 'app_attendance_delete', '_controller' => 'App\\Controller\\AttendanceController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        117 => [
            [['_route' => 'app_client_update', '_controller' => 'App\\Controller\\ClientController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_client_delete', '_controller' => 'App\\Controller\\ClientController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        158 => [[['_route' => 'app_client_programs_show', '_controller' => 'App\\Controller\\ClientProgramsController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        171 => [[['_route' => 'app_client_programs_edit', '_controller' => 'App\\Controller\\ClientProgramsController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        179 => [[['_route' => 'app_client_programs_delete', '_controller' => 'App\\Controller\\ClientProgramsController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        207 => [[['_route' => 'app_client_session_show', '_controller' => 'App\\Controller\\ClientSessionController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        220 => [[['_route' => 'app_client_session_edit', '_controller' => 'App\\Controller\\ClientSessionController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        228 => [[['_route' => 'app_client_session_delete', '_controller' => 'App\\Controller\\ClientSessionController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        259 => [[['_route' => 'app_eqipment_show', '_controller' => 'App\\Controller\\EqipmentController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        272 => [[['_route' => 'app_eqipment_edit', '_controller' => 'App\\Controller\\EqipmentController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        280 => [[['_route' => 'app_eqipment_delete', '_controller' => 'App\\Controller\\EqipmentController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        313 => [[['_route' => 'app_payments_show', '_controller' => 'App\\Controller\\PaymentsController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        326 => [[['_route' => 'app_payments_edit', '_controller' => 'App\\Controller\\PaymentsController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        334 => [[['_route' => 'app_payments_delete', '_controller' => 'App\\Controller\\PaymentsController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        362 => [[['_route' => 'app_programs_show', '_controller' => 'App\\Controller\\ProgramsController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        375 => [[['_route' => 'app_programs_edit', '_controller' => 'App\\Controller\\ProgramsController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        383 => [[['_route' => 'app_programs_delete', '_controller' => 'App\\Controller\\ProgramsController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        413 => [[['_route' => 'app_session_show', '_controller' => 'App\\Controller\\SessionController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        426 => [[['_route' => 'app_session_edit', '_controller' => 'App\\Controller\\SessionController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        434 => [[['_route' => 'app_session_delete', '_controller' => 'App\\Controller\\SessionController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        464 => [[['_route' => 'app_trainers_show', '_controller' => 'App\\Controller\\TrainersController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        477 => [[['_route' => 'app_trainers_edit', '_controller' => 'App\\Controller\\TrainersController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        485 => [
            [['_route' => 'app_trainers_delete', '_controller' => 'App\\Controller\\TrainersController::delete'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
