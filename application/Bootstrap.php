<?php
/**
 * @name Bootstrap
 * @author desktop-om1fu1r\administrator
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */

class Bootstrap extends Yaf\Bootstrap_Abstract {

    public function _initConfig() {
		//把配置保存起来
		$config = Yaf\Application::app()->getConfig();
		\Yaf\Registry::set('config', $config);
	}

	public function _initPlugin(\Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(\Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}

	public function _initView(\Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的view控制器，例如smarty,firekylin
	}

	/**
	 * 加载vendor下的文件
	 */
	public function _initLoader()
	{
		\Yaf\Loader::import( APP_PATH . '/vendor/autoload.php' );
	}

	/**
	 * 公用函数载入
	 */
	public function _initFunction()
	{
		\Yaf\Loader::import( Yaf\Application::app()->getConfig()->application->directory .'/library/helper.php' );
	}

	/**
	 * 载入数据库
	 */
    public function _initDB(Yaf\Dispatcher $dispatcher)
    {
    	$config = Yaf\Application::app()->getConfig()->toArray();
    	$config['db']['option'] = array(PDO::ATTR_CASE => PDO::CASE_NATURAL);
        \Yaf\Registry::set('db', new \Medoo\Medoo( $config['db'] ) );
    }

}
