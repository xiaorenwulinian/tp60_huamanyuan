<?php

interface HandlerAdapter
{
    /**
     * 是否支持该适配器
     * @param $handler
     * @return mixed
     */
    public function supports($handler);

    /**
     * 该适配器进行适配处理
     * @param $handler
     * @return mixed
     */
    public function handler($handler);
}

/**
 * 多种适配器
 *
 * Class HttpHandlerAdapter       http请求，路由解析
 * Class AnnotationHandlerAdapter 注解
 *
 */

class  HttpHandlerAdapter implements  HandlerAdapter {
    public function supports($handler)
    {
        // TODO: Implement supports() method.
        return $handler instanceof HttpController;
    }

    public function handler($handler)
    {
        // TODO: Implement handler() method.
        $handler->doHttpHandler();
    }
}
class  AnnotationHandlerAdapter implements  HandlerAdapter {
    public function supports($handler)
    {
        // TODO: Implement supports() method.
        return $handler instanceof AnnotationController;
    }

    public function handler($handler)
    {
        // TODO: Implement handler() method.
        $handler->doAnnotationHandler();
    }
}

//多种Controller实现
 interface Controller {

}

class HttpController implements Controller {
    public function doHttpHandler() {
        print_r("==http...==<br/>");
    }
}


class AnnotationController implements Controller {
    public function doAnnotationHandler() {
        print_r("==annotation...==<br/>");
    }
}


class DispatcherServlet {
    public $handleAdapters;
    public function __construct()
    {
        $this->handleAdapters[] = new AnnotationHandlerAdapter();
        $this->handleAdapters[] = new HttpHandlerAdapter();
    }

    public function doDispatch($controller)
    {
        $adapter = $this->getHandler($controller);
        $adapter->handler($controller);

    }

    /**
     * 获取对应适配器类，如果不符合，返回 null
     * @param $controller
     * @return |null
     */
    public function getHandler($controller)
    {
        foreach ($this->handleAdapters as $adapter) {
            if ($adapter->supports($controller)) {
                return $adapter;
            }
        }
        return null;
    }
}

demo();
function demo() {
    //stucture_type/adapter/SpringMvc.php
    $dispatch = new DispatcherServlet();
    // 此处模拟SpringMVC从request取handler的对象，
    // 适配器可以获取到希望的Controller
//    $controller = new HttpController();
    $controller = new AnnotationController();
    $dispatch->doDispatch($controller);
}