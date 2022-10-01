<<<<<<< HEAD
<?php

namespace app\core;

class Application
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }
=======
<?php

namespace app\core;

class Application
{
    public Router $router;

    public function __construct(
    ) {
        $this->router = new Router();
    }

    public function run()
    {
        $this->router->resolve();
    }
>>>>>>> b4ba3aa29e86d3303c720a870f651f813cdeb0b7
}