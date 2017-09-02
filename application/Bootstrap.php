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
		Yaf\Dispatcher::getInstance()->autoRender(FALSE);
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
	 * 载入数据库持久连接
	 */
    public function _initDB(Yaf\Dispatcher $dispatcher)
    {
    	$config = Yaf\Application::app()->getConfig()->toArray();
    	// ATTR_PERSISTENT 配置数据库 持久连接
    	$config['db']['option'] = array(PDO::ATTR_CASE => PDO::CASE_NATURAL,PDO::ATTR_PERSISTENT=>true);
        // \Yaf\Registry::set('db', new \Medoo\Medoo( $config['db'] ) );
        \Yaf\Registry::set('db', new \Medoo\Medoo( $config['db'] ) );
    }

    /**
	 * 载入session
	 */
	public function _initSession()
	{
		$config = Yaf\Application::app()->getConfig();
	    $session = null;
	    switch ($config->session->type) {
	        case 'redis':
	        	// $session = new \Vof\Session\Adapter\Redis([
	            $session = new \Phalcon\Session\Adapter\Redis([
	                "uniqueId"   => $config->session->unique,
	                "host"       => $config->redis->host,
	                "port"       => $config->redis->port,
	                // "auth"       => $config->redis->auth,
	                "persistent" => $config->redis->persistent, //数据库持久连接
	                "lifetime"   => $config->session->lifetime,
	                "prefix"     => $config->redis->prefix,
	                "index"      => $config->redis->index
	            ]);
	            break;
	        case 'file':
	        default:
	            // $session = new \Vof\Session\Adapter\Files([
	            $session = new \Phalcon\Session\Adapter\Files([
	                "uniqueId"   => $config->session->unique,
	            ]);
	            break;
	    }
	    if($session != null){
	        $session->start();
	    }
	    \Yaf\Registry::set('session', $session );
	}

	/**
	 * 载入cache
	 */
	public function _initCache()
	{
		$config  = Yaf\Application::app()->getConfig();
	    // $frontCache = new \Vof\Cache\Frontend\Data(
	    $frontCache = new \Phalcon\Cache\Frontend\Data(
	        [
	            "lifetime" => $config->cache->lifetime,
	        ]
	    );
	    $cache = null;
	    switch (strtolower($config->cache->type)) {
	        case 'memcached':
	            // $cache = new \Vof\Cache\Backend\Libmemcached(
	            $cache = new \Phalcon\Cache\Backend\Libmemcached(
	                $frontCache,
	                [
	                    "host" => $config->memcached->host,
	                    "port" => $config->memcached->port,
	                    "weight" => $config->memcached->weight,
	                    'statsKey' => '_YAF',
	                ]
	            );
	            break;
	        case 'redis':
	            // $cache = new \Vof\Cache\Backend\Redis(
	            $cache = new \Phalcon\Cache\Backend\Redis(
	                $frontCache,
	                [
	                    'host' => $config->redis->host,
	                    'port' => $config->redis->port,
	                    // 'auth' => $config->redis->auth,
	                    'persistent' => $config->redis->persistent, //数据库持久连接
	                    'index' => $config->redis->index,
	                    'prefix' => $config->redis->prefix,
	                    'statsKey' => '_YAF',
	                ]
	            );
	            break;
	        case 'mongo':
	            $server = sprintf("mongodb://%s:%d", $config->mongo->host, $config->mongo->port);
	            // $cache = new \Vof\Cache\Backend\Mongo(
	            $cache = new \Phalcon\Cache\Backend\Mongo(
	                $frontCache,
	                [
	                    'server' => $server,
	                    'db' => $config->mongo->db,
	                    'collection' => $config->mongo->collection,
	                ]
	            );
	            break;
	        case 'file':
	        default:
	            $dir = $config->application->cacheDir;
	            if (!is_dir($dir)) mkdir($dir, 0777, true);
	            // $cache = new \Vof\Cache\Backend\File(
	            $cache = new \Phalcon\Cache\Backend\File(
	                $frontCache,
	                [
	                    "cacheDir" => $dir,
	                ]
	            );
	            break;
	    }
	    \Yaf\Registry::set('cache', $cache );
	}

	/**
	 *  日志记录
	 */
	public function _initLogger()
	{
		$config = Yaf\Application::app()->getConfig();
	    $day = date('Ymd');
	    $dir = $config->application->logDir . $day;
	    if (!is_dir($dir)) mkdir($dir, 0777, true);
	    // $logger = new \Vof\Logger\Adapter\File($dir."/{$day}.log");
	    $logger = new \Phalcon\Logger\Adapter\File($dir."/{$day}.log");
	    \Yaf\Registry::set('log', $logger);
	}

}
