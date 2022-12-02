<?php

namespace Controller;

use App\Router;

class AdminController
{
    public static function dashboardPage(Router $router)
    {
        $router->render("admin/DashboardPage", []);
    }
}