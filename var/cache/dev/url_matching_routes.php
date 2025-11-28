<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/clients' => [
            [['_route' => '_api_/clients_get_collection', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => true, '_api_resource_class' => 'App\\Entity\\Client', '_api_operation_name' => '_api_/clients_get_collection', '_format' => null], null, ['GET' => 0], null, false, false, null],
            [['_route' => '_api_/clients_post', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => true, '_api_resource_class' => 'App\\Entity\\Client', '_api_operation_name' => '_api_/clients_post', '_format' => null], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_client_create', '_controller' => 'App\\Controller\\ClientController::create'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_client_index', '_controller' => 'App\\Controller\\ClientController::index'], null, ['GET' => 0], null, false, false, null],
        ],
        '/attendance' => [
            [['_route' => 'app_attendance_create', '_controller' => 'App\\Controller\\AttendanceController::create'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_attendance_get_collection', '_controller' => 'App\\Controller\\AttendanceController::getCollection'], null, ['GET' => 0], null, false, false, null],
        ],
        '/api/client/programs' => [
            [['_route' => 'app_client_programs_create', '_controller' => 'App\\Controller\\ClientProgramsController::create'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_client_programs_index', '_controller' => 'App\\Controller\\ClientProgramsController::index'], null, ['GET' => 0], null, false, false, null],
        ],
        '/client/session' => [
            [['_route' => 'app_client_session_create', '_controller' => 'App\\Controller\\ClientSessionController::create'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_client_session_index', '_controller' => 'App\\Controller\\ClientSessionController::index'], null, ['GET' => 0], null, false, false, null],
        ],
        '/api/eqipments' => [
            [['_route' => 'app_eqipment_index', '_controller' => 'App\\Controller\\EqipmentController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_eqipment_create', '_controller' => 'App\\Controller\\EqipmentController::create'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/payments' => [
            [['_route' => 'app_payments_index', '_controller' => 'App\\Controller\\PaymentsController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_payments_create', '_controller' => 'App\\Controller\\PaymentsController::create'], null, ['POST' => 0], null, false, false, null],
        ],
        '/programs' => [[['_route' => 'app_programs_index', '_controller' => 'App\\Controller\\ProgramsController::index'], null, ['GET' => 0], null, false, false, null]],
        '/programs/new' => [[['_route' => 'app_programs_new', '_controller' => 'App\\Controller\\ProgramsController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/api/sessions' => [
            [['_route' => 'app_session_index', '_controller' => 'App\\Controller\\SessionController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_session_create', '_controller' => 'App\\Controller\\SessionController::create'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/trainers' => [
            [['_route' => 'app_trainers_index', '_controller' => 'App\\Controller\\TrainersController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_trainers_create', '_controller' => 'App\\Controller\\TrainersController::create'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/a(?'
                    .'|pi(?'
                        .'|/(?'
                            .'|docs(?:\\.([^/]++))?(*:40)'
                            .'|\\.well\\-known/genid/([^/]++)(*:75)'
                            .'|validation_errors/([^/]++)(*:108)'
                        .')'
                        .'|(?:/(index)(?:\\.([^/]++))?)?(*:145)'
                        .'|/(?'
                            .'|c(?'
                                .'|ontexts/([^.]+)(?:\\.(jsonld))?(*:191)'
                                .'|lient(?'
                                    .'|s/([^/]++)(?'
                                        .'|(*:220)'
                                    .')'
                                    .'|/programs/([^/]++)(?'
                                        .'|(*:250)'
                                    .')'
                                .')'
                            .')'
                            .'|e(?'
                                .'|rrors/(\\d+)(?:\\.([^/]++))?(*:291)'
                                .'|qipments/([^/]++)(?'
                                    .'|(*:319)'
                                .')'
                            .')'
                            .'|validation_errors/([^/]++)(?'
                                .'|(*:358)'
                            .')'
                            .'|payments/([^/]++)(?'
                                .'|(*:387)'
                            .')'
                            .'|sessions/([^/]++)(?'
                                .'|(*:416)'
                            .')'
                            .'|trainers/([^/]++)(?'
                                .'|(*:445)'
                            .')'
                        .')'
                    .')'
                    .'|ttendance/([^/]++)(?'
                        .'|(*:477)'
                    .')'
                .')'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:515)'
                .'|/client/session/([^/]++)(?'
                    .'|(*:550)'
                .')'
                .'|/programs/([^/]++)(?'
                    .'|(*:580)'
                    .'|/edit(*:593)'
                    .'|(*:601)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        40 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => null, '_api_respond' => true], ['_format'], ['GET' => 0, 'HEAD' => 1], null, false, true, null]],
        75 => [[['_route' => 'api_genid', '_controller' => 'api_platform.action.not_exposed', '_api_respond' => true], ['id'], ['GET' => 0, 'HEAD' => 1], null, false, true, null]],
        108 => [[['_route' => 'api_validation_errors', '_controller' => 'api_platform.action.not_exposed'], ['id'], ['GET' => 0, 'HEAD' => 1], null, false, true, null]],
        145 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => null, '_api_respond' => true, 'index' => 'index'], ['index', '_format'], ['GET' => 0, 'HEAD' => 1], null, false, true, null]],
        191 => [[['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => true], ['shortName', '_format'], ['GET' => 0, 'HEAD' => 1], null, false, true, null]],
        220 => [
            [['_route' => '_api_/clients/{id}_get', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => true, '_api_resource_class' => 'App\\Entity\\Client', '_api_operation_name' => '_api_/clients/{id}_get', '_format' => null], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => '_api_/clients/{id}_patch', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => true, '_api_resource_class' => 'App\\Entity\\Client', '_api_operation_name' => '_api_/clients/{id}_patch', '_format' => null], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => '_api_/clients/{id}_delete', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => true, '_api_resource_class' => 'App\\Entity\\Client', '_api_operation_name' => '_api_/clients/{id}_delete', '_format' => null], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'app_client_show', '_controller' => 'App\\Controller\\ClientController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_client_update', '_controller' => 'App\\Controller\\ClientController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_client_delete', '_controller' => 'App\\Controller\\ClientController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        250 => [
            [['_route' => 'app_client_programs_update', '_controller' => 'App\\Controller\\ClientProgramsController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_client_programs_delete', '_controller' => 'App\\Controller\\ClientProgramsController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        291 => [[['_route' => '_api_errors', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => null, '_api_resource_class' => 'ApiPlatform\\State\\ApiResource\\Error', '_api_operation_name' => '_api_errors', '_format' => null], ['status', '_format'], ['GET' => 0], null, false, true, null]],
        319 => [
            [['_route' => 'app_eqipment_show', '_controller' => 'App\\Controller\\EqipmentController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_eqipment_update', '_controller' => 'App\\Controller\\EqipmentController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_eqipment_delete', '_controller' => 'App\\Controller\\EqipmentController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        358 => [
            [['_route' => '_api_validation_errors_problem', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => null, '_api_resource_class' => 'ApiPlatform\\Validator\\Exception\\ValidationException', '_api_operation_name' => '_api_validation_errors_problem', '_format' => null], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => '_api_validation_errors_hydra', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => null, '_api_resource_class' => 'ApiPlatform\\Validator\\Exception\\ValidationException', '_api_operation_name' => '_api_validation_errors_hydra', '_format' => null], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => '_api_validation_errors_jsonapi', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => null, '_api_resource_class' => 'ApiPlatform\\Validator\\Exception\\ValidationException', '_api_operation_name' => '_api_validation_errors_jsonapi', '_format' => null], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => '_api_validation_errors_xml', '_controller' => 'api_platform.symfony.main_controller', '_stateless' => null, '_api_resource_class' => 'ApiPlatform\\Validator\\Exception\\ValidationException', '_api_operation_name' => '_api_validation_errors_xml', '_format' => null], ['id'], ['GET' => 0], null, false, true, null],
        ],
        387 => [
            [['_route' => 'app_payments_show', '_controller' => 'App\\Controller\\PaymentsController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_payments_update', '_controller' => 'App\\Controller\\PaymentsController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_payments_delete', '_controller' => 'App\\Controller\\PaymentsController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        416 => [
            [['_route' => 'app_session_show', '_controller' => 'App\\Controller\\SessionController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_session_update', '_controller' => 'App\\Controller\\SessionController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_session_delete', '_controller' => 'App\\Controller\\SessionController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        445 => [
            [['_route' => 'app_trainers_show', '_controller' => 'App\\Controller\\TrainersController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_trainers_update', '_controller' => 'App\\Controller\\TrainersController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_trainers_delete', '_controller' => 'App\\Controller\\TrainersController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        477 => [
            [['_route' => 'app_attendance_update', '_controller' => 'App\\Controller\\AttendanceController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_attendance_delete', '_controller' => 'App\\Controller\\AttendanceController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        515 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        550 => [
            [['_route' => 'app_client_session_update', '_controller' => 'App\\Controller\\ClientSessionController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_client_session_delete', '_controller' => 'App\\Controller\\ClientSessionController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        580 => [[['_route' => 'app_programs_show', '_controller' => 'App\\Controller\\ProgramsController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        593 => [[['_route' => 'app_programs_edit', '_controller' => 'App\\Controller\\ProgramsController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        601 => [
            [['_route' => 'app_programs_delete', '_controller' => 'App\\Controller\\ProgramsController::delete'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
