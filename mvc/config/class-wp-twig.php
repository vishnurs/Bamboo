<?php

class WP_Twig {

    public function __call($function, $arguments) {

        if(!function_exists($function)) {
            return;
        }

        return call_user_func_array($function, $arguments);
    }

}
