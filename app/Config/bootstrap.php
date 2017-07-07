<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

/**
 * Global User-Defined Functions
 */
function html($str, $strip_tags = true){
  return htmlentities($strip_tags? strip_tags($str) : $str, ENT_COMPAT | ENT_SUBSTITUTE, 'UTF-8');
}

function no_spaces($str) {
  return str_replace($str, " ","");
}

function get_html($url){
  ini_set('max_execution_time', 30);
  $c = curl_init($url);
  curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($c, CURLOPT_AUTOREFERER, true);
  curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
  //curl_setopt($c, CURLOPT_COOKIE, "key=val");
  //curl_setopt($c, CURLOPT_REFERER, $url);
  $html = curl_exec($c);
  if (curl_error($c))
    return "";
  curl_close($c);
  return $html;
}

// Find first regex match in html source code
function get_first_match($html, $regex){
  if(preg_match($regex, $html, $regs)){
    if(isset($regs[2]))
      return $regs; // multiple capture groups
    else
      return $regs[1];
  }
  return false;
}

// Used to find ALL occurrences, not just the first one
function get_all_matches($html, $regex){
  
  //debug($html);
  //debug($regex);
  
  preg_match_all($regex, $html, $result, PREG_PATTERN_ORDER);
  $matches = array();
  
  for ($i = 0; $i < count($result[0]); $i++) {
    $match = array();
    for ($j = 1; $j < count($result); $j++) {
      $match[$j] = $result[$j][$i];
    } 
    $matches[] = $match;
  }
  
  return $matches;
}

function get_phone($html) {
  $result = [];
  $rl_html = get_first_match($html, '/[cC][oO][nN][tT][aA][cC][tT]([\s\S]*)footer/');
  $patterns = [
    '/([2-9]\d{2}-\d{3}-\d{4})/', // 222-222-2222
    '/([2-9]\d{2}.\d{3}.\d{4})/', // 222.222.2222
    '/^(1?(-?\d{3})-?)?(\d{3})(-?\d{4})$/', // 7, 10, or 11 digits with or without hyphens
    '/(\+[\d]*[ \d()]*[()\d]* [\d]*[- ][0-9][0-9][0-9][0-9])/', // +44(0)371 423 2020
    //'/([0-9]( |-)?)?(\(?[0-9]{3}\)?|[0-9]{3})( |-)?([0-9]{3}( |-)?[0-9]{4}|[a-zA-Z0-9]{7})/', //1-(123)-123-1234 | 123 123 1234 | 1-800-ALPHNUM
    '/(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}/' //UK mobile number: 07222 555555 | (07222) 555555 | +44 7222 555 555
  ];
  
  /*
   * 1-800-463-3339 is FEDEX
   * 
   */ 
  
  $rl_html = ($rl_html == false) ? $html : $rl_html;
    foreach($patterns as $wal) {
      $res = get_all_matches($rl_html, $wal);
      foreach($res as $val) {
        if (strlen($val[1]) > 3 && !in_array($val[1], $result)) {
          array_push($result, $val[1]);
        }
      }
  }
  return $result;
}

function get_email($html) {
  $result = [];
  $rl_html = get_first_match($html, '/[cC][oO][nN][tT][aA][cC][tT]([\s\S]*)footer/');
  $rl_html = ($rl_html == false) ? $html : $rl_html;
  $patterns = [
    '/(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/',
    '/\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}/', // Simple pattern
    '/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/', //email address spec naming guidelines
  ];
  foreach($patterns as $wal) {
    $res = get_all_matches($rl_html, $wal);
    foreach($res as $val) {
      if (strlen($val[1]) > 3 && !in_array($val[1], $result)) {
        array_push($result, $val[1]);
      }
    }
  }
  return $result;
}

function get_tags($html) {
  $tag_list = ["acorn","adam tucker","adidas","adidas kampung","agl attilio giusti leombruni",
  "ahnu","alan payne","all black","allen edmonds","altra running","amiana","ankle strap","antelope",
  "arche","arcopedico","as98","asics","astral designs","ballerina","ballet","ballet shoe","basketball",
  "bast shoe","beach","beautifeel","bed|stu","beko baby","ben sherman","bernardo","bike","biker","bill blass",
  "birkenstock","blackstone","bloch","blowfish","blucher shoe","blundstone","boat","boat shoe","bogs",
  "bos & co","bostonian","bowling","brogan","brogue shoe","brook","brothel creeper","buck","bussola","camper",
  "cantabrian albarca","caterpillar footwear","chaco","chelsea","chelsea boot","chelsea crew","chocolat blu","chooka","chooze",
  "chopine","cienta","clark","cleat","climbing","climbing shoe","clog","cloud footwear","cole haan","comfort","conguito",
  "converse","corso como","court shoe","cowboy boot","cross country running shoe","cycling","cydwoq","dansko",
  "derby shoe","diabetes","diabetic shoe","dolce nome footwear","dolce vita","dori shoe","doc marten","dr marten",
  "doc marten","dress shoe","driving moccasin","dunham","earth","earth shoe","earthies","earthy","ecco","eileen fisher",
  "el naturalista","elevator shoe",
  "eric michael","espadrille","espadrilles","everybody","exercise","fantasy sandal","fashion boot","flip flop",
  "florsheim","fly london","football","footmate","franco sarto","free people","freshly picked","frye","fsny french soles ny",
  "gabor","galesh","gentle soul","giveh","gola","golf shoe","groundhog by bos & co","gym","h by hudson","haflinger",
  "hanna andersson","hispanita","hogl","hoka one one","huarache","hunter boot","igor","ipanema","jack rogers","jambu",
  "jazz shoe","jeffrey campbell","jelly shoe","jelly shoe","jerusalem sandal","jessica simpson kids","johnston & murphy",
  "joule","jumpsole","jutti","kalso earth shoe","kanna","ked","keen","kenneth cole reaction","kid express","kitten heel",
  "kolhapuri chappal","kork-ease","kung fu shoe","l'amour des pied","la canadienne","laidback london","lamo sheepskin",
  "lightweight","livie & luca","loafer","loafer","lotus shoe","louise et cie","lucky brand","luxary","marc joseph",
  "maritime","mark lemp classic","mary jane","me too","medical","men","mephisto","merrell","mia kid","mini melissa",
  "minnetonka","miz mooz","moccasin","mojari","monk shoe","morgan & milo","mule","munro","naked feet","naot","native",
  "naturino","neil m","new balance","nina","oboz","off the beaten track","oliberte","olukai","on running","onitsuka tiger",
  "opanak","opinga","organ shoe","orthopaedic footwear","over-the-knee boot","oxford","oxford shoe","pajar","pampootie",
  "paul mayer","pediped","pella moda","peranakan beaded slipper","peshawari chappal","peter kaiser shoe","pikolino","plae",
  "platform shoe","poetic licence","pointe shoe","pointed shoe","pointinini","rachel shoe","rainboot","rainbow sandal",
  "rebel","reef","remonte dorndorf","rieker","robeez","robert zur","rocker bottom shoe","rockport",
  "rockport cobb hill collection","rose petals by walking cradle","ruby slipper","running","russian boot","sabrina",
  "sacha london","saddle shoe","salewa","salt water by sun san","sam edelman","samuel hubbard","sandal","sandro moscoloni",
  "sanuk","saucony","sebago","see kai run","sesto meucci","seychelle","silver shoe","simple","skate","slingback",
  "slip-on shoe","slipon","slipper","smartwool","smoky mountain boot","sneaker","sneaker","snow boot","sorel",
  "spectator shoe","sperry top-sider","sport","spring step","steel-toe boot","step & stride","steve madden","stick on",
  "stick-on","stride rite","stuart weitzman","swedish hasbeen","swim","t-bar sandal","tamari","taos footwear",
  "tap shoe","teva","the flexx","the north face","thewhitebrand","thierry rabotin","thor-lo","tiger-head shoe",
  "timberland","toe shoe","toe warmer","toke","toms","trainer","trask","trotter","tsarouhi","tsukihoshi","turnshoe",
  "ugg","umi","under armour","vaneli","vans","venetian-style shoe","via lietto","vibram fivefinger","vionic",
  "vionic with orthaheel technology","volatile kid's","wader","walking cradle","winklepicker","wolverine",
  "women","woolrich","worishofer","wörishofer","yoga","ziera"];
    
    //add sports
    //google types of shoes
    /*
sort($tag_list);
$str = '["' . implode('","',array_unique($tag_list)) . '"]';
debug($str);
     * 
     */
    

    $result = [];
    foreach($tag_list as $val) {
      if (get_first_match($html, "/(".strtolower($val).')/i') !== false) {
        array_push($result, $val);
      }
    }
    return implode(", ",$result);
}

function get_contact_links($html) {
  $result = [];
  foreach(get_all_matches($html, '/<a href="([\S]*)">[\s]*[cC]ontact[\s\S]*\/a>/U') as $val) {
    if (!in_array($val[1], $result)) {
      array_push($result, $val[1]);
    }
  }
  return $result;
}

function get_description($html) {
  foreach (get_all_matches($html, '/<meta([\s\S]*)>/U') as $val) {
    if (strtolower(get_first_match($val[1], '/name=[\'"]([\s\S]*)[\'"]/U')) == 'description') {
      return get_first_match($val[1], '/content=[\'"]([\s\S]*)[\'"]/U');
    }
  }
  return "";
}

if(defined('FULL_BASE_URL') && substr(FULL_BASE_URL,0,5) == 'https') // load balancer hack
  $_SERVER['HTTPS'] = 'on';

$is_ssl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])? true : false;



