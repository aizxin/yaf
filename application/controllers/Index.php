<?php
/**
 * @name IndexController
 * @author 空
 */
class IndexController extends Yaf\Controller_Abstract {

    public function indexAction() {
        var_dump(\Yaf\Registry::get('config'));
        // \Yaf\Registry::get('cache')->save("my-data", [1, 2, 3, 4, 5]);
        // \Yaf\Registry::get('session')->set("data1", [1, 2, 3, 4, 5]);
        // \Yaf\Registry::get('log')->info('ddddsss');
        // $this->display("index");
    }
}
